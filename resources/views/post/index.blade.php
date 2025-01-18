@extends('home')

@section('content')
    <div class="container p-8 mx-auto">
        <div class="flex justify-between">
            <a href="{{ route('post.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded-md">Create New Post</a>
        </div>
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-4">
            @if ($posts->isEmpty())
                <p class="col-span-4 text-center text-gray-600">No Post found for.</p>
            @else
                @foreach ($posts as $post)
                    <div class="flex flex-col p-4 border rounded-md shadow-md">
                        <a href="{{ route('post.show', $post) }}"
                            class="flex max-w-full mb-4 justify-content-center min-h-80">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}"
                                class="object-cover overflow-hidden transition duration-300 rounded-md">
                        </a>
                        <div class="flex flex-col justify-between h-full gap-2">
                            <h2 class="text-2xl font-semibold ">{{ $post->title }}</h2>
                            </p>
                            <article class="line-clamp-2">{{ Str::limit($post->content, 150) }}</article>
                            <p class="text-sm text-gray-600">By {{ $post->user->name }} |
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="flex gap-2">
                                    <button id="like-btn-{{ $post->id }}"
                                        class="like-btn {{ $post->isLikedByUser() ? 'text-red-500' : 'text-gray-600' }}"
                                        data-post-id="{{ $post->id }}" onclick="toggleLike({{ $post->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </button>
                                    <span id="likes-count-{{ $post->id }}">{{ $post->likes()->count() }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('post.show', $post) }}" class="inline-block text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <g fill="none">
                                                <path
                                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="#000"
                                                    d="M19 10a3 3 0 0 1 3 3v3a3 3 0 0 1-3 3v.966c0 1.06-1.236 1.639-2.05.96L14.638 19H12a3 3 0 0 1-3-3v-3a3 3 0 0 1 3-3zm-3-6a3 3 0 0 1 3 3v1h-8a4 4 0 0 0-4 4v4c0 1.044.4 1.996 1.056 2.708L7 19.5c-.824.618-2 .03-2-1V17a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3z" />
                                            </g>
                                        </svg>
                                    </a>
                                    <span id="comments-count-{{ $post->id }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                {{ $posts->links() }}
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function toggleLike(postId) {
            const likeBtn = $('#like-btn-' + postId);
            const likesCount = $('#likes-count-' + postId);
            const svgIcon = likeBtn.find('svg');

            $.ajax({
                url: '/posts/' + postId + '/like',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    postId: postId
                },

                success: function(response) {
                    if (response.status === 'liked') {
                        likeBtn.removeClass('text-gray-600').addClass('text-red-500');
                        svgIcon.css('fill', '#EF4444'); // Merah penuh ketika di-like
                    } else {
                        likeBtn.removeClass('text-red-500').addClass('text-gray-600');
                        svgIcon.css('fill', '#6B7280');
                    }
                    likesCount.text(response.likes_count);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($posts as $post)
                (function() {
                    const postId = "{{ $post->id }}";
                    const commentsCountElement = document.getElementById(`comments-count-${postId}`);

                    async function fetchCommentsCount() {
                        try {
                            const response = await fetch(`/comments/count/${postId}`);
                            const data = await response.json();
                            if (response.ok) {
                                commentsCountElement.textContent = data.total_comments;
                            } else {
                                commentsCountElement.textContent = 'Error';
                            }
                        } catch (error) {
                            console.error('Failed to fetch comments count:', error);
                            commentsCountElement.textContent = 'Error';
                        }
                    }
                    fetchCommentsCount();
                })();
            @endforeach
        });
    </script>
@endsection
