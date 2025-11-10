<x-layouts.landinglayout>

    <section class="flex flex-col items-center justify-center min-h-[80vh] space-y-6 font-poppins text-gray-900 bg-[#FAF8F5]">
        <h1 class="text-2xl font-bold font-outfit">SIGN UP</h1>

        @if (session('success'))
            <div class="bg-[#FAF8F5] text-[#111] p-2 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('storeSignUp') }}" method="POST" class="flex flex-col space-y-4 w-80">
            @csrf
            <input type="text" name="firstname" placeholder="Enter First Name" 
                class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
            <input type="text" name="lastname" placeholder="Enter Last Name" 
                class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
            <input type="email" name="email" placeholder="Enter Email" 
                class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
            <input type="password" name="password" placeholder="Enter Password" 
                class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
            <input type="password" name="password_confirmation" placeholder="Re-enter Password" 
                class="w-full py-3 px-4 bg-[#e9e9e9] rounded-full text-[0.95rem] outline-none font-light">
            <button type="submit" class="bg-black text-white py-3 rounded-full font-semibold hover:translate-y-0.5 hover:shadow-lg transition-all">
                SIGN UP
            </button>
        </form>

        <p class="text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-gray-400 hover:text-black underline">Login</a>
        </p>
    </section>

</x-layouts.landinglayout>
