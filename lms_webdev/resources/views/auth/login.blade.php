<x-layouts.landinglayout>
<section class="flex flex-col items-center justify-center min-h-[80vh] space-y-6 font-poppins text-gray-900 bg-[#FAF8F5]">
    <h1 class="text-2xl font-bold font-outfit">LOGIN</h1>
        @error('email')
            <p class="text-sm text-red-600 mt-1 text-center">{{ $message }}</p>
        @enderror
        @error('password')
            <p class="text-sm text-red-600 mt-1 text-center">{{ $message }}</p>
        @enderror
    <form action="{{ route('retrieveLogIn') }}" method="POST" class="flex flex-col space-y-4 w-80">
        @csrf

        <input type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" 
            class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
        
        <div class="relative">
            <input type="password" name="password" id="password" placeholder="Enter Password" 
                class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
            <button type="button" id="togglePassword" 
                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-black">
            </button>
        </div>

        <a href="{{ route('forgot.password') }}" class="text-right text-sm underline text-gray-500 hover:text-black">
            Forgot Password
        </a>

        <button type="submit" class="bg-black text-white py-3 rounded-full font-semibold hover:translate-y-0.5 hover:shadow-lg transition-all">
            LOGIN
        </button>
    </form>

    <p class="text-sm text-gray-500">
        Doesn’t have an account?
        <a href="{{ route('signup') }}" class="text-gray-400 hover:text-black underline">Sign Up</a>
    </p>
</section>
</x-layouts.landinglayout>
