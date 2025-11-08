<x-layouts.mainlayout title="Grades Overview">
    <div class="flex flex-col gap-12 pr-28 pt-9 font-poppins relative">
        @php
            $activeColor = 'yellow';
            if(isset($selectedClass)) {
                $activeColor = $selectedClass['color'];
            }
        @endphp

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-main font-outfit">Grades Overview</h1>
            </div>
            <div class="relative">
                <input type="text"
                       placeholder="Search assignment..."
                       class="pl-10 pr-4 py-3 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-pastel-{{ $activeColor }} w-[260px] text-sm text-gray-700 placeholder-gray-400">
                <iconify-icon icon="mingcute:search-line"
                              class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                              width="20" height="20"></iconify-icon>
            </div>
        </div>

        @if(isset($allClasses) && $allClasses->isNotEmpty())
        <div class="absolute right-28 top-40 z-50" x-data="{ open: false }">
            <div class="relative">
                <button 
                    @click="open = !open"
                    class="relative flex items-center justify-between gap-2 w-56 bg-white border-2 text-gray-800 text-lg font-semibold px-8 py-3 rounded-2xl hover:bg-gray-50 transition z-10 border-pastel-{{ $activeColor }} shadow-[3px_3px_0_0_theme(colors.pastel-{{ $activeColor }}.DEFAULT)]"
                >
                    <span class="block truncate max-w-[180px]">{{ $selectedClass['classname'] ?? $selectedClass['class_name'] ?? 'Select Class' }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'rotate-180': open }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div 
                    x-show="open" 
                    @click.away="open = false" 
                    x-transition
                    class="absolute left-0 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden z-50"
                >
                    @foreach($allClasses as $class)
                                                <a href="{{ route('grades', ['class' => $class['id']]) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#F6E3C5] hover:text-black font-medium transition truncate">
                                                        <span class="block truncate">{{ $class['class_name'] ?? $class['classname'] }}</span>
                                                </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <section class="pl-4 pr-0 py-8 -space-y-2 flex flex-col relative overflow-hidden z-10">
            <div class="flex justify-between items-center flex-wrap gap-3">
              <div class="flex flex-wrap -space-x-2">
              @foreach($recentClasses as $class)
                @php
                $isActive = isset($selectedClass) && $selectedClass['id'] === $class['id'];
                @endphp
                                <a href="{{ route('grades', ['class' => $class['id']]) }}"
                                 class="px-14 py-6 rounded-t-3xl font-semibold text-lg transform transition-all duration-300 ease-out
                  hover:scale-105 hover:-translate-y-1 hover:shadow-lg
                    {{ $isActive
                    ? 'bg-pastel-'.$class['color'].'/100 text-main'
                    : 'bg-pastel-'.$class['color'].'/100 text-main/80 hover:bg-pastel-'.$class['color'].'/90' }}"
                 style="min-width:120px;">
                                <span class="block truncate max-w-[140px]">{{ $class['classname'] }}</span>
                </a>
              @endforeach
              </div>
            </div>

            <div class="overflow-x-auto relative z-10 -mt-6">
                <table class="bg-white min-w-full rounded-xl overflow-hidden table-fixed">
                    <colgroup>
                        <col style="width:45%" />
                        <col style="width:20%" />
                        <col style="width:25%" />
                        <col style="width:10%" />
                    </colgroup>
                    <thead>
                        <tr class="bg-pastel-{{ $activeColor }} text-main">
                            <th class="px-6 py-8 text-left font-bold text-lg">Assignment Name</th>
                            <th class="px-6 py-8 text-left font-bold text-lg">Score</th>
                            <th class="px-6 py-8 text-left font-bold text-lg">Feedback</th>
                            <th class="px-6 py-8 text-center font-bold text-lg">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                            <tr class="border-b border-gray-200 hover:bg-pastel-{{ $activeColor }}/30 transition">
                                <td class="px-6 py-4 text-gray-700 align-top">{{ $assignment['name'] }}</td>
                                <td class="px-6 py-4 text-green-600 font-medium text-center align-top">{{ $assignment['score'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 truncate align-top">{{ $assignment['feedback'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-center align-top">
                                    <a href="{{ route('student_grade', ['id' => $assignment['submission_id']]) }}"
                                       class="inline-block p-2 rounded-full hover:bg-pastel-{{ $activeColor }}/60 transition">
                                        <iconify-icon icon="ic:round-chevron-right" width="24" height="24"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-400 font-medium">
                                    No assignments found for this class.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pageCount > 1)
                <div class="flex justify-center gap-2 mt-6">
                    @for($i = 1; $i <= $pageCount; $i++)
                        <a href="{{ route('grades', ['class' => $selectedClass['id'] ?? null, 'page' => $i]) }}"
                           class="px-3 py-1 rounded-full font-semibold text-sm transition
                                  {{ $i == $currentPage 
                                        ? 'bg-pastel-'.$activeColor.' text-main' 
                                        : 'bg-gray-100 text-gray-500 hover:bg-pastel-'.$activeColor.' hover:text-main' }}">
                            {{ $i }}
                        </a>
                    @endfor
                </div>
            @endif
        </section>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-layouts.mainlayout>
