@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')

<div class="flex min-h-screen items-center justify-center bg-gray-100">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">

        <h2 class="text-3xl font-bold text-center mb-6">
            Daftar Akun
        </h2>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-red-600">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">

            @csrf

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    class="w-full border rounded-lg px-4 py-3"
                    required>

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="w-full border rounded-lg px-4 py-3"
                    required>

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-lg px-4 py-3"
                    required>

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border rounded-lg px-4 py-3"
                    required>

            </div>

            <button
                type="submit"
                class="w-full bg-red-700 hover:bg-red-800 text-white py-3 rounded-lg">

                Daftar

            </button>

        </form>

        <div class="mt-6 text-center">

            Sudah punya akun?

            <a href="{{ route('login') }}"
               class="text-red-700 font-semibold">

                Login

            </a>

        </div>

    </div>

</div>

@endsection