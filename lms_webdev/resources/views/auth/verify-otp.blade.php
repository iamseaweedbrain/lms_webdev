<x-layouts.landinglayout>
<section class="flex flex-col items-center justify-center min-h-[80vh] bg-[#FAF8F5] font-poppins">
    <h1 class="text-2xl font-bold font-outfit mb-4">Verify OTP</h1>
        @error('otp')
            <p class="text-sm text-red-600 text-center">{{ $message }}</p>
        @enderror

    <form method="POST" action="{{ route('password.verify.otp') }}" class="w-80 space-y-4">
        @csrf
        <input type="hidden" name="email" value="{{ request('email') }}">
        <input type="text" name="otp" placeholder="Enter OTP" required
            class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light" value="{{ old('otp') }}">

        <button type="submit"
            class="bg-main text-page py-3 rounded-full font-semibold w-full hover:shadow-md transition-all">
            Verify OTP
        </button>
        @if (session('success'))
            <p class="text-sm text-main text-center">{{ session('success') }}</p>
        @endif

    </form>
</section>
</x-layouts.landinglayout>
