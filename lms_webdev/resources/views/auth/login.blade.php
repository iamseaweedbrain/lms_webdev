<x-layouts.landinglayout>

    <section class="flex flex-col items-center justify-center min-h-[80vh] space-y-6">
        <h1 class="text-2xl font-bold">LOGIN</h1>
        <form class="flex flex-col space-y-4 w-80">
            <input type="email" placeholder="Enter Email" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <div class="relative">
                <input type="password" placeholder="Enter Password" class="rounded-full bg-gray-200 px-4 py-2 w-full focus:outline-none">
                <button type="button" class="absolute right-4 top-2.5">👁️</button>
            </div>
            <a href="#" class="text-right text-sm underline">Forgot Password</a>
            <button type="submit" class="bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">LOGIN</button>
        </form>
        <p class="text-sm">
            Doesn’t have an account?
            <a href="{{ route('signup') }}" class="text-gray-500 hover:underline">Sign Up</a>
        </p>
    </section>
</x-layouts.landinglayout>

