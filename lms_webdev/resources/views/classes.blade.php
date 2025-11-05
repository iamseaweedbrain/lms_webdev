<x-layouts.mainlayout>
    <!-- CLASSES PAGE -->
    <div class="p-6" id="classesPage">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold font-outfit">Your Classes</h1>

            <div class="flex items-center gap-3">
                <button 
                    onclick="toggleJoinPopup()" 
                    class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">
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

        <!-- Pinned Classes -->
        <div class="mb-10">
            <h2 class="font-semibold text-xl mb-4 font-outfit">Pinned Classes</h2>
            <div id="pinned-classes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
        </div>

        <!-- All Classes -->
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
                    <p id="copyMsg" class="hidden text-green-600 text-xs mt-2 font-outfit">Copied!</p>
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
            <div class="bg-white border-2 border-[#F9CADA] rounded-xl p-4 hover:shadow-md transition flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-lg font-outfit">Announcement</h3>
                    <p class="text-gray-600 text-sm font-outfit">Please submit your essay before Friday.</p>
                    <p class="text-xs text-gray-400 font-outfit mt-1">Posted: Nov 2, 2025</p>
                </div>
                <iconify-icon icon="ic:round-more-vert" width="22" height="22" class="text-gray-400 hover:text-black transition cursor-pointer"></iconify-icon>
            </div>
            <div class="bg-white border-2 border-[#CBE8E9] rounded-xl p-4 hover:shadow-md transition flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-lg font-outfit">Announcement</h3>
                    <p class="text-gray-600 text-sm font-outfit">Quiz on Chapter 3 next meeting.</p>
                    <p class="text-xs text-gray-400 font-outfit mt-1">Posted: Nov 1, 2025</p>
                </div>
                <iconify-icon icon="ic:round-more-vert" width="22" height="22" class="text-gray-400 hover:text-black transition cursor-pointer"></iconify-icon>
            </div>
        </div>

        <!-- ASSIGNMENTS TAB -->
        <div id="assignmentsSection" class="hidden flex flex-col gap-4">
            <h2 class="font-semibold text-lg font-outfit mb-2">Assignments</h2>
            <div class="bg-white border-2 border-[#F9CADA] rounded-xl p-4 hover:shadow-md transition flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-lg font-outfit">Essay Submission</h3>
                    <p class="text-gray-600 text-sm font-outfit">Write a 300-word essay on modern art.</p>
                    <p class="text-xs text-gray-400 font-outfit mt-1">Due: Nov 5, 2025</p>
                </div>
                <iconify-icon icon="ic:round-upload" width="22" height="22" class="text-gray-400 hover:text-black transition cursor-pointer"></iconify-icon>
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

        <!-- POST / ASSIGNMENT DETAIL PAGE -->
        <div id="detailPage" class="hidden p-6 relative">
            <button 
                onclick="goBackToClassView()" 
                class="text-main hover:bg-main/10 p-2 rounded-full transition mb-6">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>

            <div class="bg-white border-2 border-[#F9CADA] rounded-2xl p-8 shadow-sm">
                <h2 id="detailTitle" class="text-3xl font-bold font-outfit mb-2">Post Title</h2>
                <p id="detailMeta" class="text-sm text-gray-500 font-outfit mb-4">Posted by: Teacher Name | Nov 2, 2025</p>
                <p id="detailBody" class="text-gray-700 font-outfit leading-relaxed">
                    This is where the full content of the post or assignment will appear.
                </p>
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

<script>
const dbData = {
    posts: 12,
    assignments: 3,
    members: 14
};

const pinnedClasses = [
    { creator: 'Mr. Santos', name: 'Algebra 101', count: '01', color: 'pink', status: 'Pending Assignments', role: 'Member', code: 'ALG101' },
    { creator: 'Ms. Lopez', name: 'Art Appreciation', count: '00', color: 'blue', status: 'No Pending Activities', role: 'Member', code: 'ART202' },
    { creator: 'Prof. Cruz', name: 'Physics Lab', count: '10', color: 'yellow', status: 'Check Student Work', role: 'Member', code: 'PHY303' },
    { creator: 'Dr. Reyes', name: 'English Composition', count: '01', color: 'purple', status: 'Pending Assignments', role: 'Member', code: 'ENG404' },
];

