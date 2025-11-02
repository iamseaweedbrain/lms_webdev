<x-layouts.landinglayout>

    <section class="flex flex-col items-center justify-center min-h-[80vh] space-y-6">
        <h1 class="text-2xl font-bold">SIGN UP</h1>
        <form class="flex flex-col space-y-4 w-80">
            <input type="text" placeholder="Enter First Name" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <input type="text" placeholder="Enter Last Name" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <input type="email" placeholder="Enter Email" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <input type="password" placeholder="Enter Password" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <input type="password" placeholder="Re-enter Password" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <button type="submit" class="bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">SIGN UP</button>
        </form>
        <p class="text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-gray-500 hover:underline">Login</a>
        </p>
    </section>

</x-layouts.landinglayout>

