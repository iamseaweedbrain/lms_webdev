<x-layouts.mainlayout title="Grades Overview">
    <div class="flex flex-col gap-10 px-4 mt-8 mr-10 sm:px-5 lg:px-8 xl:px-10 2xl:px-20 pt-9 font-poppins relative w-full max-w-20xl mx-auto">
        @php
            $activeColor = $selectedClass['color'] ?? 'yellow';
            $colorMap = $allClasses->pluck('color', 'id')->toArray();
        @endphp

        {{-- HEADER --}}
        <div class="flex flex-wrap items-center gap-6 justify-between">
            <div>
                <h1 class="text-4xl font-bold text-main font-outfit">Grades Overview</h1>
            </div>
            {{-- CLASS DROPDOWN --}}
            @if(isset($allClasses) && $allClasses->isNotEmpty())
            <div class="self-end" x-data="{ open: false }">
                <div class="relative inline-block">
                    <button 
                        @click="open = !open"
                        class="relative flex items-center justify-between gap-2 w-56 bg-white border-2 text-gray-800 text-lg font-semibold px-8 py-3 rounded-2xl hover:bg-gray-50 transition z-10 border-pastel-{{ $activeColor }} shadow-[3px_3px_0_0_theme(colors.pastel-{{ $activeColor }}.DEFAULT)]"
                    >
                        <span class="block truncate max-w-[180px]">
                            {{ $selectedClass['classname'] ?? 'Select Class' }}
                        </span>
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
                            <a href="{{ route('grades', ['class' => $class['id'], 'view' => request('view')]) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#F6E3C5] hover:text-black font-medium transition truncate">
                                {{ $class['classname'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <div class="relative flex items-center">
                <input
                    type="text"
                    id="searchAssignmentInput"
                    placeholder="Search assignment..."
                    class="pl-8 py-2 focus:outline-none pr-10 shadow-md rounded-[15px] w-[250px] h-[50px]"
                    oninput="searchAssignments()">
                <iconify-icon icon="mingcute:search-line" width="20" height="20" class="absolute right-4 text-gray-500"></iconify-icon>
            </div>
        </div>

        {{-- RECENT CLASSES --}}
        <section class="px-3 sm:px-5 md:px-7 lg:px-9 xl:px-10 2xl:px-12 py-8 -space-y-2 flex flex-col relative overflow-hidden z-10 bg-transparent">
            <div class="flex justify-between items-center flex-wrap gap-3">
                <div class="flex flex-wrap -space-x-2">
                    @foreach($recentClasses as $class)
                        @php
                            $isActive = isset($selectedClass) && $selectedClass['id'] === $class->id;
                            $classColor = $colorMap[$class->id] ?? 'yellow';
                        @endphp
                        <a href="{{ route('grades', ['class' => $class->id, 'view' => request('view')]) }}"
                            class="px-14 py-6 rounded-t-3xl font-semibold text-lg transform transition-all duration-300 ease-out
                                hover:scale-105 hover:-translate-y-1 hover:shadow-lg
                                {{ $isActive
                                    ? 'bg-pastel-'.$activeColor.'/100 text-main'
                                    : 'bg-pastel-'.$classColor.'/80 text-main/80 hover:bg-pastel-'.$classColor.'/90' }}" {{-- Use $classColor here --}}
                            style="min-width:120px;">
                            <span class="block truncate max-w-[140px]">{{ $class->classname ?? 'Class' }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- ASSIGNMENT TABLE --}}
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
                                <td class="px-6 py-4 text-gray-700 align-middle truncate">
                                    <a href="{{ $assignment['route'] }}" class="block w-full h-full">{{ $assignment['name'] }}</a>
                                </td>
                                <td class="px-6 py-4 text-green-600 font-medium ml-1.5 align-middle">
                                    <a href="{{ $assignment['route'] }}" class="block w-full h-full">{{ $assignment['score'] ?? '-' }}</a>
                                </td>
                                <td class="px-6 py-4 text-gray-600 truncate align-middle">
                                    <a href="{{ $assignment['route'] }}" class="block w-full h-full">{{ $assignment['feedback'] ?? '-' }}</a>
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    <a href="{{ $assignment['route'] }}">
                                        <iconify-icon icon="ic:round-chevron-right" width="24" height="24" class="inline-block p-2 rounded-full hover:bg-pastel-{{ $activeColor }}/60 transition"></iconify-icon>
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

            {{-- PAGINATION --}}
            @if($pageCount > 1)
                <div class="flex justify-center gap-2 mt-6">
                    @for($i = 1; $i <= $pageCount; $i++)
                        <a href="{{ route('grades', ['class' => $selectedClass['id'] ?? null, 'page' => $i, 'view' => request('view')]) }}"
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
