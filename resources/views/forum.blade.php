<x-app-layout>
    <div class="py-12">
        
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="relative flex p-6 bg-white border-b border-gray-200">
                    
                    <div class='left-0'>
                        Message Board
                    </div>
                    <!-- onchange="javascript:location.href = this.value;" -->
                    
                    <div class='absolute inset-y-0 right-0 px-6 py-4'>
                        
                        <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-md text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Action button</span>
                            Actions
                            <!-- <svg class="w-3 h-3 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> -->
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                <li>
                                    <form action="{{ route('forums.indexView') }}" method="POST">
                                        @csrf
                                        <label for="sort" class="hidden block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                        <input type="text" name="sort" value="1" class="hidden block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <button class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sort by Views</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('forums.indexView') }}" method="POST">
                                        @csrf
                                        <label for="sort" class="hidden block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                        <input type="text" name="sort" value="2" class="hidden block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <button class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sort By Time</button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('forums.create') }}" class = 'block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white'>New Post</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class='py-1 bg-gray-100'></div>

                @foreach($forums as $data) 
                <div class="relative mt-2 flex p-6 bg-white border-b border-gray-200 text-sm font-medium text-left rounded">
                    <a href="{{ route('forums.show', $data['id']) }}" class="overflow-hidden truncate w-2 text-sm text-gray-700 dark:text-gray-500">
                        {{ $data['heading'] }}
                    </a>
                    &nbsp;&nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg> 
                    {{ $data['views'] }}
                    @if(Auth::user()->id == $data['create_by'])
                    <div class='absolute right-0 px-6 text-sm font-medium'>
                        <form action="{{ route('forums.destroy', $data['id']) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="font-medium text-red-600 dark:text-red-300 hover:underline">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach

            </div>
        </div>
    </div>
    
    <div class="p-6 bg-white border-b border-gray-200 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <a href="{{ route('stocks.create') }}">Python Test</a>
    </div>
            
</x-app-layout>
