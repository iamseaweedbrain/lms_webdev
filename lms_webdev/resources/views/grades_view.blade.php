<x-layouts.mainlayout>
	<div class="min-h-screen flex items-center justify-center bg-[#FAF8F5] px-6">
        <div class="w-full">
            <div class="flex justify-between items-center mb-6">
                <button onclick="window.history.back()" class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
                    <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
                </button>

                <button class="bg-[#F9CADA] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
                    Return to Appeal
                </button>
            </div>

            @php
                $creatorName = $creatorName ?? 'Instructor Name';
                $assignmentName = $assignmentName ?? 'Untitled Assignment';
                $createdDate = $createdDate ?? now()->format('M d, Y');
                $dateSubmitted = $dateSubmitted ?? '—';
                $filePath = $filePath ?? 'No file';
                $fileFormat = $fileFormat ?? '';
                $feedback = $feedback ?? 'No feedback yet.';
                $grade = $grade ?? '—';
                $score = $score ?? '—';
            @endphp

            <div class="relative justify-between bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10 border-[3px] border-[#F9CADA] shadow-[12px_12px_0_0_#F9CADA] rounded-2xl z-10 flex flex-col">

                <div class="flex flex-col">
                    <div class="flex gap-6 items-center">
                        <div class="absolute -top-16 -left-4 w-[300px] h-80 z-30 pointer-events-none">
                            <img src="{{ asset('images/cat-mascot.png') }}" alt="cat-mascot" class="w-full h-full object-contain drop-shadow-lg">
                        </div>

                        <div class="ml-[270px]">
                            <h2 class="font-semibold text-3xl leading-tight">{{ $assignmentName }}</h2>
                            <p class="text-gray-500 text-base mt-1">{{ $creatorName }}</p>
                        </div>
                    </div>

                    <div class="mt-28 flex items-center justify-between absolute top-40 z-50">
                        <p class="text-gray-400 text-sm">Created: {{ $createdDate }}</p>
                        <div class="flex-1 ml-4 border-t-[5px] border-[#F9CADA]"></div>
                    </div>
                </div>

                <div class="flex flex-col mt-36 px-6 space-y-6 gap-14 flex-1 overflow-y-auto">
                    <div class="flex items-start gap-6">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-700 text-4xl">Turned In</h3>
                            <div class="text-md text-gray-700">{{ $dateSubmitted }}</div>
                        </div>
                        <div class="relative border-[3px] border-[#F9CADA] rounded-xl p-3 flex-1 shadow-[5px_5px_0_0_#F9CADA] flex flex-col">
                            <div class="text-lg text-gray-700">{{ basename($filePath) }}</div>
                            @if($fileFormat)
                                <div class="text-sm text-gray-500">{{ $fileFormat }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-6 mt-auto">
                        <div class="flex-1 flex flex-col justify-center">
                            <h3 class="font-semibold text-gray-700 text-4xl">Feedback</h3>
                            <div class="text-md text-gray-600 whitespace-pre-wrap mt-2">{{ $feedback }}</div>
                        </div>

                        <div class="w-40 text-right">
                            <div class="text-xl font-semibold">Your Grade</div>
                            <div class="text-4xl text-gray-600 font-bold">{{ $score }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</x-layouts.mainlayout>

