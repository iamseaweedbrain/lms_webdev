<x-layouts.mainlayout>
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-[9999] font-outfit animate-fade-in" id="successToast">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-[9999] font-outfit animate-fade-in" id="errorToast">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-5 right-5 bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg z-[9999] font-outfit animate-fade-in" id="infoToast">
            {{ session('info') }}
        </div>
    @endif

    <!-- CLASSES PAGE -->
    <div class="pt-6 pb-10 pl-6 pr-5 md:pl-8 md:pr-11 lg:pl-10 lg:pr-15 xl:pl-12 xl:pr-19 mt-8" id="classesPage">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold font-poppins">Your Classes</h1>

            <div class="flex items-center gap-3">
                <button
                    onclick="handleAddButtonClick()"
                    class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">
                    <iconify-icon icon="ic:round-add" width="26" height="26" class="text-black"></iconify-icon>
                </button>

                <div class="relative flex items-center">
                    <input
                        type="text"
                        id="searchClassInput"
                        placeholder="Search class..."
                        class="pl-8 py-2 focus:outline-none pr-10 shadow-md rounded-[15px] w-[250px] h-[50px]"
                        oninput="searchClasses()">
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
                    <div class="pinned-class-item"
                         data-role="{{ $class->user_role ?? 'member' }}"
                         data-classname="{{ strtolower($class->classname) }}"
                         data-creator="{{ strtolower($class->creator->name ?? 'N/A') }}"
                         data-created="{{ $class->created_at ?? '' }}">
                        <x-class-card
                            :creatorName="$class->creator->name ?? 'N/A'"
                            :className="$class->classname"
                            :count="$class->pending_count ?? 0"
                            :colorPrefix="$class->color ?? 'default'"
                            :role="$class->user_role ?? 'member'"
                            :code="$class->code"
                        />
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full ml-5" id="pinned-empty-message">You haven't pinned any classes yet.</p>
                @endforelse
            </div>
        </div>

        <!-- All Classes -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-5 pl-5">
                <iconify-icon icon="si:book-fill" width="20" height="20"></iconify-icon>
                <p class="font-bold text-[26px] font-outfit">All Classes</p>
            </div>
            <div class="relative flex items-center text-sm font-outfit text-gray-500 cursor-pointer" onclick="toggleSortDropdown()">
                <span id="sortLabel">Sort by Name</span>
                <iconify-icon
                    icon="mdi:chevron-down"
                    class="ml-1 text-gray-500 transition">
                </iconify-icon>
                <div id="sortDropdown" class="hidden absolute right-0 mt-6 bg-white border border-gray-200 rounded-lg shadow-md w-32 text-gray-600 text-sm z-10">
                    <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer rounded-t-lg" onclick="event.stopPropagation(); sortClasses('name')">Name</p>
                    <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer" onclick="event.stopPropagation(); sortClasses('creator')">Creator</p>
                    <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer" onclick="event.stopPropagation(); sortClasses('newest')">Newest</p>
                    <p class="px-3 py-2 hover:bg-gray-100 cursor-pointer rounded-b-lg" onclick="event.stopPropagation(); sortClasses('oldest')">Oldest</p>
                </div>
            </div>
        </div>

        <div id="all-classes-container" class="flex flex-col gap-4 mb-10">
            @forelse ($yourClasses as $class)
            @php
            $color = data_get($class, 'color', 'gray');

            $className = data_get($class, 'classname', 'Class Name');

            $borderColor = "border-pastel-{$color}";
            $textColor = "text-pastel-{$color}";
            $shadowColor = "shadow-pastel-{$color}";

            $creatorName = data_get($class, 'creator_name', 'Unknown Creator');
            $count = data_get($class, 'post_count', 0);
            $userRole = data_get($class, 'user_role', 'member');
            $latestUpdate = data_get($class, 'latest_update', null);
            @endphp

            <a href="{{ route('classes.show', $class->code) }}"
            data-role="{{ $userRole }}"
            data-classname="{{ strtolower($className) }}"
            data-creator="{{ strtolower($creatorName) }}"
            data-created="{{ $class->created_at ?? '' }}"
            class="class-item flex justify-between items-center bg-white border-3 {{ $borderColor }} rounded-[20px] px-6 py-4 hover:scale-[1.03] transition cursor-pointer {{ $shadowColor }} no-underline"
            >
            <div class="flex items-center gap-4">
                <div class="flex flex-col justify-center min-w-0">
                    <p class="text-sm text-gray-500 font-outfit truncate">{{ $creatorName }}</p>
                    <h4 class="font-semibold text-lg font-outfit truncate">{{ $className }}</h4>
                    <p class="text-[13px] text-gray-400 font-outfit truncate capitalize">
                        {{ $latestUpdate ?? 'No recent updates.' }}
                    </p>
                </div>
            </div>

            {{-- Right Section: count + menu --}}
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center">
                    <p class="text-xs text-gray-500 font-outfit">Posts</p>
                    <span class="font-bold text-xl {{ $textColor }} font-outfit">{{ $count }}</span>
                </div>

                <div class="relative">
                    <iconify-icon
                        icon="ic:round-more-vert"
                        width="22"
                        height="22"
                        class="text-gray-400 hover:text-black cursor-pointer"
                        onclick="toggleClassMenu(event, '{{ $class->code }}')"
                    ></iconify-icon>

                    <div id="menu-{{ $class->code }}" class="hidden absolute right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg w-40 z-50">
                        <button
                            onclick="togglePin(event, '{{ $class->code }}')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg font-outfit flex items-center gap-2">
                            <iconify-icon icon="f7:pin" width="16" height="16"></iconify-icon>
                            Pin Class
                        </button>

                        @if($userRole === 'admin' || $userRole === 'coadmin')
                        <button
                            onclick="deleteClass(event, '{{ $class->code }}', '{{ $className }}')"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-lg font-outfit flex items-center gap-2">
                            <iconify-icon icon="mdi:delete-outline" width="16" height="16"></iconify-icon>
                            Delete Class
                        </button>
                        @else
                        <button
                            onclick="leaveClass(event, '{{ $class->code }}', '{{ $className }}')"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-lg font-outfit flex items-center gap-2">
                            <iconify-icon icon="mdi:exit-to-app" width="16" height="16"></iconify-icon>
                            Leave Class
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            </a>
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
            onkeypress="if(event.key==='Enter') joinClassFromCode()"
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

