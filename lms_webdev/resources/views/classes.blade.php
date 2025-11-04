<x-layouts.mainlayout>
    <div class="p-6">

        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold font-outfit">Your Classes</h1>

            <div class="flex items-center gap-3">
                <button class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">
                    <iconify-icon icon="ic:round-add" width="26" height="26" class="text-black"></iconify-icon>
                </button>

                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Search class..." 
                        class="px-5 py-2 rounded-full shadow-md focus:outline-none pr-10 w-[250px] h-10"
                    >
                    <iconify-icon 
                        icon="mingcute:search-line" 
                        width="22" 
                        height="22" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    </iconify-icon>
                </div>
            </div>
        </div>


        <div class="mb-10">
            <h2 class="font-semibold text-xl mb-4 font-outfit">Pinned Classes</h2>
            <div id="pinned-classes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl font-outfit">All Classes</h2>

            <div class="relative flex items-center text-sm font-outfit text-gray-500 cursor-pointer group">
                <span>Sort by Name</span>
                <iconify-icon 
                    icon="mdi:chevron-down" 
                    class="ml-1 text-gray-500 group-hover:text-black transition">
                </iconify-icon>

        <div class="hidden absolute right-0 mt-6 bg-white border border-gray-200 rounded-lg shadow-md w-32 text-gray-600 text-sm group-hover:block">
            <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer">Name</p>
            <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer">Creator</p>
            <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer">Newest</p>
            <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer">Oldest</p>
        </div>
    </div>
</div>


        <div id="all-classes-container" class="flex flex-col gap-4 mb-10"></div>

    </div>

    <script>
    function generatePinnedCard(creatorName, className, count, color, role) {
        const borderColor = `border-pastel-${color}`;
        const shadowClass = `shadow-pastel-${color}`; 
        const bgColor = `bg-pastel-${color}`;

        return `
            <div onclick="openClassView('${className}', '${creatorName}', '${count}', '${color}')"
                class="bg-white border-2 ${borderColor} rounded-2xl p-6 flex flex-col justify-between cursor-pointer hover:scale-[1.02] transition duration-200 ${shadowClass}">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-gray-500 text-sm font-outfit">${creatorName}</p>
                    <iconify-icon icon="ic:round-more-vert" width="22" height="22" class="text-gray-400"></iconify-icon>
                </div>
                <h4 class="font-bold text-xl font-outfit mb-6">${className}</h4>
                <div class="flex justify-between items-end">
                    <span class="${bgColor} text-black rounded-xl px-5 py-2 font-bold text-xl font-outfit shadow-sm">${count}</span>
                    <div class="text-right">
                        <p class="text-gray-400 text-xs font-outfit">Joined as</p>
                        <p class="font-semibold text-sm font-outfit text-main">${role}</p>
                    </div>
                </div>
            </div>
        `;
    }


    function generateAllClassRow(creatorName, className, count, color, status) {
        const borderColor = `border-pastel-${color}`;
        const textColor = `text-pastel-${color}`;
        const shadowClass = `shadow-pastel-${color}`;

        return `
            <div onclick="openClassView('${className}', '${creatorName}', '${count}', '${color}')"
                class="flex justify-between items-center bg-white border-2 ${borderColor} rounded-xl px-6 py-4 hover:scale-[1.02] transition duration-200 cursor-pointer ${shadowClass}">
                <div>
                    <p class="text-sm text-gray-500 font-outfit">${creatorName}</p>
                    <h4 class="font-semibold text-lg font-outfit">${className}</h4>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-center">
                        <p class="text-xs text-gray-500 font-outfit">${status}</p>
                        <span class="font-bold text-xl ${textColor} font-outfit">${count}</span>
                    </div>
                    <iconify-icon icon="ic:round-more-vert" width="22" height="22" class="text-gray-400"></iconify-icon>
                </div>
            </div>
        `;
    }

        const pinnedClasses = [
            { creator: 'Mr. Santos', name: 'Algebra 101', count: '01', color: 'pink', status: 'Pending Assignments', role: 'Member' },
            { creator: 'Ms. Lopez', name: 'Art Appreciation', count: '00', color: 'blue', status: 'No Pending Activities', role: 'Member' },
            { creator: 'Prof. Cruz', name: 'Physics Lab', count: '10', color: 'yellow', status: 'Check Student Work', role: 'Member' },
            { creator: 'Dr. Reyes', name: 'English Composition', count: '01', color: 'purple', status: 'Pending Assignments', role: 'Member' },
        ];

        const allClasses = [
            { creator: 'Prof. Diaz', name: 'World Literature', count: '01', color: 'pink', status: 'Pending' },
            { creator: 'Mr. Lim', name: 'Programming 2', count: '01', color: 'blue', status: 'Pending' },
            { creator: 'Ms. Bautista', name: 'Philosophy', count: '01', color: 'yellow', status: 'Pending' },
            { creator: 'Mr. Gomez', name: 'Multimedia Arts', count: '01', color: 'purple', status: 'Pending' },
        ];

        function renderPinnedClasses() {
            const container = document.getElementById('pinned-classes-container');
            container.innerHTML = pinnedClasses.map(cls => 
                generatePinnedCard(cls.creator, cls.name, cls.count, cls.color, cls.role)
            ).join('');
        }

        function renderAllClasses() {
            const container = document.getElementById('all-classes-container');
            container.innerHTML = allClasses.map(cls => 
                generateAllClassRow(cls.creator, cls.name, cls.count, cls.color, cls.status)
            ).join('');
        }

        window.onload = function() {
            renderPinnedClasses();
            renderAllClasses();
        };

        function openClassView(name, creator, count, color) {
            document.querySelector('.p-6').classList.add('hidden');
            document.getElementById('classViewPage').classList.remove('hidden');
            document.getElementById('classTitle').textContent = name;
            document.getElementById('classCreator').textContent = creator;
            document.getElementById('classCount').textContent = count;
            document.getElementById('classHeader').classList.add(`bg-pastel-${color}`);
        }

        function goBackToClasses() {
            document.getElementById('classViewPage').classList.add('hidden');
            document.querySelector('.p-6').classList.remove('hidden');
            document.getElementById('classHeader').className = 'rounded-2xl p-6 flex justify-between items-center mb-6';
        }

    </script>


 <!-- Class View Page -->
