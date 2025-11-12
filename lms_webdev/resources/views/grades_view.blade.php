<x-layouts.mainlayout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAF8F5] px-6 py-10">
        <div class="w-full max-w-5xl">

            <div class="flex justify-between items-center mb-10">
                <button onclick="window.history.back()" 
                    class="flex items-center gap-2 text-gray-600 hover:text-black transition">
                    <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
                </button>

                <button 
                    class="bg-[#F9CADA] text-black px-6 py-2 rounded-xl font-semibold hover:opacity-80 transition shadow-[4px_4px_0_0_#F9CADA]">
                    Return for Appeal
                </button>
            </div>

            @php
                $creatorName = $creatorName ?? 'Creator Name';
                $assignmentName = $assignmentName ?? 'Assignment Name';
                $createdDate = $createdDate ?? now()->format('M d, Y');
                $dateSubmitted = $dateSubmitted ?? 'Date Submitted';
                $filePath = $filePath ?? 'File Path';
                $fileFormat = $fileFormat ?? 'File Format';
                $feedback = $feedback ?? 'Nagreklamo i layk it so much wow';
                $score = $score ?? '100';
            @endphp

            <div class="bg-white w-full border-[3px] border-[#F9CADA] rounded-2xl shadow-[10px_10px_0_0_#F9CADA] p-10">
                <div class="flex gap-8">

                    <!-- Adjusted Image Container with Negative Top Value -->
                    <div class="flex-shrink-0 w-[220px] relative -top-32">
                        <img src="{{ asset('images/cat-mascot.png') }}" 
                             alt="cat-mascot" 
                             class="w-full h-auto object-contain">
                    </div>

                    <div class="flex flex-col flex-1">
                        <p class="text-gray-700 text-sm">{{ $creatorName }}</p>
                        <h2 class="font-bold text-2xl text-black">{{ $assignmentName }}</h2>
                    </div>
                </div>

                <!-- Date Created Below the Cat -->
                <div class="flex items-center mt-2">
                    <p class="text-gray-600 text-sm">Date Created</p>
                    <div class="flex-1 ml-3 border-t-[2.5px] border-[#F9CADA]"></div>
                </div>

                <!-- Turned In Section Adjusted -->
                <div class="mt-6 flex gap-8">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-black">Turned in</h3>
                        <p class="text-sm text-gray-700 mt-1">{{ $dateSubmitted }}</p>
                    </div>

                    <div class="flex-1 border-[3px] border-[#F9CADA] rounded-xl p-4 shadow-[5px_5px_0_0_#F9CADA]">
                        <div class="font-semibold text-gray-800">{{ basename($filePath) }}</div>
                        <div class="text-sm text-gray-500">{{ $fileFormat }}</div>
                    </div>
                </div>

                <!-- Feedback and Grade Section Adjusted -->
                <div class="mt-6 flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-black">Feedback</h3>
                        <p class="text-gray-700 mt-2">{{ $feedback }}</p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-black">Your Grade</p>
                        <p class="text-4xl font-bold text-black">{{ $score }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.mainlayout>
