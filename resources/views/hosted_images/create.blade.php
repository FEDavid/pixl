<x-app-layout>
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
            <h1 class="text-2xl font-bold text-indigo-400 mb-6">.upload new image</h1>
            <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
                @csrf

                <input type="file" name="hostedImage">

                <button type="submit" class="mt-6 w-full h-full text-center py-1 bg-indigo-400 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 rounded-md">
                    Upload Image
                </button>
            </form>
        </div>

        </div>
    </div>
</x-app-layout>
