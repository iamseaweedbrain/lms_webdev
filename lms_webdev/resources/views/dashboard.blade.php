<x-layouts.mainlayout>
    <div class="p-6">
        {{-- Dashboard Header --}}
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold">Dashboard</h1>

            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Search class..." 
                    class="px-5 py-2 rounded-full shadow-md focus:outline-none pr-10 w-[250px]"
                >
                <iconify-icon 
                    icon="mingcute:search-line" 
                    width="24" 
                    height="24" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                </iconify-icon>
            </div>
        </div>

        {{-- Main Content Grid (Hero + Recent Posts Side by Side) --}}
        <div class="flex gap-10 items-start">
            {{-- Left Section (Hero) --}}
            <div class="relative overflow-visible w-fit">
                <p class="font-outfit font-regular text-[48px] text-main px-10">It’s a brand new day!</p>
                <p class="font-outfit font-regular text-[20px] text-main px-10 mb-6">Tuesday, November 3</p>

                <div class="relative bg-white w-[947px] h-[342px] px-[78px] py-[51px] border border-pastel-yellow shadow-[12px_12px_0_0_#FBE7A1] rounded-2xl z-10">
                    <div class="grid grid-rows-2 gap-10">
                        <div>
                            <p class="font-outfit font-bold text-[64px] text-main leading-none">Hi, Maxine!</p>
                            <p class="font-outfit font-light text-[24px] text-main mt-2">What are we gonna do today?</p>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="grid gap-2 font-outfit font-light">
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Join Class
                                </a>
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    View Grades
                                </a>
                            </div>
                            <div class="h-10 border-l border-pastel-yellow"></div>
                            <div class="grid gap-2">
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Create Class
                                </a>
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Manage Class
                                </a>
                            </div>
                        </div>
                    </div>

                    <img src="{{ asset('images/cat-mascot.png') }}" 
                        alt="cat-mascot" 
                        class="absolute right-[50px] -top-[130px] w-[293px] h-[342px] z-20">
                </div>
            </div>

            {{-- Right Section (Recent Posts) --}}
            <aside class="w-full"> 
                    <h3 class="font-bold text-lg mb-4 font-outfit">Recent Posts</h3>
                    <div class="flex flex-col gap-4">
                        
                        <!-- Post 1 (Purple) -->
                        <div class="flex items-center gap-4 bg-white border border-pastel-purple/50 p-4 rounded-xl shadow-md cursor-pointer hover:shadow-lg transition">
                            <div class="w-10 h-10 bg-pastel-purple/30 rounded-full flex-shrink-0"></div>
                            <div class="flex-grow min-w-0">
                                <h4 class="font-bold text-sm font-outfit">Class Name</h4>
                                <p class="text-xs text-gray-500 font-outfit truncate">Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="20" height="20" class="text-gray-400"></iconify-icon>
                        </div>

                        <!-- Post 2 (Pink) -->
                        <div class="flex items-center gap-4 bg-white border border-pastel-pink/50 p-4 rounded-xl shadow-md cursor-pointer hover:shadow-lg transition">
                            <div class="w-10 h-10 bg-pastel-pink/30 rounded-full flex-shrink-0"></div>
                            <div class="flex-grow min-w-0">
                                <h4 class="font-bold text-sm font-outfit">Class Name</h4>
                                <p class="text-xs text-gray-500 font-outfit truncate">Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="20" height="20" class="text-gray-400"></iconify-icon>
                        </div>

                        <!-- Post 3 (Blue) -->
                        <div class="flex items-center gap-4 bg-white border border-pastel-blue/50 p-4 rounded-xl shadow-md cursor-pointer hover:shadow-lg transition">
                            <div class="w-10 h-10 bg-pastel-blue/30 rounded-full flex-shrink-0"></div>
                            <div class="flex-grow min-w-0">
                                <h4 class="font-bold text-sm font-outfit">Class Name</h4>
                                <p class="text-xs text-gray-500 font-outfit truncate">Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="20" height="20" class="text-gray-400"></iconify-icon>
                        </div>
                    </div>
                </aside>
        </div>

        <h3 class="font-bold text-xl mt-8 mb-4 border-t border-gray-200 font-outfit">Your Classes</h3>
            <div id="your-classes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
            </div>

            <h3 class="font-bold text-xl mb-4 font-outfit">Managed Classes</h3>
            <div id="managed-classes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
            </div>
            
            <div class="flex justify-end space-x-2 text-gray-500 text-sm mt-2">
                <iconify-icon icon="ic:baseline-keyboard-arrow-left" width="20" height="20" class="cursor-pointer hover:text-main"></iconify-icon>
                <span class="font-semibold">1</span>
                <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="20" height="20" class="cursor-pointer hover:text-main"></iconify-icon>
            </div>
    </div>


    <script>
        /**
         * Generates the HTML string for a single class card.
         * @param {string} creatorName - The name of the class creator.
         * @param {string} className - The name of the class.
         * @param {string} count - The count (e.g., number of assignments).
         * @param {string} colorPrefix - The color identifier (e.g., 'pink', 'blue', 'yellow', 'purple')
         * @param {string} role - The user's role in the class (e.g., 'Member', 'Teacher').
         * @returns {string} The HTML markup for the class card.
         */

        function generateClassCard(creatorName, className, count, colorPrefix, role) {
            const borderColor = `border-pastel-${colorPrefix}`;
            const shadowClass = `shadow-pastel-${colorPrefix}`;
            const bgClass = `bg-pastel-${colorPrefix}`;
            const textColor = `text-pastel-${colorPrefix}`;
            const roleClass = (role === 'Teacher') ? 'text-main font-extrabold' : '';

            return `
                <div class="bg-white border-2 ${borderColor} rounded-2xl p-5 ${shadowClass} flex flex-col justify-between cursor-pointer hover:scale-[1.02] transition duration-200" title="${className}">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <p class="text-gray-500 text-sm font-outfit">${creatorName}</p>
                            <iconify-icon icon="ic:round-more-vert" width="24" height="24" class="text-gray-400"></iconify-icon>
                        </div>
                        <h4 class="font-bold text-2xl font-outfit mb-4">${className}</h4>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="${bgClass} px-4 py-2 rounded-xl font-bold text-xl text-main font-outfit shadow-sm">${count}</span>
                        <div class="text-right">
                            <p class="text-gray-500 text-xs font-outfit">JOINED AS</p>
                            <span class="font-semibold text-sm font-outfit ${textColor} ${roleClass}">${role}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        const yourClassesData = [
            { creator: 'Teacher A', name: 'Intro to Geometry', count: '01', color: 'pink', role: 'Member' },
            { creator: 'Prof. Smith', name: 'Advanced History', count: '00', color: 'blue', role: 'Member' },
            { creator: 'Ms. Johnson', name: 'Creative Writing', count: '10', color: 'yellow', role: 'Member' },
            { creator: 'Mr. Davis', name: 'Digital Art 101', count: '01', color: 'purple', role: 'Member' },
        ];

        const managedClassesData = [
            { creator: 'You', name: 'My Science Class', count: '25', color: 'blue', role: 'Teacher' },
            { creator: 'You', name: 'Algebra II', count: '30', color: 'pink', role: 'Teacher' },
        ];
        
        function renderClassCards(data, containerId) {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = data.map(cls => 
                    generateClassCard(cls.creator, cls.name, cls.count, cls.color, cls.role)
                ).join('');
            }
        }
        window.onload = function() {
            renderClassCards(yourClassesData, 'your-classes-container');
            renderClassCards(managedClassesData, 'managed-classes-container');
        };
    </script>
</x-layouts.mainlayout>
