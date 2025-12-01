<x-app-layout>

    {{-- Header --}}
    @auth
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('View all images') }}
            </h2>
        </x-slot>
    @endauth

    {{-- Content --}}
    <div class="flex w-full">
       
        <ul class="w-full grid gap-6 px-6 pb-6 grid-cols-[repeat(auto-fill,minmax(200px,1fr))] @auth pt-6 @endauth">

            {{-- Session messages --}}
            
            {{-- Upload success --}}
            @if (session('success'))
                <div class="bg-green-200 text-green-900 p-3 rounded grid justify-center content-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Deletion success --}}
            @if (session('deleted'))
                <div class="bg-red-200 text-red-900 p-3 rounded grid justify-center content-center">
                    {{ session('deleted') }}
                </div>
            @endif

            {{-- Content --}}
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
                </li>
            @endforeach
        </ul>


        @if (session('operation'))
            {{ session('operation') }} {{ session('id') }}
        @endif

    </div>
</x-app-layout>