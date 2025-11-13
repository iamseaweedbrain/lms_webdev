<x-layouts.landinglayout>
<section class="flex flex-col items-center justify-center min-h-[80vh] bg-[#FAF8F5] font-poppins">
    <h1 class="text-2xl font-bold font-outfit mb-4">Reset Password</h1>

    @error('password')
        <p class="text-sm text-red-600 text-center">{{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('password.reset.otp') }}" class="w-80 space-y-4">
        @csrf

        <input type="hidden" name="reset_token" value="{{ request('reset_token') }}">

        <input type="password" name="password" placeholder="New Password" required
            class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light" value="{{ old('password') }}">

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required
            class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light" value="{{ old('password_confirmation') }}">
       
        <button type="submit"
            class="bg-main text-page py-3 rounded-full font-semibold w-full hover:shadow-md transition-all">
            Reset Password
        </button>
    </form>

    @if(session('success'))
        <p class="text-sm text-main mt-4 text-center">{{ session('success') }}</p>
    @endif

    <a href="{{ route('retrieveLogIn') }}" class="mt-3 text-gray-500 underline hover:text-black text-sm">
        Back to Login
    </a>
</section>
</x-layouts.landinglayout>
