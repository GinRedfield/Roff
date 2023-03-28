<x-app-layout>
<script>
    // parsing variable to javascript file
    // can be used for search sugguestion feature
    var parsing_var = {message: <?php echo json_encode($stocks['tks'], JSON_HEX_TAG); ?>};
    var msg = '{{Session::get("alert")}}';
    var exist = '{{Session::has("alert")}}';
    if(exist){
      alert(msg);
    }
</script>
<div class="py-12">

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex">
                    <div class="relative w-full">
                        <form method="POST" action="{{ route('stocks.store') }}">
                            @csrf
                            <input name="ticker" type="text" id="search-dropdown" class="rounded-lg block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Enter stock ticker (e.g., AAPL), please not the if the stock is not present in our database the time of retriving result may take longer to complete..." required>
                            <button class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-gray-900 rounded-r-lg border border-gray-900 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl pt-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Ticker
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Report Date Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    1 Year Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks['pf'] as $data) 
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $data['ticker'] }}
                                </th>
                                <td class="px-6 py-4">
                                ${{ $data['report_base_price'] }}
                                </td>
                                
                                <td class="px-6 py-4">
                                ${{ $data['1_year_price'] }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('stocks.update', $data['id']) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <button class="font-medium text-red-600 dark:text-red-300 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>


</x-app-layout>
