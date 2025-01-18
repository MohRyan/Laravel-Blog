<nav class="p-4 text-white bg-blue-800">
    <div class="container flex items-center justify-between px-5 mx-auto">
        <a href="{{ route('posts.index') }}" class="font-sans text-2xl font-bold">GlobalNews</a>
        @auth
            <div class="flex items-center space-x-4">
                <ul class="flex gap-6">
                    <li>
                        <a href="{{ route('post.index') }}" class="text-white hover:text-gray-300">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('post.create') }}" class="text-white hover:text-gray-300">Post Blog</a>
                    </li>

                </ul>

                <div class="flex items-center justify-end pl-10">
                    <span class="text-white" id="user-name">Hi,
                        {{-- {{ Auth::user()->name }}</span> --}}

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            <div id="logout-form"
                                class="fixed flex items-center justify-center p-3 bg-white rounded-lg shadow-lg bottom-6 hover:bg-blue-400 right-52">
                                @csrf
                                <button type="submit" class=""><svg xmlns="http://www.w3.org/2000/svg" width="40"
                                        height="40" viewBox="0 0 24 24">
                                        <path fill="#000957"
                                            d="M11.25 19a.75.75 0 0 1 .75-.75h6a.25.25 0 0 0 .25-.25V6a.25.25 0 0 0-.25-.25h-6a.75.75 0 0 1 0-1.5h6c.966 0 1.75.784 1.75 1.75v12A1.75 1.75 0 0 1 18 19.75h-6a.75.75 0 0 1-.75-.75" />
                                        <path fill="#000957"
                                            d="M15.612 13.115a1 1 0 0 1-1 1H9.756q-.035.533-.086 1.066l-.03.305a.718.718 0 0 1-1.025.578a16.8 16.8 0 0 1-4.885-3.539l-.03-.031a.72.72 0 0 1 0-.998l.03-.031a16.8 16.8 0 0 1 4.885-3.539a.718.718 0 0 1 1.025.578l.03.305q.051.532.086 1.066h4.856a1 1 0 0 1 1 1z" />
                                    </svg></button>
                            </div>
                        </form>
                </div>
            </div>
        @else
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 font-bold bg-black rounded-lg">Login</a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 font-bold text-blue-800 bg-white rounded-lg hover:text-black">Register</a>
            </div>
        </div>
    @endauth
</nav>
