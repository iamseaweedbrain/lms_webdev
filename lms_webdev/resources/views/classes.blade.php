<x-layouts.mainlayout>
    <!-- CLASSES PAGE -->
    <div class="p-6 mr-10" id="classesPage">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold font-poppins">Your Classes</h1>

            <div class="flex items-center gap-3">
                <button 
                    onclick="toggleJoinPopup()" 
                    class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">
                    <iconify-icon icon="ic:round-add" width="26" height="26" class="text-black"></iconify-icon>
                </button>

                <div class="relative flex items-center">
                    <input type="text" placeholder="Search class..." class="pl-8 py-2 focus:outline-none pr-10 shadow-md rounded-[15px] w-[250px] h-[50px]">
                    <iconify-icon icon="mingcute:search-line" width="20" height="20" class="absolute right-4 text-gray-500"></iconify-icon>
                </div>
            </div>
        </div>

        <!-- Pinned Classes -->
        <div class="mb-10">
            <div class="flex items-center gap-5 pl-5 mb-4">
                <iconify-icon icon="f7:pin-fill" width="20" height="20"></iconify-icon>
                <p class="font-bold text-[26px] font-outfit">Pinned Classes</p>
            </div>
            
            <div id="pinned-classes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($pinnedClassesDetails as $class)
                    <x-class-card 
                        :creatorName="$class->creator->name ?? 'N/A'"
                        :className="$class->name"
                        :count="$class->pending_count ?? 0" 
                        :colorPrefix="$class->color_prefix ?? 'default'"
                        :role="$class->user_role ?? 'student'"
                    />
                @empty
                    <p class="text-gray-500 col-span-full ml-5">You haven't pinned any classes yet.</p>
                @endforelse
            </div>
        </div>

        <!-- All Classes -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-5 pl-5">
                <iconify-icon icon="si:book-fill" width="20" height="20"></iconify-icon>
                <p class="font-bold text-[26px] font-outfit">All Classes</p>
            </div>
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

        <div id="all-classes-container" class="flex flex-col gap-4 mb-10">
            @forelse ($yourClasses as $class)
            @php
            $color = data_get($class, 'color_prefix', 'gray');
            $borderColor = "border-pastel-{$class}";
            $textColor = "text-pastel-{$class}";
            $shadowColor = "shadow-pastel-{$class}";
            $bgColor = "bg-pastel-{$class}";
            $className = data_get($class, 'class_name', 'Class Name');
            $creatorName = data_get($class, 'creator_name', 'Unknown Creator');
            $count = data_get($class, 'post_count', 0);
            @endphp

            <div 
            onclick="openClassView('{{ $className }}', '{{ $creatorName }}', '{{ $count }}', '{{ $color }}', '{{ $class->code }}')" 
            class="flex justify-between items-center bg-white border-3 {{ $borderColor }} rounded-[20px] px-6 py-4 hover:scale-[1.03] transition cursor-pointer {{ $shadowColor }}"
            >
            {{-- Left Section: Avatar + text --}}
            <div class="flex items-center gap-4">
                <div class="flex flex-col justify-center min-w-0">
                    <p class="text-sm text-gray-500 font-outfit truncate">{{ $creatorName }}</p>
                    <h4 class="font-semibold text-lg font-outfit truncate">{{ $className }}</h4>
                    <p class="text-[13px] text-gray-400 font-outfit truncate">
                        {{ data_get($post, 'content', 'No recent updates.') }}
                    </p>
                </div>
            </div>

            {{-- Right Section: count + menu --}}
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center">
                    <p class="text-xs text-gray-500 font-outfit">Posts</p>
                    <span class="font-bold text-xl {{ $textColor }} font-outfit">{{ $count }}</span>
                </div>

                <iconify-icon 
                    icon="ic:round-more-vert" 
                    width="22" 
                    height="22" 
                    class="text-gray-400"
                ></iconify-icon>
            </div>
            </div>
            @empty
            <p class="text-gray-500 italic p-4">No recent posts found in your classes.</p>
            @endforelse
        </div>
    </div>

            <!-- Join Class Popup -->
    <div id="joinClassPopup" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-[380px] p-6 text-center relative font-outfit">
            <button 
            onclick="toggleJoinPopup()" 
            class="absolute top-3 right-3 text-gray-400 hover:text-black transition">
            <iconify-icon icon="mdi:close" width="22" height="22"></iconify-icon>
            </button>

            <h2 class="text-xl font-bold mb-3">Join a Class</h2>
            <p class="text-gray-600 text-sm mb-6">Enter the class code provided by your teacher.</p>

            <input 
            id="joinClassCodeInput"
            type="text" 
            placeholder="Enter class code (e.g., ALG101)" 
            class="border border-gray-300 rounded-lg w-full py-2 px-4 text-sm mb-5 focus:outline-none focus:ring-2 focus:ring-main"
            >

            <button 
            onclick="joinClassFromCode()" 
            class="bg-main text-white px-5 py-2 rounded-lg font-semibold hover:bg-main/80 transition">
            Join Class
            </button>
        </div>
    </div>

    <!-- CLASS VIEW PAGE -->
    <div id="classViewPage" class="hidden p-6 relative overflow-visible">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-6">
                <button 
                    onclick="goBackToClasses()" 
                    class="text-main hover:bg-main/10 p-2 rounded-full transition">
                    <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
                </button>

                <div class="flex items-center gap-6 font-outfit text-lg -mt-2">
                    <button id="postsTab" onclick="showTab('posts')" class="font-semibold text-black border-b-4 border-[#F9CADA] pb-0">Posts</button>
                    <button id="assignmentsTab" onclick="showTab('assignments')" class="text-black pb-0">Assignments</button>
                </div>

            </div>

            <div class="flex items-center gap-4 -mt-2">
                <button 
                    onclick="showMembers()" 
                    class="p-2 hover:bg-gray-100 rounded-full transition"
                    title="View Members">
                    <iconify-icon icon="mdi:account-group-outline" width="26" height="26" class="text-black"></iconify-icon>
                </button>
            <!-- Share Icon (Class Code Copy) -->
            <div class="relative">
                <button 
                    onclick="toggleClassCodePopup()" 
                    class="p-2 hover:bg-gray-100 rounded-full transition"
                    title="Share Class Code">
                    <iconify-icon icon="mdi:share-variant-outline" width="26" height="26" class="text-black"></iconify-icon>
                </button>

                <!-- Hidden popup -->
                <div id="classCodePopup" class="hidden absolute right-0 mt-3 bg-white border border-gray-200 rounded-lg shadow-md p-3 w-52 z-50">
                    <p class="font-semibold text-sm text-gray-700 mb-2 font-outfit">Class Code:</p>
                    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                        <span id="classCodeText" class="font-mono text-sm text-gray-700">ABC123</span>
                        <button 
                            onclick="copyClassCodePopup()" 
                            class="text-main font-outfit text-xs font-semibold hover:underline">
                            Copy
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div id="classHeader" class="relative rounded-2xl p-10 flex justify-between items-start mb-10 bg-pastel-pink shadow-sm overflow-visible">
            <div class="z-10 ml-[240px] mt-[30px]">
                <h1 id="classTitle" class="text-4xl font-bold font-outfit text-black mb-1">Class Name</h1>
                <p id="classCreator" class="text-gray-700 font-outfit text-base mb-6">Creator Name</p>
            </div>

            <div class="text-right z-10 mt-[25px]">
                <span id="classCount" class="block text-5xl font-bold font-outfit text-black leading-none">00</span>
                <p id="classLabel" class="text-gray-800 font-outfit text-sm">New Posts</p>
            </div>

            <img 
                src="{{ asset('images/cat-mascot.png') }}" 
                alt="cat mascot" 
                class="absolute -left-10 bottom-0 translate-y-[-60%] translate-x-[50%] w-[200px] h-[220px] z-[5] pointer-events-none select-none">
        </div>

        <!-- POSTS TAB -->
        <div id="postsSection" class="flex flex-col gap-4">
        <h2 class="font-semibold text-lg font-outfit mb-2">Posts</h2>

        <!-- Announcement Card -->
        <div 
            onclick="openDetailPage('announcement')" 
            class="relative bg-white w-full px-6 py-4 border border-[#F9CADA] rounded-2xl 
                shadow-[8px_8px_0_0_#FBD1E2] cursor-pointer 
                hover:scale-[1.02] transition duration-200 flex justify-between items-center">
            <div>
            <h3 class="font-semibold text-lg font-outfit">Announcement</h3>
            <p class="text-gray-600 text-sm font-outfit">Please submit your essay before Friday.</p>
            <p class="text-xs text-gray-400 font-outfit mt-1">Posted: Nov 2, 2025</p>
            </div>
            <iconify-icon 
            icon="ic:round-more-vert" 
            width="22" height="22" 
            class="text-gray-400 hover:text-black transition cursor-pointer">
            </iconify-icon>
        </div>

        <!-- Material Card -->
        <div 
            onclick="openDetailPage('material')" 
            class="relative bg-white w-full px-6 py-4 border border-[#CBE8E9] rounded-2xl 
                shadow-[8px_8px_0_0_#B7E3E6] cursor-pointer 
                hover:scale-[1.02] transition duration-200 flex justify-between items-center">
            <div>
            <h3 class="font-semibold text-lg font-outfit">Material</h3>
            <p class="text-gray-600 text-sm font-outfit">Material for final exam.</p>
            <p class="text-xs text-gray-400 font-outfit mt-1">Posted: Nov 1, 2025</p>
            </div>
            <iconify-icon 
            icon="ic:round-more-vert" 
            width="22" height="22" 
            class="text-gray-400 hover:text-black transition cursor-pointer">
            </iconify-icon>
        </div>
        </div>

        <!-- ASSIGNMENTS TAB -->
        <div id="assignmentsSection" class="hidden flex flex-col gap-4">
        <h2 class="font-semibold text-lg font-outfit mb-2">Assignments</h2>

        <!-- Assignment Card -->
        <div 
            onclick="openDetailPage('assignment')" 
            class="relative bg-white w-full px-6 py-4 border border-[#F9CADA] rounded-2xl 
                shadow-[8px_8px_0_0_#FBD1E2] cursor-pointer 
                hover:scale-[1.02] transition duration-200 flex justify-between items-center">
            <div>
            <h3 class="font-semibold text-lg font-outfit">Essay Submission</h3>
            <p class="text-gray-600 text-sm font-outfit">Write a 300-word essay on modern art.</p>
            <p class="text-xs text-gray-400 font-outfit mt-1">Due: Nov 5, 2025</p>
            </div>
            <iconify-icon 
            icon="ic:round-upload" 
            width="22" height="22" 
            class="text-gray-400 hover:text-black transition cursor-pointer">
            </iconify-icon>
        </div>
        </div>

        <!-- MEMBERS TAB -->
        <div id="membersSection" class="hidden flex flex-col gap-6">
        <h2 class="font-semibold text-lg font-outfit mb-2">Class Members</h2>

        <!-- Teachers -->
        <div>
            <h3 class="font-semibold text-md font-outfit text-gray-700 mb-2">Teachers</h3>
            <div id="teachersList" class="flex flex-col gap-3">
            <div class="bg-white border-2 border-[#F9CADA] rounded-xl p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                <img 
                    src="{{ asset('images/teacher-santos.jpg') }}" 
                    alt="Mr. Santos" 
                    class="w-10 h-10 rounded-full object-cover border border-gray-200"
                >
                <div>
                    <p class="font-semibold text-lg font-outfit text-black">Mr. Santos</p>
                    <p class="text-sm text-gray-500 font-outfit">Algebra 101 - Main Instructor</p>
                </div>
                </div>
                <iconify-icon icon="mdi:account-tie-outline" width="22" height="22" class="text-gray-500"></iconify-icon>
            </div>
            </div>
        </div>

        <!-- Students -->
        <div>
            <h3 class="font-semibold text-md font-outfit text-gray-700 mb-2">Students</h3>
            <div id="studentsList" class="flex flex-col gap-3">
            <div class="bg-white border-2 border-[#CBE8E9] rounded-xl p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                <img 
                    src="{{ asset('images/student-venice.jpg') }}" 
                    alt="Venice Don" 
                    class="w-10 h-10 rounded-full object-cover border border-gray-200"
                >
                <div>
                    <p class="font-semibold text-lg font-outfit text-black">Venice Don</p>
                    <p class="text-sm text-gray-500 font-outfit">Member</p>
                </div>
                </div>
                <iconify-icon icon="mdi:account-outline" width="22" height="22" class="text-gray-500"></iconify-icon>
            </div>

            <div class="bg-white border-2 border-[#CBE8E9] rounded-xl p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                <img 
                    src="{{ asset('images/student-jake.jpg') }}" 
                    alt="Jake Reyes" 
                    class="w-10 h-10 rounded-full object-cover border border-gray-200"
                >
                <div>
                    <p class="font-semibold text-lg font-outfit text-black">Jake Reyes</p>
                    <p class="text-sm text-gray-500 font-outfit">Member</p>
                </div>
                </div>
                <iconify-icon icon="mdi:account-outline" width="22" height="22" class="text-gray-500"></iconify-icon>
            </div>

            <div class="bg-white border-2 border-[#CBE8E9] rounded-xl p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                <img 
                    src="{{ asset('images/student-lara.jpg') }}" 
                    alt="Lara Cruz" 
                    class="w-10 h-10 rounded-full object-cover border border-gray-200"
                >
                <div>
                    <p class="font-semibold text-lg font-outfit text-black">Lara Cruz</p>
                    <p class="text-sm text-gray-500 font-outfit">Member</p>
                </div>
                </div>
                <iconify-icon icon="mdi:account-outline" width="22" height="22" class="text-gray-500"></iconify-icon>
            </div>
            </div>
        </div>
        </div>
    </div>
    
        <!-- MATERIAL DETAIL PAGE -->
        <div id="materialDetailPage" class="hidden px-10 py-6">
        <div class="flex justify-between items-center mb-6">
            <button 
            onclick="goBack()" 
            class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
            <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>
            <button class="bg-[#CBE8E9] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
            Mark As Read
            </button>
        </div>

        <div class="relative bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10 
                    border-[3px] border-[#CBE8E9] 
                    shadow-[12px_12px_0_0_#CBE8E9] 
                    rounded-2xl z-10 flex flex-col">

            <div class="flex flex-col">
            <div class="flex gap-6 items-center">
                <div class="relative w-[300px] h-[320px]">
                <img 
                    src="{{ asset('images/cat-mascot.png') }}" 
                    alt="cat mascot" 
                    class="absolute -left-10 bottom-0 translate-y-[-17%] translate-x-[10%] w-[300px] h-[320px] z-[5] pointer-events-none select-none">
                </div>

                <div class="-mt-[140px] ml-[70px]">
                <h2 class="font-semibold text-3xl leading-tight">Post Title</h2>
                <p class="text-gray-500 text-base mt-1">Creator Name</p>
                </div>
            </div>

            <div class="-mt-15 flex items-center justify-between">
                <p class="text-gray-400 text-sm">Posted: Nov 1, 2025</p>
                <div class="flex-1 ml-4 border-t-[5px] border-[#CBE8E9]"></div>
            </div>
            </div>

            <div class="mt-10 space-y-4 flex-1 overflow-y-auto">
                <!-- Material -->
                <div class="flex items-start gap-6">
                <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Material</h3>
                <div class="relative border-[3px] border-[#CBE8E9] rounded-xl p-3 flex-1 shadow-[5px_5px_0_0_#CBE8E9] flex justify-between items-center">
                    <div>
                    <p class="font-bold text-normal text-gray-500">Final Exam File</p>
                    <a href="#" class="text-blue-600 text-sm hover:underline">
                        material.pdf
                    </a>
                    </div>
                    <iconify-icon icon="mdi:arrow-up" width="24" height="24" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <!-- Instructions -->
            <div class="flex items-start gap-6">
                <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Instructions</h3>
                <p class="text-gray-600 text-base leading-relaxed flex-1 max-h-[400px] overflow-y-auto">
                Read through the attached slides and summarize key concepts.
            </div>
            </div>
        </div>
        </div>


        <!-- ANNOUNCEMENT DETAIL PAGE -->
        <div id="announcementDetailPage" class="hidden px-10 py-6">
        <div class="flex justify-between items-center mb-6">
            <button 
                onclick="goBack()" 
                class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>

            <button class="bg-[#F9E8C9] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
            Mark As Read
            </button>
        </div>

        <div class="relative bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10 
                    border-[3px] border-[#F9E8C9] 
                    shadow-[12px_12px_0_0_#F9E8C9] 
                    rounded-2xl z-10 flex flex-col">

            <div class="flex flex-col">
            <div class="flex gap-6 items-center">
                <div class="relative w-[300px] h-[320px]">
                <img 
                    src="{{ asset('images/cat-mascot.png') }}" 
                    alt="cat mascot" 
                    class="absolute -left-10 bottom-0 translate-y-[-17%] translate-x-[10%] w-[300px] h-[320px] z-[5] pointer-events-none select-none">
                </div>

                <div class="-mt-[140px] ml-[70px]">
                <h2 class="font-semibold text-3xl leading-tight">Post Title</h2>
                <p class="text-gray-500 text-base mt-1">Creator Name</p>
                </div>
            </div>

            <div class="-mt-15 flex items-center justify-start">
                <p class="text-gray-400 text-sm">Posted: Nov 2, 2025</p>
                <div class="flex-1 ml-4 border-t-[5px] border-[#F9E8C9]"></div>
            </div>
            </div>

            <div class="mt-6 flex-1">
            <h3 class="font-semibold text-gray-700 text-lg text-center">Announcement</h3>
            <p class="text-gray-600 text-base mt-3 leading-relaxed max-w-2xl mx-auto">
                Please submit your essay before Friday. Make sure to review the grading rubric carefully and upload your file in PDF format only. 
                Late submissions will not be accepted, so plan your time accordingly. If you have any questions, feel free to reach out via email 
                or during our consultation hours this week. Thank you for your cooperation and best of luck with your work!
            </p>
            </div>
        </div>
        </div>


        <!-- ASSIGNMENT DETAIL PAGE -->
        <div id="assignmentDetailPage" class="hidden px-10 py-6">
        <div class="flex justify-between items-center mb-6">
            <button 
                onclick="goBack()" 
                class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>

            <button class="bg-[#F9CADA] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
            Mark As Done
            </button>
        </div>

        <div class="relative bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10 
                    border-[3px] border-[#F9CADA] 
                    shadow-[12px_12px_0_0_#F9CADA] 
                    rounded-2xl z-10 flex flex-col">

            <div class="flex flex-col">
            <div class="flex gap-6 items-center">
                <div class="relative w-[300px] h-[320px]">
                <img 
                    src="{{ asset('images/cat-mascot.png') }}" 
                    alt="cat mascot" 
                    class="absolute -left-10 bottom-0 translate-y-[-17%] translate-x-[10%] w-[300px] h-[320px] z-[5] pointer-events-none select-none">
                </div>

                <div class="-mt-[140px] ml-[70px]">
                <h2 class="font-semibold text-3xl leading-tight">Essay Submission</h2>
                <p class="text-gray-500 text-base mt-1">Mr. Santos</p>
                </div>
            </div>

            <div class="-mt-15 flex items-center justify-between">
                <p class="text-gray-400 text-sm">Posted: Nov 2, 2025</p>
                <div class="flex-1 ml-4 border-t-[5px] border-[#F9CADA]"></div>
            </div>
            </div>

            <div class="mt-6 space-y-6 flex-1 overflow-y-auto">
            <div class="flex items-start gap-6">
            <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Not Turned In</h3>
            <div class="relative border-[3px] border-[#F9CADA] rounded-xl p-3 flex-1 shadow-[5px_5px_0_0_#F9CADA] flex items-center gap-3">
                <input 
                type="file" 
                id="essayFile"
                class="border border-gray-300 rounded-xl p-3 flex-1 text-base focus:ring-2 focus:ring-[#F9CADA] outline-none transition" />
                <button 
                    class="bg-[#F9CADA] px-4 py-2 rounded-xl font-semibold hover:opacity-80 transition flex-shrink-0"
                    onclick="submitEssay()">
                    SUBMIT
                </button>
            </div>
            </div>

            <!-- Instructions -->
            <div class="flex items-start gap-6">
                <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Instructions</h3>
                <p class="text-gray-600 text-base leading-relaxed flex-1 max-h-[400px] overflow-y-auto">
                    Write your essay according to the prompt, format it in Times New Roman 12pt double-spaced with a title page, 
                    save it as a PDF named Lastname_Firstname_Assignment.pdf, and upload it using the Choose File button before t
                    he deadline. Make sure your work is original and sources are properly cited.       
                </p>
            </div>
            </div>
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

            #copyMsg {
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            #copyMsg.opacity-100 {
                opacity: 1;
            }

        </style>
    </div>

<script>
const dbData = {
    posts: 12,
    assignments: 3,
    members: 14
};

function openClassView(name, creator, count, color, code) {
    document.getElementById('classesPage').classList.add('hidden');
    document.getElementById('classViewPage').classList.remove('hidden');
    document.getElementById('classTitle').textContent = name;
    document.getElementById('classCreator').textContent = creator;
    document.getElementById('classCount').textContent = dbData.posts;
    document.getElementById('classLabel').textContent = 'New Posts';
    document.getElementById('classCodeText').textContent = code; 
    document.getElementById('classHeader').className =
        `relative rounded-2xl p-10 flex justify-between items-start mb-10 bg-pastel-${color} shadow-sm overflow-visible`;

    showTab('posts');
}

function goBackToClasses() {
    document.getElementById('classViewPage').classList.add('hidden');
    document.getElementById('classesPage').classList.remove('hidden');
}

function hideAllTabs() {
    ['postsSection', 'assignmentsSection', 'membersSection'].forEach(id =>
        document.getElementById(id).classList.add('hidden')
    );
}

function resetTabStyles() {
    ['postsTab', 'assignmentsTab', 'membersTab'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('border-b-4', 'border-[#F9CADA]', 'font-semibold', 'text-main');
            el.classList.add('text-gray-500');
        }
    });
}

function showTab(tab) {
    hideAllTabs();
    resetTabStyles();

    const activeTab = document.getElementById(`${tab}Tab`);
    const classCount = document.getElementById('classCount');
    const classLabel = document.getElementById('classLabel');

    document.getElementById(`${tab}Section`).classList.remove('hidden');
    activeTab.classList.add('border-b-4', 'border-[#F9CADA]', 'font-semibold', 'text-main');
    activeTab.classList.remove('text-gray-500');

    if (tab === 'posts') {
        classCount.textContent = dbData.posts;
        classLabel.textContent = 'New Posts';
    } else if (tab === 'assignments') {
        classCount.textContent = dbData.assignments;
        classLabel.textContent = 'Pending Assignments';
    } else if (tab === 'members') {
        classCount.textContent = dbData.members;
        classLabel.textContent = 'Total Members';
    }
}

function toggleClassCodePopup() {
    const popup = document.getElementById('classCodePopup');
    popup.classList.toggle('hidden');
}

function submitEssay() {
    const fileInput = document.getElementById('essayFile');
    
    if (!fileInput.value) {
      alert('Please select a file before submitting.');
      return;
    }

    const confirmSubmit = confirm('Are you sure you want to submit your essay?');
    if (!confirmSubmit) return;

    alert('Your essay has been submitted successfully!');

    fileInput.disabled = true;
    document.querySelector('button[onclick="submitEssay()"]').disabled = true;
}

function copyClassCodePopup() {
    const codeText = document.getElementById('classCodeText').textContent;

    try {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(codeText)
                .then(showCopyMessage)
                .catch(err => {
                    console.warn("Clipboard writeText failed, using fallback:", err);
                    fallbackCopy(codeText);
                });
        } else {
            fallbackCopy(codeText);
        }
    } catch (err) {
        console.error("Clipboard API not supported:", err);
        fallbackCopy(codeText);
    }

    function fallbackCopy(text) {
        const textarea = document.createElement("textarea");
        textarea.value = text;
        textarea.style.position = "fixed";
        textarea.style.left = "-9999px";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        textarea.remove();
        showCopyMessage();
    }

function showCopyMessage() {
    const toast = document.createElement('div');
    toast.textContent = `Copied ${codeText}`;
    toast.className = `
        fixed bottom-5 right-5 bg-main text-white 
        px-4 py-2 rounded-xl shadow-lg text-sm font-outfit 
        z-[9999] opacity-0 transition-opacity duration-300
    `;
    document.body.appendChild(toast);

    requestAnimationFrame(() => toast.classList.add('opacity-100'));

    setTimeout(() => {
        toast.classList.remove('opacity-100');
        setTimeout(() => toast.remove(), 300);
    }, 1500);
}
}

function copyPinnedClassCode(code, event) {
    event.stopPropagation();

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(code).then(showToast);
    } else {
        const textarea = document.createElement("textarea");
        textarea.value = code;
        textarea.style.position = "fixed";
        textarea.style.left = "-9999px";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        textarea.remove();
        showToast();
    }

    function showToast() {
        const toast = document.createElement('div');
        toast.textContent = `Copied ${code}`;
        toast.className = `
            fixed bottom-5 right-5 bg-main text-white 
            px-4 py-2 rounded-xl shadow-lg text-sm font-outfit 
            z-[9999] opacity-0 transition-opacity duration-300
        `;
        document.body.appendChild(toast);

        requestAnimationFrame(() => toast.classList.add('opacity-100'));
        setTimeout(() => {
            toast.classList.remove('opacity-100');
            setTimeout(() => toast.remove(), 300);
        }, 1500);
    }
}

function toggleJoinPopup() {
  console.log("Add button clicked!");
  const popup = document.getElementById('joinClassPopup');
  popup.classList.toggle('hidden');
}

function joinClassFromCode() {
  const codeInput = document.getElementById('joinClassCodeInput');
  const code = codeInput.value.trim().toUpperCase();

  if (!code) {
    alert('Please enter a class code.');
    return;
  }

  const foundClass = allClasses.find(c => c.code === code) || pinnedClasses.find(c => c.code === code);

  if (foundClass) {
    alert(`You have joined ${foundClass.name} by ${foundClass.creator}!`);
    toggleJoinPopup();
    codeInput.value = '';
  } else {
    alert('Invalid class code. Please try again.');
  }
}

function openDetailPage(type) {
    document.getElementById('classViewPage').classList.add('hidden');

    document.getElementById('assignmentDetailPage').classList.add('hidden');
    document.getElementById('materialDetailPage').classList.add('hidden');
    document.getElementById('announcementDetailPage').classList.add('hidden');

    if (type === 'assignment') {
        document.getElementById('assignmentDetailPage').classList.remove('hidden');
    } else if (type === 'material') {
        document.getElementById('materialDetailPage').classList.remove('hidden');
    } else if (type === 'announcement') {
        document.getElementById('announcementDetailPage').classList.remove('hidden');
    }
}

function goBack() {
    document.getElementById('assignmentDetailPage').classList.add('hidden');
    document.getElementById('materialDetailPage').classList.add('hidden');
    document.getElementById('announcementDetailPage').classList.add('hidden');
    document.getElementById('classViewPage').classList.remove('hidden');
}

function showMembers() {
    showTab('members');
}

window.onload = () => {
    renderPinnedClasses();
    renderAllClasses();
};
</script>


</x-layouts.mainlayout>
