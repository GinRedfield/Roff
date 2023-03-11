<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="relative flex p-6 bg-white border-b border-gray-200">
                    {{ $forum->heading }}    
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
                                    <a href="{{ route('forums.index') }}" class = 'block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white'>Go Back</a>
                                </li>
                                @if(Auth::user()->id == $forum->create_by)
                                <li>
                                    <form action="{{ route('forums.destroy', $forum->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="block px-6 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-300">Delete</button>
                                    </form>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class='py-1 bg-gray-100'></div>
                <div class="relative flex p-6 bg-white border-b border-gray-200 text-sm font-medium text-left">
                    {{ $forum['content'] }} 
                    
                </div> 
            </div>
        </div>
    </div>  
</x-app-layout>
