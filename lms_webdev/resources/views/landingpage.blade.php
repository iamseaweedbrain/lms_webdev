<x-layouts.landinglayout>

    <section class="flex flex-col justify-between items-center px-8 md:px-20 py-20 min-h-[80vh]">
        <!-- Hero Row -->
        <div class="flex flex-col md:flex-row items-center w-full gap-12 md:gap-20">
            <!-- Text & Button -->
            <div class="flex-1 space-y-6">
                <h1 class="text-5xl md:text-[64px] font-extrabold font-outfit leading-tight">Empower your <br>learning journey.</h1>
                <p class="text-gray-700 text-lg max-w-md font-poppins font-regular">A simple and modern Learning Management System for students and teachers.</p>
                <a href="{{ route('signup') }}" class="inline-block bg-black text-white px-6 py-3 font-poppins font-light rounded-full shadow-md hover:bg-gray-800 transition font-semibold">
                    GET STARTED
                </a>
            </div>

            <div class="flex-1 flex justify-center md:justify-end">
                <img src="{{ asset('images/studying-landingpage.png') }}" alt="Learning illustration" class="w-80 md:w-96">
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-600 text-lg max-w-md font-poppins font-regular">Built to make online learning smarter and simpler.</p>
        </div>
    </section>

</x-layouts.landinglayout>
