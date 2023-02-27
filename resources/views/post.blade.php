<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="relative flex p-6 bg-white border-b border-gray-200">
                    {{ $forum->heading }}    
                    
                </div>
                <div class="relative flex p-6 bg-white border-b border-gray-200 text-sm font-medium text-left">
                    {{ $forum->content }} 
                    @if(Auth::user()->id == $forum->create_by)
                    <div class='absolute right-0 px-6 text-sm font-medium'>
                        <form action="{{ route('forums.destroy', $forum->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="font-medium text-red-600 dark:text-red-300 hover:underline">Delete</button>
                        </form>
                    </div>
                    @endif
                </div> 
            </div>
        </div>
    </div>         
</x-app-layout>
