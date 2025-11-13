<x-layouts.landinglayout>
<section class="flex flex-col items-center justify-center min-h-[80vh] font-poppins bg-page">
    <h1 class="text-2xl font-bold font-outfit mb-4">Forgot Password</h1>
        @error('email')
            <p class="text-sm text-red-600 text-center">{{ $message }}</p>
        @enderror
    <form method="POST" action="{{ route('password.request.otp') }}" class="w-80 space-y-4">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required
            class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light" value="{{ old('email') }}">

        <button type="submit"
            class="bg-main text-page py-3 rounded-full font-semibold w-full hover:shadow-md transition-all">
            Send OTP
        </button>
        @if (session('success'))
            <p class="text-sm text-main text-center">{{ session('success') }}</p>
        @endif

    </form>

    <a href="{{ route('retrieveLogIn') }}" class="mt-3 text-gray-500 underline hover:text-main text-sm">
        Back to Login
    </a>
</section>
</x-layouts.landinglayout>
