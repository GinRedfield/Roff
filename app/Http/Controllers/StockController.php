<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $portfolio = Portfolio::where('user_id', $user['id'])->get();
        $portfolio_array = $portfolio->toArray();
        $tickers = array_column($portfolio_array, 'ticker');
        $stocks = Stock::whereIn('ticker', $tickers)->get();
        return view('stock')->with('stocks',$stocks);
        // return ($stocks);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // running python
        $process = new Process(['python', public_path().'/roff_model/Model_Controller.py'], 
        null,
        ['SYSTEMROOT' => getenv('SYSTEMROOT'), 'PATH' => getenv("PATH")]);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        return $process->getOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
