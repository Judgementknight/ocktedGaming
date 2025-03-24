@extends('Auth.auth-layout')

@section('Register')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="main">
    <div class="flex items-center justify-center min-h-screen w-full">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
          <h2 class="text-2xl font-semibold text-center text-gray-800">Create an Account</h2>

          <form action={{route('register-controller')}} method="POST" class="space-y-6 mt-8">
            @csrf
            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
              <input type="text" id="name" name="username" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 shadow-sm focus:outline-none" placeholder="John Doe">
            </div>

            <!-- Email Field -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
              <input type="email" id="email" name="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 shadow-sm focus:outline-none" placeholder="example@domain.com">
            </div>

            <!-- Password Field -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" id="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 shadow-sm focus:outline-none" placeholder="••••••••">
            </div>

            <!-- Submit Button -->
            <div>
              <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Sign Up</button>
            </div>
          </form>

          <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
              Already have an account?
              <a href={{route('login-page')}} class="text-blue-500 hover:text-blue-600 font-medium">Login</a>
            </p>
          </div>
        </div>
    </div>
</body>


@endsection
