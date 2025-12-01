<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6 pt-6">

        {{-- Quick little JS script to toggle hidden for collapsible sections. --}}
        {{-- Passing in id for section we want collapsed, toggles hidden tailwind to hide/show --}}
        <script>
            function toggleSection(id) {
                const el = document.getElementById(id);
                el.classList.toggle('hidden');

                // Changing material icon
                document.getElementById('collapse_icon').classList.toggle('hidden');
                document.getElementById('expand_icon').classList.toggle('hidden');
            }
        </script>

        {{-- Material icon --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        {{-- Filter options --}}
        <section class="p-3 bg-zinc-700 rounded-xl grid gap-3">
            filters and stuff
        </section>

        {{-- User accounts --}}
        <section class="p-3 bg-zinc-700 rounded-xl grid gap-3">
            <button id="header_toggle" class="p-6 bg-indigo-300 overflow-hidden rounded-lg font-bold text-gray-900 w-full text-left flex justify-between" onclick="toggleSection('user_accounts')"><p>.user accounts</p><span id="collapse_icon" class="material-symbols-outlined">collapse_content</span><span id="expand_icon" class="material-symbols-outlined hidden">expand_content</span></button>
            <table id="user_accounts" class="w-full rounded-md bg-zinc-800 table-fixed truncate">
                <tr class="border-solid border-white border-b">
                    <th>User name</th>
                    <th>User email</th>
                </tr>
                @foreach ($allUsers as $user)
                    {{-- Functionality would allow admin to click on user and go in to either delete/ban user --}}
                    <tr value="{{ $user->id }}" class="text-white text-ellipsis hover:opacity-50 transition ease-in-out duration-150">
                        <td class="px-3 truncate border-solid border-white border-e">{{ $user->name }}</li>
                        <td class="px-3 truncate">{{ $user->email }}</li>
                    </tr>
                @endforeach
            </table>
        </section>

        {{-- All images --}}
        <section class="p-3 bg-zinc-700 rounded-xl grid gap-3">
            <button id="header_toggle" class="p-6 bg-indigo-300 overflow-hidden rounded-lg font-bold text-gray-900 w-full text-left flex justify-between" onclick="toggleSection('user_images')"><p>.user images</p><span id="collapse_icon" class="material-symbols-outlined">collapse_content</span><span id="expand_icon" class="material-symbols-outlined hidden">expand_content</span></button>
            <div id="user_images" class="grid sm:grid-cols-4 gap-3">
                @foreach ($hostedImages as $hostedImage)
                    <div value="{{ $hostedImage->id }}" class="text-white bg-zinc-800 flex flex-col rounded-lg text-ellipsis hover:opacity-50 transition ease-in-out duration-150 min-w-0">

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

                    </div>
                @endforeach

                {{-- Pagination controls --}}
                <div class="pagination-styles flex justify-center w-full col-span-4">
                    {{ $hostedImages->links() }}
                </div>

            </div>
        </section>
        
    </div>

</x-app-layout>