<x-layouts.landinglayout>

    <section class="flex flex-col items-center justify-center min-h-[80vh] space-y-6">
        <h1 class="text-2xl font-bold">SIGN UP</h1>

        @if (session('success'))
            <div class="bg-page text-main p-2 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('storeSignUp') }}" method="POST" class="flex flex-col space-y-4 w-80">
            @csrf
            <input type="text" name="firstname" placeholder="Enter First Name" class="w-full py-[0.9rem] px-4 bg-[#e9e9e9] border-none rounded-full text-[0.95rem] outline-none font-[Poppins,sans-serif]">
            <input type="text" name="lastname" placeholder="Enter Last Name" class="w-full py-[0.9rem] px-4 bg-[#e9e9e9] border-none rounded-full text-[0.95rem] outline-none font-[Poppins,sans-serif]">
            <input type="email" name="email" placeholder="Enter Email" class="w-full py-[0.9rem] px-4 bg-[#e9e9e9] border-none rounded-full text-[0.95rem] outline-none font-[Poppins,sans-serif]">
            <input type="password" name="password" placeholder="Enter Password" class="w-full py-[0.9rem] px-4 bg-[#e9e9e9] border-none rounded-full text-[0.95rem] outline-none font-[Poppins,sans-serif]">
            <input type="password" name="password_confirmation" placeholder="Re-enter Password" class="w-full py-[0.9rem] px-4 bg-[#e9e9e9] border-none rounded-full text-[0.95rem] outline-none font-[Poppins,sans-serif]">
            <button type="submit" class="bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">SIGN UP</button>
        </form>
        <p class="text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-placeholder hover:underline">Login</a>
        </p>
    </section>

</x-layouts.landinglayout>