<div id="classViewPage" class="hidden p-6 relative overflow-visible">

    <div class="flex justify-between items-center mb-8">
        
        <div class="flex items-center gap-6">
            <button 
                onclick="goBackToClasses()" 
                class="text-main hover:bg-main/10 p-2 rounded-full transition">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>

            <div class="flex items-center gap-6 font-outfit text-lg -mt-2">
                <button class="font-semibold text-black border-b-4 border-[#F9CADA] pb-0">Posts</button>
                <button class="text-gray-500 hover:text-black transition">Assignments</button>
            </div>
        </div>

        <div class="flex items-center gap-4 -mt-2">
            <button class="p-2 hover:bg-gray-100 rounded-full transition">
                <iconify-icon 
                    icon="mdi:account-group-outline" 
                    width="26" 
                    height="26" 
                    class="text-black">
                </iconify-icon>
            </button>
            <button class="p-2 hover:bg-gray-100 rounded-full transition">
                <iconify-icon 
                    icon="mdi:cog-outline" 
                    width="26" 
                    height="26" 
                    class="text-black">
                </iconify-icon>
            </button>
        </div>
    </div>

    <div 
        id="classHeader"
        class="relative rounded-2xl p-10 flex justify-between items-start mb-10 bg-pastel-pink shadow-sm overflow-visible">

        <div class="z-10 ml-[240px] mt-[30px]">
            <h1 id="classTitle" class="text-4xl font-bold font-outfit text-black mb-1">Class Name</h1>
            <p id="classCreator" class="text-gray-700 font-outfit text-base mb-6">Creator Name</p>
        </div>

        <div class="text-right z-10 mt-[25px]">
            <span id="classCount" class="block text-5xl font-bold font-outfit text-black leading-none">00</span>
            <p class="text-gray-800 font-outfit text-sm">New Posts</p>
        </div>

        <img 
            src="{{ asset('images/cat-mascot.png') }}" 
            alt="cat mascot" 
            class="absolute -left-10 bottom-0 translate-y-[-60%] translate-x-[50%] w-[200px] h-[220px] z-[5] pointer-events-none select-none">
    </div>

    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-lg font-outfit">Posts</h2>
        {{-- Sort by Dropdown --}}
        <div class="relative flex items-center text-sm font-outfit text-gray-500 cursor-pointer group">
            <span>Sort by Date</span>
            <iconify-icon 
                icon="mdi:chevron-down" 
                class="ml-1 text-gray-500 group-hover:text-black transition">
            </iconify-icon>

            {{-- Hidden dropdown (appears on hover or can be toggled later) --}}
            <div class="hidden absolute right-0 mt-6 bg-white border border-gray-200 rounded-lg shadow-md w-32 text-gray-600 text-sm group-hover:block">
                <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer">Newest</p>
                <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer">Oldest</p>
            </div>
</div>

    </div>

    <div class="flex flex-col gap-4">
        
        <div class="bg-white border-2 border-[#F9CADA] rounded-xl p-4 hover:shadow-md transition flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg font-outfit">Assignment #1</h3>
                <p class="text-gray-600 text-sm font-outfit">Please submit your essay before Friday.</p>
                <p class="text-xs text-gray-400 font-outfit mt-1">Posted: Nov 2, 2025</p>
            </div>
            <iconify-icon 
                icon="ic:round-more-vert" 
                width="22" 
                height="22" 
                class="text-gray-400 hover:text-black transition cursor-pointer">
            </iconify-icon>
        </div>

        <div class="bg-white border-2 border-[#CBE8E9] rounded-xl p-4 hover:shadow-md transition flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg font-outfit">Quiz Reminder</h3>
                <p class="text-gray-600 text-sm font-outfit">Quiz on Chapter 3 next meeting.</p>
                <p class="text-xs text-gray-400 font-outfit mt-1">Posted: Nov 1, 2025</p>
            </div>
            <iconify-icon 
                icon="ic:round-more-vert" 
                width="22" 
                height="22" 
                class="text-gray-400 hover:text-black transition cursor-pointer">
            </iconify-icon>
        </div>

    </div>

    <style>
        #classHeader {
            position: relative;
            overflow: visible !important;
            min-height: 220px;
        }

        #classHeader img {
            position: absolute;
            bottom: 0;
            transform: translateY(50%);
            left: -40px;
        }
    </style>
</div>

</x-layouts.mainlayout>