function handleAddButtonClick() {
  const currentMode = localStorage.getItem('viewMode') || 'student';

  if (currentMode === 'teacher') {
    window.location.href = "{{ route('add_class') }}";
  } else {
    toggleJoinPopup();
  }
}

function toggleJoinPopup() {
  console.log("Add button clicked!");
  const popup = document.getElementById('joinClassPopup');
  popup.classList.toggle('hidden');
}

function joinClassFromCode() {
  console.log('Join class function called');
  const codeInput = document.getElementById('joinClassCodeInput');
  const code = codeInput.value.trim().toUpperCase();

  console.log('Entered code:', code);

  if (!code) {
    alert('Please enter a class code.');
    return;
  }

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = "{{ route('classes.join') }}";

  const csrfInput = document.createElement('input');
  csrfInput.type = 'hidden';
  csrfInput.name = '_token';
  csrfInput.value = "{{ csrf_token() }}";
  form.appendChild(csrfInput);

  const codeInput2 = document.createElement('input');
  codeInput2.type = 'hidden';
  codeInput2.name = 'code';
  codeInput2.value = code;
  form.appendChild(codeInput2);

  console.log('Submitting form to join class');
  document.body.appendChild(form);
  form.submit();
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

window.addEventListener('viewModeChanged', function(event) {
    const newMode = event.detail.mode;
    filterClassesByRole(newMode);
});

function filterClassesByRole(mode) {
    const allClassItems = document.querySelectorAll('.class-item');
    let visibleClassCount = 0;

    console.log('Filter mode:', mode);
    console.log('Total class items:', allClassItems.length);

    allClassItems.forEach(item => {
        const role = item.dataset.role;
        const classname = item.dataset.classname;

        console.log('Class:', classname, 'Role:', role);

        if (mode === 'teacher') {
            if (role === 'admin' || role === 'coadmin') {
                item.style.display = 'flex';
                visibleClassCount++;
                console.log('  -> SHOWING (teacher mode, role is admin/coadmin)');
            } else {
                item.style.display = 'none';
                console.log('  -> HIDING (teacher mode, role is', role + ')');
            }
        } else {
            if (role === 'member') {
                item.style.display = 'flex';
                visibleClassCount++;
                console.log('  -> SHOWING (student mode, role is member)');
            } else {
                item.style.display = 'none';
                console.log('  -> HIDING (student mode, role is', role + ')');
            }
        }
    });

    console.log('Visible classes:', visibleClassCount);

    const allClassesContainer = document.getElementById('all-classes-container');
    const existingEmptyMsg = allClassesContainer.querySelector('.empty-message');

    if (visibleClassCount === 0) {
        if (!existingEmptyMsg) {
            const emptyMsg = document.createElement('p');
            emptyMsg.className = 'text-gray-500 italic p-4 empty-message';
            emptyMsg.textContent = mode === 'teacher'
                ? "You don't have any classes as a teacher."
                : "You're not enrolled in any classes as a student.";
            allClassesContainer.appendChild(emptyMsg);
        }
    } else if (existingEmptyMsg) {
        existingEmptyMsg.remove();
    }

    const pinnedItems = document.querySelectorAll('.pinned-class-item');
    const emptyMessage = document.getElementById('pinned-empty-message');
    let visiblePinnedCount = 0;

    pinnedItems.forEach(item => {
        const role = item.dataset.role;

        if (mode === 'teacher') {
            if (role === 'admin' || role === 'coadmin') {
                item.style.display = 'block';
                visiblePinnedCount++;
            } else {
                item.style.display = 'none';
            }
        } else {
            if (role === 'member') {
                item.style.display = 'block';
                visiblePinnedCount++;
            } else {
                item.style.display = 'none';
            }
        }
    });

    if (emptyMessage) {
        if (visiblePinnedCount === 0 && pinnedItems.length > 0) {
            const newMessage = mode === 'teacher'
                ? "You haven't pinned any classes where you're a teacher."
                : "You haven't pinned any classes where you're a student.";
            emptyMessage.textContent = newMessage;
            emptyMessage.style.display = 'block';
        } else if (visiblePinnedCount > 0) {
            emptyMessage.style.display = 'none';
        }
    }
}

function searchClasses() {
    const searchTerm = document.getElementById('searchClassInput').value.toLowerCase().trim();
    const currentMode = localStorage.getItem('viewMode') || 'student';

    const allClassItems = document.querySelectorAll('.class-item');
    let visibleClassCount = 0;

    allClassItems.forEach(item => {
        const role = item.dataset.role;
        const className = item.dataset.classname || '';
        const creator = item.dataset.creator || '';

        const matchesMode = (currentMode === 'teacher' && (role === 'admin' || role === 'coadmin')) ||
                           (currentMode === 'student' && role === 'member');

        const matchesSearch = className.includes(searchTerm) || creator.includes(searchTerm);

        if (matchesMode && matchesSearch) {
            item.style.display = 'flex';
            visibleClassCount++;
        } else {
            item.style.display = 'none';
        }
    });

    const allClassesContainer = document.getElementById('all-classes-container');
    const existingEmptyMsg = allClassesContainer.querySelector('.empty-message');

    if (visibleClassCount === 0) {
        if (!existingEmptyMsg) {
            const emptyMsg = document.createElement('p');
            emptyMsg.className = 'text-gray-500 italic p-4 empty-message';
            emptyMsg.textContent = searchTerm
                ? `No classes found matching "${searchTerm}".`
                : (currentMode === 'teacher'
                    ? "You don't have any classes as a teacher."
                    : "You're not enrolled in any classes as a student.");
            allClassesContainer.appendChild(emptyMsg);
        }
    } else if (existingEmptyMsg) {
        existingEmptyMsg.remove();
    }

    const pinnedItems = document.querySelectorAll('.pinned-class-item');
    const emptyMessage = document.getElementById('pinned-empty-message');
    let visiblePinnedCount = 0;

    pinnedItems.forEach(item => {
        const role = item.dataset.role;
        const className = item.dataset.classname || '';
        const creator = item.dataset.creator || '';

        const matchesMode = (currentMode === 'teacher' && (role === 'admin' || role === 'coadmin')) ||
                           (currentMode === 'student' && role === 'member');
        const matchesSearch = className.includes(searchTerm) || creator.includes(searchTerm);

        if (matchesMode && matchesSearch) {
            item.style.display = 'block';
            visiblePinnedCount++;
        } else {
            item.style.display = 'none';
        }
    });

    if (emptyMessage) {
        if (visiblePinnedCount === 0 && pinnedItems.length > 0) {
            const newMessage = searchTerm
                ? `No pinned classes found matching "${searchTerm}".`
                : (currentMode === 'teacher'
                    ? "You haven't pinned any classes where you're a teacher."
                    : "You haven't pinned any classes where you're a student.");
            emptyMessage.textContent = newMessage;
            emptyMessage.style.display = 'block';
        } else if (visiblePinnedCount > 0) {
            emptyMessage.style.display = 'none';
        }
    }
}

function toggleSortDropdown() {
    const dropdown = document.getElementById('sortDropdown');
    dropdown.classList.toggle('hidden');
}

function sortClasses(sortBy) {
    console.log('Sorting by:', sortBy);

    const container = document.getElementById('all-classes-container');
    const classItems = Array.from(container.querySelectorAll('.class-item'));
    const emptyMessage = container.querySelector('.empty-message');

    console.log('Found class items:', classItems.length);

    if (classItems.length > 0) {
        console.log('First item data:', {
            classname: classItems[0].dataset.classname,
            creator: classItems[0].dataset.creator,
            created: classItems[0].dataset.created
        });
    }

    const sortLabel = document.getElementById('sortLabel');
    const sortLabels = {
        'name': 'Sort by Name',
        'creator': 'Sort by Creator',
        'newest': 'Sort by Newest',
        'oldest': 'Sort by Oldest'
    };
    sortLabel.textContent = sortLabels[sortBy] || 'Sort by Name';

    document.getElementById('sortDropdown').classList.add('hidden');

    classItems.sort((a, b) => {
        switch(sortBy) {
            case 'name':
                const nameA = a.dataset.classname || '';
                const nameB = b.dataset.classname || '';
                return nameA.localeCompare(nameB);

            case 'creator':
                const creatorA = a.dataset.creator || '';
                const creatorB = b.dataset.creator || '';
                return creatorA.localeCompare(creatorB);

            case 'newest':
                const dateA = new Date(a.dataset.created || 0);
                const dateB = new Date(b.dataset.created || 0);
                return dateB - dateA; // Newest first

            case 'oldest':
                const dateAOld = new Date(a.dataset.created || 0);
                const dateBOld = new Date(b.dataset.created || 0);
                return dateAOld - dateBOld; // Oldest first

            default:
                return 0;
        }
    });

    console.log('Sorted, re-appending items...');

    classItems.forEach(item => {
        container.appendChild(item);
    });

    if (emptyMessage) {
        container.appendChild(emptyMessage);
    }

    console.log('Sort complete!');
}

function toggleClassMenu(event, code) {
    event.preventDefault(); // Prevent link navigation
    event.stopPropagation(); // Prevent opening the class view

    const menu = document.getElementById(`menu-${code}`);

    document.querySelectorAll('[id^="menu-"]').forEach(m => {
        if (m.id !== `menu-${code}`) {
            m.classList.add('hidden');
        }
    });
    document.querySelectorAll('[id^="pinned-menu-"]').forEach(m => {
        m.classList.add('hidden');
    });

    menu.classList.toggle('hidden');
}

function togglePinnedClassMenu(event, code) {
    event.preventDefault(); // Prevent link navigation
    event.stopPropagation(); // Prevent opening the class view

    const menu = document.getElementById(`pinned-menu-${code}`);

    document.querySelectorAll('[id^="pinned-menu-"]').forEach(m => {
        if (m.id !== `pinned-menu-${code}`) {
            m.classList.add('hidden');
        }
    });
    document.querySelectorAll('[id^="menu-"]').forEach(m => {
        m.classList.add('hidden');
    });

    menu.classList.toggle('hidden');
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('[id^="menu-"]') &&
        !event.target.closest('[id^="pinned-menu-"]') &&
        !event.target.closest('iconify-icon[icon="ic:round-more-vert"]')) {
        document.querySelectorAll('[id^="menu-"]').forEach(m => {
            m.classList.add('hidden');
        });
        document.querySelectorAll('[id^="pinned-menu-"]').forEach(m => {
            m.classList.add('hidden');
        });
    }

    const sortDropdown = document.getElementById('sortDropdown');
    if (sortDropdown && !event.target.closest('#sortDropdown') && !event.target.closest('[onclick*="toggleSortDropdown"]')) {
        sortDropdown.classList.add('hidden');
    }
});

