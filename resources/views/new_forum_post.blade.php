<x-app-layout>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form class="mx-auto max-w-7xl p-6" method="POST" action="{{ route('forums.store') }}">
                    @csrf
                    <div class="py-2">
                        <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" name="heading" value="" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="50" placeholder="Maximum 50 charaters">
                    </div>
                    <div class="py-2">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your message</label>
                        <textarea name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write description here..."></textarea>
                    </div>
                    <input type="hidden" name="create_by" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="username" value="{{ Auth::user()->name }}">
                    <div class="py-2">
                        <button class="text-blue-600 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>       
</x-app-layout>
