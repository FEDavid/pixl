<x-app-layout>

    {{-- Material design icon --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=zoom_out_map" />

    {{-- Edit button will change href to include edit=1 query, and if editing is detected in route request then editing var becomes enabled --}}
    @php
        $editing = request('edit') == 1;
    @endphp

    <section class=" grid w-full p-6">
        <div class="grid gap-3 p-6 w-full sm:w-1/3 sm:p-6 justify-center justify-self-center rounded-md bg-zinc-800">
        
        <div>
            {{-- Change title whether editing or not --}}
            <h1 class="text-2xl font-bold text-indigo-400">
                {{ $editing ? '.edit image' : '.view image' }}
            </h1>

            {{-- If editing we will show an input form to change the file name, otherwise it will simply show files name --}}
            @if ($editing)
                <form method="POST" action="{{ route('uploads.update', $image->id) }}">
                    @csrf
                    @method('PUT')

                    <input 
                        type="text" 
                        name="file_renamed"
                        value="{{ old('file_renamed', $image->file_renamed) }}"
                        class="w-full px-3 py-1 rounded bg-zinc-700 text-white mt-3"
                    >

                    <button 
                        type="submit"
                        class="w-full h-full text-center py-1 bg-indigo-400 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 rounded-md mt-3"
                    >
                        Save Changes
                    </button>
                </form>
            @else
                <h1>{{ $image->file_renamed }}</h1>
            @endif

        </div>

        {{-- Image container --}}
        <div id="img_container" class="relative">
            {{-- Image overlay --}}
            <div id="img_overlay" class="absolute bottom-2 right-2 p-1 bg-zinc-900 rounded-md opacity-50 hover:opacity-100 transition ease-in-out duration-150 leading-none">
                <a target="_blank" href="{{ asset('storage/' . $image->path) }}" class="material-symbols-outlined w-6 h-6 leading-none flex items-center justify-center">zoom_out_map</a>
            </div>

            <img 
                src="{{ asset('storage/' . $image->path) }}" 
                alt="{{ $image->file_name }}" 
                class="w-full rounded-sm"
            >
        </div>

        <div id="upload_details">
            <p>Size: {{ $image->file_size }} bytes</p>
            <p>Type: {{ $image->file_type }}</p>
            <p>Uploaded by: {{ $image->user->name }}</p>
        </div>
        
        <div class="flex flex-col gap-3">
            <a href="{{ route('uploads.index') }}" class="w-full h-full text-center py-1 bg-indigo-400 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 rounded-md">Back</a>
            {{-- If the user_id of logged in user matches the image's user_id foreign key, show delete button, otherwise just show back button --}}
            @if (auth()->id() === $image->user_id)

                {{-- Edit button --}}
                @if (!$editing)
                    <a href="{{ route('uploads.show', $image->id) }}?edit=1" class="cursor-pointer w-full h-full text-center py-1 bg-indigo-400 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 rounded-md">Edit</a>
                @else
                <a href="{{ route('uploads.show', $image->id) }}" class="text-center cursor-pointer w-full h-full py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Cancel editing</a>
                @endif

                {{-- Delete button --}}
                @csrf
                @method('delete')
                <input type="submit" value="Delete" class="cursor-pointer w-full h-full py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
            
            @endif
        </div>

        </div>
    </section>

</x-app-layout>
