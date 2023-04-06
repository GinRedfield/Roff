<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Exception;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // portfolio retrieval
        $user = Auth::user();
        $portfolio = Portfolio::where('user_id', $user['id'])->get();
        $portfolio_array = $portfolio->toArray();
        $search_tickers = array_column($portfolio_array, 'ticker');
        $portfolio_stocks = Stock::whereIn('ticker', $search_tickers)->orderBy('ticker')->get()->toArray();
        

        // tickers retrieval
        $all_stocks = Stock::all()->toArray();
        $all_tickers = array_column($all_stocks, 'ticker');

        // assemble all needed data
        $stocks['pf'] = $portfolio_stocks;
        $stocks['tks'] = $all_tickers;

        return view('stock')->with('stocks',$stocks);
        // return ($stocks);

    }

    /**
    * Dashboard Page
    *
    * @return \Illuminate\Http\Response
    */
    public function dashboard()
    {
        // portfolio retrieval
        $user = Auth::user();
        $portfolio = Portfolio::where('user_id', $user['id'])->get();
        $portfolio_array = $portfolio->toArray();
        $search_tickers = array_column($portfolio_array, 'ticker');
        // check if portfolio exists
        if($search_tickers) {
            // get data
            $portfolio_stocks = Stock::whereIn('ticker', $search_tickers)->get()->toArray();
            $stocks_report = array_column($portfolio_stocks, 'report_base_price');
            $stocks_predict = array_column($portfolio_stocks, '1_year_price');
            
            // calculate diff
            $stocks_return = [];
            foreach (array_keys($stocks_report + $stocks_predict) as $key) {
                $stocks_return[$key] = ($stocks_predict[$key] - $stocks_report[$key])/$stocks_report[$key];   
            }
            $average = array_sum($stocks_return)/count($stocks_return);
            $stocks['returns'] = array_combine(array_column($portfolio_stocks, 'ticker'), $stocks_return );
            // var_dump($stocks['returns']);
            
            // sort returns
            uasort($stocks['returns'], function($a, $b) {
                return $b <=> $a;
            });

            // get highest three and assumble everything
            $stocks['returns'] = array_slice($stocks['returns'], 0, 3);
            $stocks['tickers'] = array_keys($stocks['returns']);
            $stocks['returns'] = array_values($stocks['returns']);
            $stocks['average'] = $average;

        
            return view('dashboard')->with('stocks',$stocks);
            // return ($stocks);
        }else {
            return view('dashboard');
        }
        


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // first data retrieval
        $tk_input = $request->input('ticker');
        // stocks data retrieval
        $all_stocks = Stock::all()->toArray();
        $all_tickers = array_column($all_stocks, 'ticker');
        // portfolio data retrieval
        $all_portfolio = Portfolio::where('user_id', Auth::id())->get();
        $all_portfolio_array = $all_portfolio->toArray();
        $all_portfolio_tks = array_column($all_portfolio_array, 'ticker');

        // if stks in database
        if(in_array(strtoupper($tk_input), $all_tickers)) {
            // if already exist in portfolio
            if(in_array(strtoupper($tk_input), $all_portfolio_tks)){
                return redirect()->route('stocks.index');
            // else add new portfolio
            }else {
                $newPorfolio = new Portfolio();
                $newPorfolio->ticker = $request->input('ticker');
                $newPorfolio->user_id = Auth::id();
                $newPorfolio->save(['timestamps' => false]);
                return redirect()->route('stocks.index');
            }
        // if not call API and python
        }else {
            // call api for fundamental data
            $client = new \GuzzleHttp\Client();       
            $response = $client->request('GET', "https://backend.simfin.com/api/v3/companies/statements/compact?ticker={$tk_input}&statements=DERIVED&period=FY", [
                'headers' => [
                'Authorization' => 'api-key x0vFKNQksr360XeBTxrvywTWptVAbT8u',
                'accept' => 'application/json',
                ],
            ]);
            //  get data and organize them for dnn model input
            $cli_res = json_decode($response->getBody(), true);
            if($cli_res){
                $ml_input = array();
                $search = [
                    'Report Date',
                    'EBITDA', 
                    'Gross Profit Margin', 
                    'Operating Margin', 
                    'Net Profit Margin', 
                    'Return on Assets',
                    'Free Cash Flow to Net Income',
                    'Earnings Per Share, Diluted',
                    'Return On Invested Capital'
                ];
                // translate json to array for dnn model input
                foreach($search as $sr){
                    $key = array_search($sr, $cli_res[0]['statements'][0]['columns']);
                    $ml_input[$sr] = end($cli_res[0]['statements'][0]['data'])[$key];
                }
                // save report date first
                $report_date = $ml_input['Report Date'];
                // call API again to get price data
                $response_price = $client->request('GET', "https://backend.simfin.com/api/v3/companies/prices/compact?ticker={$tk_input}&ratios=false&asreported=false&start={$ml_input['Report Date']}", [
                    'headers' => [
                      'Authorization' => 'api-key x0vFKNQksr360XeBTxrvywTWptVAbT8u',
                      'accept' => 'application/json',
                    ],
                ]);

                // get adj price
                $cli_res_price = json_decode($response_price->getBody(), true);
                $ml_input['Adjusted Close'] = $cli_res_price[0]['data'][0][4];

                // check if null exists in ml_input to avoid failure
                if(in_array(null, $ml_input, true)){
                    return redirect()->back()->with('alert', 'Lack of reported data, aborting!');
                }else{
                    // finish and write to csv
                    unset($ml_input["Report Date"]);
                    $fp = fopen(public_path()."/roff_model/csvs/pred_features.csv", 'w');
                    fputcsv($fp,$ml_input);
                    fclose($fp);

                    // running python and predict using the csv
                    $process = new Process(['python', public_path().'/roff_model/Model_Controller.py'], 
                    null,
                    ['SYSTEMROOT' => getenv('SYSTEMROOT'), 'PATH' => getenv("PATH")]);
                    $process->run();
                    // exception handler
                    if (!$process->isSuccessful()) {
                        throw new ProcessFailedException($process);
                    }
                    $pred_str = $process->getOutput();
                    $pred_str=str_replace("\r\n","",$pred_str);
                    $pred = floatval($pred_str);
                    // save to database
                    $newStock = new Stock();
                    $newStock['ticker'] = strtoupper($tk_input);
                    $newStock['report_base_price'] = $ml_input['Adjusted Close'];
                    $newStock['1_year_price'] = $pred;
                    $newStock['report_date'] = $report_date;
                    $newStock->save();
                    // also add to portfolio
                    $newPorfolio = new Portfolio();
                    $newPorfolio->ticker = strtoupper($tk_input);
                    $newPorfolio->user_id = Auth::id();
                    $newPorfolio->save(['timestamps' => false]);
                    return redirect()->route('stocks.index');
                }

            }else{
                // if api returns null then abort
                return redirect()->back()->with('alert', 'Company not found!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findorFail($id)->toArray();
        $ticker = $stock['ticker'];
        $prt_del = Portfolio::where('user_id', Auth::id())
            ->where('ticker', $ticker)
            ->get()
            ->toArray();
        $id = $prt_del[0]['id'];
        // return($id);
        Portfolio::destroy($id);
        return redirect()->route('stocks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 
    }
}
