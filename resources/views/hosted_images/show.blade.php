<x-app-layout>

    {{-- Material design icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    {{-- Edit button will change href to include edit=1 query, and if editing is detected in route request then editing var becomes enabled --}}
    @php
        $editing = request('edit') == 1;
    @endphp

    <section class="grid w-full p-6 gap-y-6 grid-cols-1 sm:grid-cols-[1fr,33%,1fr]  sm:gap-x-6">

        {{-- Image and title --}}
        <div class="col-start-1 sm:col-start-2 w-full mx-auto">
            <div class="grid gap-3 p-6 sm:p-6 rounded-md bg-zinc-800 overflow-hidden">

                {{-- Title container --}}
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
                <div id="img_container" class="relative aspect-[3/4] max-h-[475px] overflow-hidden rounded-md w-full bg-zinc-900">
                    {{-- Image overlay --}}
                    <div id="img_overlay" class="absolute bottom-2 right-2 p-1 bg-zinc-900 rounded-md opacity-50 hover:opacity-100 transition ease-in-out duration-150 leading-none z-10">
                        <a target="_blank" href="{{ asset('storage/' . $image->path) }}" class="material-symbols-outlined w-6 h-6 leading-none flex items-center justify-center">zoom_out_map</a>
                    </div>

                    <img 
                        src="{{ asset('storage/' . $image->path) }}" 
                        alt="{{ $image->file_name }}" 
                        class="absolute inset-0 w-full h-full object-contain"
                    >
                </div>

            </div>
        </div>

        {{-- Likes --}}
        @auth
            <div class="p-3 bg-indigo-400 col-start-1 sm:col-start-1 flex justify-between sm:row-start-1 sm:flex-col sm:justify-self-end h-min sm:justify-center sm:self-center rounded-md gap-1.5">
                <h1 class="font-bold text-gray-900">.like the image?</h1>
                <button class="material-symbols-outlined text-gray-800">
                    favorite
                </button>
            </div>
        @endauth

        {{-- Details and controls --}}
        <div class="grid gap-3 p-6 w-full sm:p-6 justify-self-center rounded-md bg-zinc-800 col-start-1 sm:col-start-2">
            <div id="upload_details">
                <p>Size: {{ $image->file_size }} bytes - Type: {{ $image->file_type }}</p>
                <p>Uploaded by: {{ $image->user->name }}</p>
            </div>
        
            <div class="flex flex-col gap-3 w-full">
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
