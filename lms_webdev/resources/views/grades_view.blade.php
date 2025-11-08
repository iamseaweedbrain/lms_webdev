<x-layouts.mainlayout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAF8F5] px-6">
        <div class="w-full max-w-4xl">
            <div class="relative">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('grades') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-black rounded-md font-semibold">
                        <iconify-icon icon="ic:round-arrow-back" width="18" height="18"></iconify-icon>
                        Back
                    </a>

                    <a href="{{ route('submissions.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-black rounded-md font-semibold">
                        Return to appeal
                    </a>
                </div>

                <form class="bg-white border-2 border-black shadow-[8px_8px_0_0_#000] rounded-2xl overflow-hidden p-6">
                @php
                    $creatorName = $creatorName ?? 'Instructor Name';
                    $assignmentName = $assignmentName ?? 'Untitled Assignment';
                    $createdDate = $createdDate ?? now()->format('M d, Y');
                    $turnedInLabel = $turnedInLabel ?? 'Turned in';
                    $dateSubmitted = $dateSubmitted ?? '—';
                    $filePath = $filePath ?? 'No file';
                    $fileFormat = $fileFormat ?? '';
                    $feedback = $feedback ?? 'No feedback yet.';
                    $grade = $grade ?? '—';
                    $score = $score ?? '—';
                @endphp

                <div class="flex flex-col gap-4">
                    <!-- Top: creator and assignment (right-aligned) -->
                    <div class="flex justify-end text-right">
                        <div class="text-sm text-gray-600">{{ $creatorName }}</div>
                        <div class="ml-4 text-lg font-bold">{{ $assignmentName }}</div>
                    </div>

                    <hr class="border-t border-gray-200" />

                    <!-- Created date -->
                    <div class="text-sm text-gray-500">Created: {{ $createdDate }}</div>

                    <!-- Middle row: turned in (left) / file info (right) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm font-semibold">{{ $turnedInLabel }}</div>
                            <div class="mt-2 text-sm text-gray-700">{{ $dateSubmitted }}</div>
                        </div>

                        <div class="flex justify-end">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-700">
                                <div class="font-medium">{{ $filePath }}</div>
                                @if($fileFormat)
                                    <div class="mt-1 text-xs text-gray-500">{{ $fileFormat }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bottom row: feedback (left) / grade (right) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                        <div>
                            <div class="text-sm font-semibold">Feedback</div>
                            <div class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $feedback }}</div>
                        </div>

                        <div class="flex flex-col items-end">
                            <div class="text-sm font-semibold">Your Grade</div>
                            <div class="mt-2 text-lg font-bold">{{ $grade }}</div>
                            <div class="text-sm text-gray-600">{{ $score }}</div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-layouts.mainlayout>
