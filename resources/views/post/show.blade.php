@extends('home')

@section('content')
    <div class="flex flex-col justify-center h-full p-10">
        <h1 class="mb-6 text-3xl font-bold">{{ $post->title }}</h1>

        <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}"
            alt="{{ $post->title }}" class="object-cover w-full rounded-lg shadow-md h-[500px]">

        <article class="my-6 leading-relaxed">{{ $post->content }}</article>

        <h2 class="py-2 text-2xl font-bold">Comments</h2>
        <div class="">
            @foreach ($post->comments as $comment)
                @php
                    $name = $comment->user->name;
                    $splitName = explode(' ', $name);
                    $firstName = $splitName[0];
                @endphp
                <div class="p-4">
                    <div class="flex items-center justify-between gap-3">
                        <strong title="{{ $comment->user->name }}"
                            class="flex items-center justify-center w-16 text-blue-400 bg-gray-200 rounded-full shadow-lg h-14 ">
                            {{ $firstName }}
                        </strong>
                        <p class="w-full">: {{ $comment->comment }}</p>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <div class="flex gap-3">
                                @if (auth()->id() === $comment->user_id || auth()->user()->is_admin)
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20">
                                            <path fill="#000"
                                                d="M12 4h3c.6 0 1 .4 1 1v1H3V5c0-.6.5-1 1-1h3c.2-1.1 1.3-2 2.5-2s2.3.9 2.5 2M8 4h3c-.2-.6-.9-1-1.5-1S8.2 3.4 8 4M4 7h11l-.9 10.1c0 .5-.5.9-1 .9H5.9c-.5 0-.9-.4-1-.9z" />
                                        </svg>
                                    </button>
                                @endif
                                <div class="cursor-pointer" data-toggle-button data-icon-id="icon-{{ $comment->id }}"
                                    data-form-id="reply-form-{{ $comment->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="icon-{{ $comment->id }}" width="24"
                                        height="24" viewBox="0 0 24 24" data-active="false">
                                        <path fill="#000"
                                            d="M7 8V5l-7 7l7 7v-3l-4-4zm6 1V5l-7 7l7 7v-4.1c5 0 8.5 1.6 11 5.1c-1-5-4-10-11-11" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Balasan -->
                    @foreach ($comment->reply as $reply)
                        @php
                            $replyName = $reply->user->name;
                            $splitReplyName = explode(' ', $replyName);
                            $firstReplyName = $splitReplyName[0];
                        @endphp
                        <div class="flex items-center justify-between gap-3 mx-10 my-5">
                            <strong class="text-blue-400">{{ $firstReplyName }}</strong>
                            <p class="w-full">: {{ $reply->comment }}</p>

                            @if (auth()->id() === $reply->user_id || auth()->user()->is_admin)
                                <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20">
                                            <path fill="#000"
                                                d="M12 4h3c.6 0 1 .4 1 1v1H3V5c0-.6.5-1 1-1h3c.2-1.1 1.3-2 2.5-2s2.3.9 2.5 2M8 4h3c-.2-.6-.9-1-1.5-1S8.2 3.4 8 4M4 7h11l-.9 10.1c0 .5-.5.9-1 .9H5.9c-.5 0-.9-.4-1-.9z" />
                                        </svg>
                                    </button>

                                </form>
                            @endif
                        </div>
                    @endforeach

                    <!-- Form Reply -->
                    <form action="{{ route('comments.reply') }}" method="POST" class="hidden mx-10 my-2"
                        id="reply-form-{{ $comment->id }}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <input name="comment" placeholder="Add a reply..."
                            class="w-full p-3 text-black bg-white border border-gray-600 rounded shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500"></input>
                        <button type="submit"
                            class="px-4 py-2 mt-4 text-white transition bg-blue-500 rounded hover:bg-blue-600">
                            Reply
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Comment Form -->
        <form action="{{ route('comments.store') }}" method="POST" class="mt-5 rounded-lg">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="comment" placeholder="Add a comment..."
                class="w-full p-3 text-black bg-white border border-gray-600 rounded shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 min-h-32"></textarea>
            <button type="submit"
                class="px-4 py-2 mt-4 text-white transition bg-blue-500 rounded hover:bg-blue-600">Comment</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButtons = document.querySelectorAll('[data-toggle-button]');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const iconId = button.dataset.iconId;
                    const formId = button.dataset.formId;

                    const icon = document.getElementById(iconId);
                    const replyForm = document.getElementById(formId);

                    const isActive = icon.getAttribute('data-active') === 'true';
                    icon.querySelector('path').setAttribute('fill', isActive ? '#000000' :
                        '#344CB7');
                    icon.setAttribute('data-active', !isActive);
                    replyForm.classList.toggle('hidden', isActive);
                });
            });
        });
    </script>
@endsection
