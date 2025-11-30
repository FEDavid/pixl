<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Quick little JS script to toggle hidden for collapsible sections. Passing in id for section we want collapsed, toggles hidden tailwind to hide/show --}}
    <script>
        function toggleSection(id) {
            const el = document.getElementById(id);
            el.classList.toggle('hidden');

            // Changing material icon
            document.getElementById('collapse_icon').classList.toggle('hidden');
            document.getElementById('expand_icon').classList.toggle('hidden');

            // Toggling margin while collapsed
            document.getElementById('header_toggle').classList.toggle('mb-3')
        }
    </script>

    {{-- Material icon --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    {{-- Dashboard content --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6">

        {{-- Logged in confirmation --}}
        <div class="bg-indigo-400 overflow-hidden shadow-sm sm:rounded-lg font-bold sm:mt-6">
            <div class="p-6 text-gray-900">
                {{ __(".you're logged in!") }}
            </div>
        </div>

        {{-- Users images --}}
        <div class="sm:rounded-lg p-3 bg-zinc-700">
            <button id="header_toggle" class="p-6 bg-indigo-300 overflow-hidden rounded-lg font-bold text-gray-900 mb-3 w-full text-left flex justify-between" onclick="toggleSection('user-images-section')"><p>.your images</p><span id="collapse_icon" class="material-symbols-outlined">collapse_content</span><span id="expand_icon" class="material-symbols-outlined hidden">expand_content</span></button>
            <div id="user-images-section" class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] justify-start gap-3">
                @foreach ($hostedImages as $hostedImage)
                    <li value="{{ $hostedImage->id }}" class="text-white bg-zinc-800 flex flex-col rounded-lg text-ellipsis hover:opacity-50 transition ease-in-out duration-150 w-full">
                        
                        {{-- Wrapping content in link --}}
                        <a href="{{ route('uploads.show', $hostedImage->id) }}" class="aspect-square w-full overflow-hidden h-[250px] sm:h-[300px]">
                            {{-- Image --}}
                            <img 
                                class="w-full h-[250px] sm:h-[300px] object-cover"
                                src="{{ asset('storage/' . $hostedImage->path) }}"
                            >
                        </a>

                        <div class="p-3">
                            {{-- Name --}}
                            <p class="truncate w-full content-center">{{ $hostedImage->file_renamed }}</p>

                            {{-- Likes --}}
                            <p class="truncate w-full content-center">{{ $hostedImage->likes()->count() }} likes</p>
                        </div>
                    </li>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
