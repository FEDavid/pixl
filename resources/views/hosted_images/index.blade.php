<x-app-layout>
    <div class="flex w-full">
       
        <ul class="w-full max-w-[1400px] grid gap-6 p-6 grid-cols-[repeat(auto-fill,minmax(200px,1fr))] @auth pt-6 @endauth">

            {{-- Success upload message --}}
            @if (session('success'))
                <div class="bg-green-200 text-green-900 p-3 rounded grid justify-center content-center">
                    {{ session('success') }}
                </div>
            @endif

            @foreach ($hostedImages as $hostedImage)
                <li value="{{ $hostedImage->id }}" class="text-white bg-zinc-800 flex flex-col rounded-lg text-ellipsis hover:opacity-50 transition ease-in-out duration-150">
                    
                    {{-- Wrapping content in link --}}
                    <a href="{{ route('uploads.show', $hostedImage->id) }}">
                        {{-- Image --}}
                        <img 
                            class="rounded-t-lg w-full h-40 object-cover"
                            src="{{ asset('storage/' . $hostedImage->path) }}"
                        >

                        {{-- Name --}}
                        <p class="truncate w-full p-3">{{ $hostedImage->file_renamed }}</p>
                    </a>

                    {{-- Buttons
                    @auth
                        <div class="flex w-full">
                            <form method="POST"
                                action='{{ url("/uploads/{$hostedImage->id}/edit") }}'
                                class="w-full text-center">
                                @csrf
                                @method('get')
                                <input type="submit" value="Edit" class="w-full h-full py-1 bg-indigo-400 border border-transparent rounded-l-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            </form>
                            <form method="POST"
                                  action='{{ url("/uploads/{$hostedImage->id}") }}'
                                  class="w-full text-center">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Delete" class="w-full h-full py-1 bg-red-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            </form>
                        </div>
                    @endauth --}}

                </li>
            @endforeach
        </ul>

        @if (session('operation'))
            {{ session('operation') }} {{ session('id') }}
        @endif

    </div>
</x-app-layout>
