<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="grid grid-cols-7 bg-gray-100">
    <div class="flex items-center justify-center min-h-screen col-span-3">
        <div class="p-8 bg-white rounded-lg shadow-lg w-96">
            @if (session('success'))
                <div class="p-4 mb-4 text-white bg-green-500 rounded-md shadow-md">
                    <strong>Success:</strong> {{ session('success') }}
                </div>
            @endif


            <h2 class="mb-4 text-2xl font-bold text-center">Login to Your Account</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center mb-4">
                    <input id="remember" type="checkbox" name="remember"
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                        class="text-indigo-600 hover:text-indigo-700">Register</a></span>
            </div>
        </div>
    </div>
    <div class="h-screen col-span-4 bg-red-500">
        <img class="object-cover w-full h-full"
            src="https://www.bluehost.com/blog/wp-content/uploads/2023/09/what-is-WordPress-hosting.png" alt="">
    </div>
</body>

</html>