const allClasses = [
    { creator: 'Prof. Diaz', name: 'World Literature', count: '01', color: 'pink', status: 'Pending', code: 'LIT505' },
    { creator: 'Mr. Lim', name: 'Programming 2', count: '01', color: 'blue', status: 'Pending', code: 'PROG606' },
    { creator: 'Ms. Bautista', name: 'Philosophy', count: '01', color: 'yellow', status: 'Pending', code: 'PHI707' },
    { creator: 'Mr. Gomez', name: 'Multimedia Arts', count: '01', color: 'purple', status: 'Pending', code: 'MMA808' },
];

function generatePinnedCard(creatorName, className, count, color, role, code) {
    return `
        <div onclick="openClassView('${className}', '${creatorName}', '${count}', '${color}', '${code}')"
            class="bg-white border-2 border-pastel-${color} rounded-2xl p-6 flex flex-col justify-between cursor-pointer hover:scale-[1.02] transition duration-200 shadow-pastel-${color}">
            <div class="flex justify-between items-start mb-3">
                <p class="text-gray-500 text-sm font-outfit">${creatorName}</p>
                <iconify-icon icon="ic:round-more-vert" width="22" height="22" class="text-gray-400"></iconify-icon>
            </div>
            <h4 class="font-bold text-xl font-outfit mb-2">${className}</h4>

            <div class="flex items-center gap-2 mb-4">
                <p class="text-gray-600 text-sm font-outfit">Code:</p>
                <span id="class-code-${code}" class="font-semibold text-main text-sm font-outfit">${code}</span>
                <button 
                    onclick="copyPinnedClassCode('${code}', event)" 
                    class="text-gray-400 hover:text-black transition"
                    title="Copy code">
                    <iconify-icon icon="mdi:content-copy" width="16" height="16"></iconify-icon>
                </button>
            </div>

            <div class="flex justify-between items-end">
                <span class="bg-pastel-${color} text-black rounded-xl px-5 py-2 font-bold text-xl font-outfit shadow-sm">${count}</span>
                <div class="text-right">
                    <p class="text-gray-400 text-xs font-outfit">Joined as</p>
                    <p class="font-semibold text-sm font-outfit text-main">${role}</p>
                </div>
            </div>
        </div>
    `;
}

function copyPinnedClassCode(code, event) {
    event.stopPropagation();
    navigator.clipboard.writeText(code).then(() => {
        const toast = document.createElement('div');
        toast.textContent = `Copied ${code}`;
        toast.className = "fixed bottom-5 right-5 bg-main text-white px-4 py-2 rounded-xl shadow-lg text-sm font-outfit";
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 1500);
    });
}

function generateAllClassRow(creatorName, className, count, color, status, code) {
    return `
        <div onclick="openClassView('${className}', '${creatorName}', '${count}', '${color}', '${code}')"
            class="flex justify-between items-center bg-white border-2 border-pastel-${color} rounded-xl px-6 py-4 hover:scale-[1.02] transition duration-200 cursor-pointer shadow-pastel-${color}">
            <div>
                <p class="text-sm text-gray-500 font-outfit">${creatorName}</p>
                <h4 class="font-semibold text-lg font-outfit">${className}</h4>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center">
                    <p class="text-xs text-gray-500 font-outfit">${status}</p>
                    <span class="font-bold text-xl text-pastel-${color} font-outfit">${count}</span>
                </div>
                <!-- Removed the copy icon button -->
                <iconify-icon icon="ic:round-more-vert" width="22" height="22" class="text-gray-400"></iconify-icon>
            </div>
        </div>
    `;
}


function renderPinnedClasses() {
    document.getElementById('pinned-classes-container').innerHTML = pinnedClasses.map(c =>
        generatePinnedCard(c.creator, c.name, c.count, c.color, c.role, c.code)
    ).join('');
}

function renderAllClasses() {
    document.getElementById('all-classes-container').innerHTML = allClasses.map(c =>
        generateAllClassRow(c.creator, c.name, c.count, c.color, c.status, c.code)
    ).join('');
}

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

function copyClassCodePopup() {
    const codeText = document.getElementById('classCodeText').textContent;
    navigator.clipboard.writeText(codeText).then(() => {
        const msg = document.getElementById('copyMsg');
        msg.classList.remove('hidden');
        msg.classList.add('show');
        setTimeout(() => {
            msg.classList.remove('show');
            setTimeout(() => msg.classList.add('hidden'), 300);
        }, 1500);
    });
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
    alert(`✅ You have joined ${foundClass.name} by ${foundClass.creator}!`);
    toggleJoinPopup();
    codeInput.value = '';
  } else {
    alert('❌ Invalid class code. Please try again.');
  }
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
