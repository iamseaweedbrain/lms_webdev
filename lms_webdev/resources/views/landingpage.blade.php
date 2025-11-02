<x-layouts.landinglayout>

    <section class="flex flex-col md:flex-row justify-between items-center px-8 md:px-20 py-20">
        <div class="max-w-lg space-y-6">
            <h1 class="text-4xl font-extrabold">Empower your learning journey.</h1>
            <p class="text-gray-700">A simple and modern Learning Management System for students and teachers.</p>
            <a href="{{ route('signup') }}" class="inline-block bg-black text-white px-6 py-3 rounded-full shadow-md hover:bg-gray-800 transition">
                GET STARTED
            </a>
            <p class="pt-10 text-gray-600">Built to make online learning smarter and simpler.</p>
        </div>
        <div class="mt-10 md:mt-0">
            <img src="{{ asset('images/studying-landingpage.png') }}" alt="Learning illustration" class="w-96">
        </div>
    </section>
</x-layouts.landinglayout>