function togglePin(event, code) {
    event.preventDefault(); // Prevent link navigation
    event.stopPropagation(); // Prevent opening the class view

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/classes/${code}/pin`;

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = "{{ csrf_token() }}";
    form.appendChild(csrfInput);

    document.body.appendChild(form);
    form.submit();
}

function leaveClass(event, code, className) {
    event.preventDefault();
    event.stopPropagation();

    if (confirm(`Are you sure you want to leave "${className}"? You will need the class code to rejoin.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/classes/${code}/leave`;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = "{{ csrf_token() }}";
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function deleteClass(event, code, className) {
    event.preventDefault();
    event.stopPropagation();

    if (confirm(`Are you sure you want to DELETE "${className}"? This action cannot be undone. All posts, assignments, and member data will be permanently removed.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/classes/${code}/delete`;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = "{{ csrf_token() }}";
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const successToast = document.getElementById('successToast');
    const errorToast = document.getElementById('errorToast');
    const infoToast = document.getElementById('infoToast');

    if ((successToast && successToast.textContent.includes('joined')) || infoToast) {
        localStorage.setItem('viewMode', 'student');
    }

    const currentMode = localStorage.getItem('viewMode') || 'student';
    filterClassesByRole(currentMode);

    [successToast, errorToast, infoToast].forEach(toast => {
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 300ms';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    });
});
</script>


</x-layouts.mainlayout>
