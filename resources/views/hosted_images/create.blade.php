<x-app-layout>
        
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Upload new image') }}
        </h2>
    </x-slot>

    {{-- Content --}}
    <div class="grid p-6 sm:p-12">
        <div class="w-full md:w-1/2 lg:w-1/3 justify-self-center">

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6 bg-zinc-800 rounded-lg">

            {{-- Header --}}
            <h1 class="text-2xl font-bold text-indigo-400 mb-6">.upload new images</h1>

            {{-- Validation text --}}
            <div class="bg-red-100 rounded-xl p-6 text-red-500 mb-6">
                <h2 class="text-xl font-bold text-center">IMPORTANT</h2>
                <ul class="list-disc list-outside pl-6 space-y-1">
                    <li>You can upload up to 3 images at once.</li>
                    <li>Each image must be under 20MB.</li>
                    <li>The total size of all selected images must not exceed 20MB due to server limits.</li>
                </ul>
            </div>

            {{-- Upload form --}}
            <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Updated to "multiple" to accept multiple files and pass hostedImage[] as an array instead of a var --}}
                <input type="file" name="hostedImage[]" multiple class="w-full">

                <button type="submit" class="mt-6 w-full h-full text-center py-1 bg-indigo-400 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 rounded-md">
                    Upload Image
                </button>
            </form>

        </div>

        </div>
    </div>
</x-app-layout>
