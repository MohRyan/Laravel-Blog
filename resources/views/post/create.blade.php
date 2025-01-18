@extends('home')

@section('content')
    <div class="flex flex-col items-center justify-center h-[95vh]">
        <h1 class="mb-4 text-4xl font-bold text-center">Create New Post</h1>
        <form class="flex items-center flex-col gap-3 w-full max-w-md min-h-[300px] p-4" action="{{ route('post.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col items-center w-full gap-4">
                <label for="image"
                    class="block text-sm cursor-pointer font-medium text-gray-700 w-[250px] h-[250px] border-2 border-dashed border-gray-500 rounded-lg flex justify-center items-center">
                    <div id="image-logo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
                            <g fill="none">
                                <path stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2m7 0v3m0 3V5m0 0h3m-3 0h-3" />
                                <path fill="#000" fill-rule="evenodd"
                                    d="M6.978 6.488A2.67 2.67 0 0 1 8.5 6c.41 0 1.003.115 1.522.488c.57.41.978 1.086.978 2.012s-.408 1.601-.978 2.011A2.67 2.67 0 0 1 8.5 11c-.41 0-1.003-.115-1.522-.489C6.408 10.101 6 9.427 6 8.5c0-.926.408-1.601.978-2.012m9.353 15.456C18.611 21.177 23 18.143 23 12a1 1 0 0 0-1-1h-1c-4.803 0-8.21 1.072-10.555 2.622c2.035.662 4.076 1.82 5.63 3.751a1 1 0 0 1-1.56 1.254c-1.515-1.884-3.65-2.912-5.796-3.41a15.5 15.5 0 0 0-3.531-.388c-.784.003-1.477.066-2.024.157a1 1 0 0 1-.232.012l-.096.016a1 1 0 0 0-.76 1.367c.652 1.584 2.135 3.723 4.51 5.097c2.42 1.399 5.684 1.958 9.745.466"
                                    clip-rule="evenodd" />
                            </g>
                        </svg>
                    </div>
                    <input type="file" name="image" id="image" class="hidden" accept="image/*" required>
                    <div id="image-preview" class="h-full"></div>
                </label>
                @error('image')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <div class="flex flex-col w-full gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md" required>
                        @error('title')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" id="content" rows="5"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md max-h-[150px]" required></textarea>
                        @error('content')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md">Create</button>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const blobURL = URL.createObjectURL(file);
                document.getElementById('image-logo').classList.add('hidden');
                document.getElementById('image-preview').innerHTML =
                    `<img src="${blobURL}" alt="Image preview" class="object-cover w-full h-full">`;
            }
        });
    </script>
@endsection
