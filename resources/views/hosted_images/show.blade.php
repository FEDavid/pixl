<x-app-layout>
    <section class=" grid w-full p-6">
        <div class="grid gap-6 p-6 w-full sm:w-1/3 sm:p-12 sm:mt-6 justify-center justify-self-center rounded-md bg-zinc-800">
        
        <div>
            <h1 class="text-2xl font-bold text-indigo-400">.edit image</h1>
            <h1>{{ $image->file_name }}</h1>
        </div>

        <img 
            src="{{ asset('storage/' . $image->path) }}" 
            alt="{{ $image->file_name }}" 
            class="w-full"
        >
        <div id="upload_details">
            <p>Size: {{ $image->file_size }} bytes</p>
            <p>Type: {{ $image->file_type }}</p>
            <p>Uploaded by: {{ $image->user->name }}</p>
        </div>
        
        <div class="flex justify-between">
            <a href="{{ route('uploads.index') }}" @class(['w-full h-full text-center py-1 bg-indigo-400 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150','rounded-md' => !auth()->check(),'rounded-l-md' => auth()->check()])>Back</a>
            {{-- If the user_id of logged in user matches the image's user_id foreign key, show delete button, otherwise just show back button --}}
            @if (auth()->id() === $image->user_id)
                    @csrf
                    @method('delete')
                    <input type="submit" value="Delete" class="w-full h-full py-1 bg-red-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
            @endif
        </div>

        </div>
    </section>

</x-app-layout>
