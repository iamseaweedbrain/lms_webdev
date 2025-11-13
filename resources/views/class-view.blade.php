<x-layouts.mainlayout>
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit animate-fade-in" id="successToast">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit animate-fade-in" id="errorToast">
            {{ session('error') }}
        </div>
    @endif

    <div id="classViewPage" class="p-6 mr-10" data-user-role="{{ $membership->role ?? 'member' }}">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('classes') }}"
                    class="text-main hover:bg-main/10 p-2 rounded-full transition">
                    <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
                </a>

                <div class="flex items-center gap-6 font-outfit text-lg -mt-2">
                    <button id="postsTab" onclick="showTab('posts')" class="font-semibold text-black border-b-4 border-[#F9CADA] pb-0">Posts</button>
                    <button id="assignmentsTab" onclick="showTab('assignments')" class="text-black pb-0">Assignments</button>
                    <button id="membersTab" onclick="showTab('members')" class="text-black pb-0">Members</button>
                </div>
            </div>

            <div class="flex items-center gap-4 -mt-2">
                <div class="relative">
                    <button
                        onclick="toggleClassCodePopup()"
                        class="p-2 hover:bg-gray-100 rounded-full transition"
                        title="Share Class Code">
                        <iconify-icon icon="mdi:share-variant-outline" width="26" height="26" class="text-black"></iconify-icon>
                    </button>

                    <div id="classCodePopup" class="hidden absolute right-0 mt-3 bg-white border border-gray-200 rounded-lg shadow-md p-3 w-52 z-50">
                        <p class="font-semibold text-sm text-gray-700 mb-2 font-outfit">Class Code:</p>
                        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-md px-3 py-2">
                            <span id="classCodeText" class="font-mono text-sm text-gray-700">{{ $class->code }}</span>
                            <button
                                onclick="copyClassCode()"
                                class="text-main font-outfit text-xs font-semibold hover:underline">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative rounded-2xl p-10 flex justify-between items-start mb-10 bg-pastel-{{ $class->color }} shadow-sm overflow-visible">
            <div class="flex items-center gap-6 z-10">
                <img
                    src="{{ asset('images/cat-mascot.png') }}"
                    alt="cat mascot"
                    class="w-[180px] h-[200px] object-contain pointer-events-none select-none shrink-0">
                <div>
                    <h1 class="text-4xl font-bold font-outfit text-black mb-1">{{ $class->classname }}</h1>
                    <p class="text-gray-700 font-outfit text-base mb-6">{{ $class->creator->name ?? 'Unknown' }}</p>
                </div>
            </div>

            <div class="text-right z-10 mt-[25px]"
                 data-posts-count="{{ $posts->count() }}"
                 data-assignments-count="{{ $assignments->count() }}"
                 data-members-count="{{ $members->count() }}">
                <span id="classCount" class="block text-5xl font-bold font-outfit text-black leading-none">{{ $posts->count() }}</span>
                <p id="classLabel" class="text-gray-800 font-outfit text-sm">Posts</p>
            </div>
        </div>

        <!-- POSTS TAB -->
        <div id="postsSection" class="flex flex-col gap-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-semibold text-lg font-outfit">Posts</h2>
                @if(($membership->role ?? 'member') === 'admin' || ($membership->role ?? 'member') === 'coadmin')
                <a href="{{ route('posts.create', ['code' => $class->code]) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition font-outfit text-sm">
                    <iconify-icon icon="ic:round-add" width="20" height="20"></iconify-icon>
                    Add New Post
                </a>
                @endif
            </div>

            @forelse ($posts as $post)
                @php
                    $borderColor = ($post->post_type ?? 'material') === 'announcement' ? 'border-{[#F9CADA]}' : 'border-[#CBE8E9]';
                    $shadowColor = ($post->post_type ?? 'material') === 'announcement' ? 'shadow-[8px_8px_0_0_#FBD1E2]' : 'shadow-[8px_8px_0_0_#B7E3E6]';
                    $isRead = in_array($post->post_id, $readPostIds ?? []);
                @endphp
                <div
                    onclick="openPostPopupById(this)"
                    class="relative bg-white w-full px-6 py-4 border {{ $borderColor }} rounded-2xl {{ $shadowColor }} cursor-pointer hover:scale-[1.02] transition duration-200 flex justify-between items-center"
                    data-post-id="{{ $post->post_id }}"
                    data-post='{{ json_encode($post) }}'
                    data-read="{{ $isRead ? 'true' : 'false' }}">
                    <div class="flex items-start gap-3 flex-1">
                        <!-- Read/Unread Indicator for Students -->
                        @if(($membership->role ?? 'member') === 'member')
                        <div class="read-indicator shrink-0 mt-1">
                            <iconify-icon icon="{{ $isRead ? 'mdi:check-circle' : 'mdi:circle' }}" width="12" height="12" class="{{ $isRead ? 'text-green-500' : 'text-gray-300' }}"></iconify-icon>
                        </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg font-outfit capitalize">{{ $post->post_type ?? 'Post' }}</h3>
                            <p class="text-gray-600 text-sm font-outfit">{{ Str::limit($post->content ?? '', 80) }}</p>
                            <p class="text-xs text-gray-400 font-outfit mt-1">
                                Posted by {{ $post->author_name ?? 'Unknown' }} • {{ $post->created_at ? \Carbon\Carbon::parse($post->created_at)->format('M d, Y') : 'Unknown date' }}
                            </p>
                        </div>
                    </div>
                    <iconify-icon
                        icon="ic:round-more-vert"
                        width="22" height="22"
                        class="text-gray-400 hover:text-black transition cursor-pointer"
                        onclick="event.stopPropagation();">
                    </iconify-icon>
                </div>
            @empty
                <p class="text-gray-500 italic p-4">No posts yet in this class.</p>
            @endforelse
        </div>

        <!-- ASSIGNMENTS TAB -->
        <div id="assignmentsSection" class="hidden flex flex-col gap-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-semibold text-lg font-outfit">Assignments</h2>
                @if(($membership->role ?? 'member') === 'admin' || ($membership->role ?? 'member') === 'coadmin')
                <a href="{{ route('assignments.create', ['code' => $class->code]) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition font-outfit text-sm">
                    <iconify-icon icon="ic:round-add" width="20" height="20"></iconify-icon>
                    Add New Assignment
                </a>
                @endif
            </div>

            @forelse ($assignments as $assignment)
                @php
                    $isDone = in_array($assignment->post_id, $readPostIds ?? []);
                    $submission = $submissions[$assignment->post_id] ?? null;
                @endphp
                <div
                    onclick="openAssignmentPopupById(this)"
                    class="relative bg-white w-full px-6 py-4 border border-[#F9CADA] rounded-2xl shadow-[8px_8px_0_0_#FBD1E2] cursor-pointer hover:scale-[1.02] transition duration-200 flex justify-between items-center"
                    data-assignment-id="{{ $assignment->post_id }}"
                    data-assignment='{{ json_encode($assignment) }}'
                    data-done="{{ $isDone ? 'true' : 'false' }}"
                    data-submission='{{ $submission ? json_encode($submission) : "" }}'>
                    <div class="flex items-start gap-3 flex-1">
                        <!-- Done/Not Done Indicator for Students -->
                        @if(($membership->role ?? 'member') === 'member')
                        <div class="done-indicator shrink-0 mt-1">
                            <iconify-icon icon="{{ $isDone ? 'mdi:check-circle' : 'mdi:circle' }}" width="12" height="12" class="{{ $isDone ? 'text-green-500' : 'text-gray-300' }}"></iconify-icon>
                        </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg font-outfit">{{ $assignment->post_title ?? 'Untitled Assignment' }}</h3>
                            <p class="text-gray-600 text-sm font-outfit">{{ Str::limit($assignment->content ?? '', 80) }}</p>
                            <p class="text-xs text-gray-400 font-outfit mt-1">
                                Due: {{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') : 'No due date' }}
                            </p>
                            @if($submission)
                                <p class="text-xs text-green-600 font-outfit font-medium mt-1">
                                    <iconify-icon icon="mdi:check-circle" class="inline" width="14" height="14"></iconify-icon>
                                    Turned In {{ \Carbon\Carbon::parse($submission->submitted_at)->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @if($submission)
                        <iconify-icon
                            icon="mdi:check-circle"
                            width="24" height="24"
                            class="text-green-500">
                        </iconify-icon>
                    @else
                        <iconify-icon
                            icon="ic:round-upload"
                            width="22" height="22"
                            class="text-gray-400 hover:text-black transition cursor-pointer"
                            onclick="event.stopPropagation();">
                        </iconify-icon>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 italic p-4">No assignments yet in this class.</p>
            @endforelse
        </div>

        <!-- MEMBERS TAB -->
        <div id="membersSection" class="hidden flex flex-col gap-6">
            <h2 class="font-semibold text-lg font-outfit mb-2">Class Members</h2>

            <!-- Teachers/Admins -->
            @php
                $teachers = $members->filter(fn($m) => in_array($m->role, ['admin', 'coadmin']));
                $students = $members->filter(fn($m) => $m->role === 'member');
            @endphp

            @if($teachers->count() > 0)
            <div>
                <h3 class="font-semibold text-md font-outfit text-gray-700 mb-2">Teachers</h3>
                <div class="flex flex-col gap-3">
                    @foreach($teachers as $teacher)
                    <div
                        onclick="openMemberProfile(this)"
                        class="bg-white border-2 border-[#F9CADA] rounded-xl p-4 flex justify-between items-center cursor-pointer hover:scale-[1.02] transition duration-200"
                        data-member='{{ json_encode($teacher) }}'>
                        <div class="flex items-center gap-4">
                            @if($teacher->avatar)
                            <img
                                src="{{ asset($teacher->avatar) }}"
                                alt="{{ $teacher->name }}"
                                class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @else
                            <div class="w-10 h-10 rounded-full bg-main flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-lg font-outfit text-black">{{ $teacher->name }}</p>
                                <p class="text-sm text-gray-500 font-outfit capitalize">{{ $teacher->role }}</p>
                            </div>
                        </div>
                        <iconify-icon icon="mdi:account-tie-outline" width="22" height="22" class="text-gray-500"></iconify-icon>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Students -->
            @if($students->count() > 0)
            <div>
                <h3 class="font-semibold text-md font-outfit text-gray-700 mb-2">Students</h3>
                <div class="flex flex-col gap-3">
                    @foreach($students as $student)
                    <div
                        onclick="openMemberProfile(this)"
                        class="bg-white border-2 border-[#CBE8E9] rounded-xl p-4 flex justify-between items-center cursor-pointer hover:scale-[1.02] transition duration-200"
                        data-member='{{ json_encode($student) }}'>
                        <div class="flex items-center gap-4">
                            @if($student->avatar)
                            <img
                                src="{{ asset($student->avatar) }}"
                                alt="{{ $student->name }}"
                                class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @else
                            <div class="w-10 h-10 rounded-full bg-pastel-blue flex items-center justify-center text-main font-bold">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-lg font-outfit text-black">{{ $student->name }}</p>
                                <p class="text-sm text-gray-500 font-outfit">Member</p>
                            </div>
                        </div>
                        <iconify-icon icon="mdi:account-outline" width="22" height="22" class="text-gray-500"></iconify-icon>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>

    <!-- MATERIAL DETAIL PAGE -->
    <div id="materialDetailPage" class="hidden px-10 py-6">
        <div class="flex justify-between items-center mb-6">
            <button
                onclick="goBackToClassView()"
                class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>
            <button id="materialActionBtn" class="bg-[#CBE8E9] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
                Mark As Read
            </button>
        </div>

        <div class="relative bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10
                    border-[3px] border-[#CBE8E9]
                    shadow-[12px_12px_0_0_#CBE8E9]
                    rounded-2xl z-10 flex flex-col font-outfit">

            <div class="flex flex-col">
                <div class="flex gap-6 items-center">
                    <div class="relative w-[300px] h-80">
                        <img
                            src="{{ asset('images/cat-mascot.png') }}"
                            alt="cat mascot"
                            class="absolute -left-10 bottom-0 translate-y-[-17%] translate-x-[10%] w-[300px] h-80 z-5 pointer-events-none select-none">
                    </div>

                    <div class="-mt-[140px] ml-[70px]">
                        <h2 id="materialTitle" class="font-semibold text-3xl leading-tight">Post Title</h2>
                        <p id="materialAuthor" class="text-gray-500 text-base mt-1">Creator Name</p>
                    </div>
                </div>

                <div class="-mt-15 flex items-center justify-between">
                    <p id="materialDate" class="text-gray-400 text-sm">Posted: Nov 1, 2025</p>
                    <div class="flex-1 ml-4 border-t-[5px] border-[#CBE8E9]"></div>
                </div>
            </div>

            <div class="mt-10 space-y-4 flex-1 overflow-y-auto">
                <div class="flex items-start gap-6">
                    <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Instructions</h3>
                    <p id="materialContent" class="text-gray-600 text-base leading-relaxed flex-1 max-h-[400px] overflow-y-auto">
                        Read through the attached slides and summarize key concepts.
                    </p>
                </div>

                <!-- File/Link Section -->
                <div id="materialFileSection" class="flex items-start gap-6 hidden">
                    <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Attached File</h3>
                    <div id="materialFileContent" class="flex-1">
                        <!-- File or link will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ANNOUNCEMENT DETAIL PAGE -->
    <div id="announcementDetailPage" class="hidden px-10 py-6">
        <div class="flex justify-between items-center mb-6">
            <button
                onclick="goBackToClassView()"
                class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>

            <button id="announcementActionBtn" class="bg-[#F9E8C9] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
                Mark As Read
            </button>
        </div>

        <div class="relative bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10
                    border-[3px] border-[#F9E8C9]
                    shadow-[12px_12px_0_0_#F9E8C9]
                    rounded-2xl z-10 flex flex-col font-outfit">

            <div class="flex flex-col">
                <div class="flex gap-6 items-center">
                    <div class="relative w-[300px] h-80">
                        <img
                            src="{{ asset('images/cat-mascot.png') }}"
                            alt="cat mascot"
                            class="absolute -left-10 bottom-0 translate-y-[-17%] translate-x-[10%] w-[300px] h-80 z-5 pointer-events-none select-none">
                    </div>

                    <div class="-mt-[140px] ml-[70px]">
                        <h2 id="announcementTitle" class="font-semibold text-3xl leading-tight">Post Title</h2>
                        <p id="announcementAuthor" class="text-gray-500 text-base mt-1">Creator Name</p>
                    </div>
                </div>

                <div class="-mt-15 flex items-center justify-between">
                    <p id="announcementDate" class="text-gray-400 text-sm">Posted: Nov 2, 2025</p>
                    <div class="flex-1 ml-4 border-t-[5px] border-[#F9E8C9]"></div>
                </div>
            </div>

            <div class="mt-10 space-y-4 flex-1 overflow-y-auto">
                <div class="flex items-start gap-6">
                    <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Announcement</h3>
                    <p id="announcementContent" class="text-gray-600 text-base leading-relaxed flex-1 max-h-[400px] overflow-y-auto">
                        Please submit your essay before Friday.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ASSIGNMENT DETAIL PAGE -->
    <div id="assignmentDetailPage" class="hidden px-10 py-6">
        <div class="flex justify-between items-center mb-6">
            <button
                onclick="goBackToClassView()"
                class="flex items-center gap-3 text-gray-600 hover:text-black hover:bg-main/10 p-2 rounded-full transition text-lg">
                <iconify-icon icon="mdi:arrow-left" width="28" height="28"></iconify-icon>
            </button>

            <button id="assignmentActionBtn" class="bg-[#F9CADA] text-black px-6 py-3 rounded-xl font-semibold hover:opacity-80 transition">
                Mark As Done
            </button>
        </div>

        <div class="relative bg-white w-[90%] max-w-5xl min-h-[80vh] mx-auto p-10
                    border-[3px] border-[#F9CADA]
                    shadow-[12px_12px_0_0_#F9CADA]
                    rounded-2xl z-10 flex flex-col font-outfit">

            <div class="flex flex-col">
                <div class="flex gap-6 items-center">
                    <div class="relative w-[300px] h-80">
                        <img
                            src="{{ asset('images/cat-mascot.png') }}"
                            alt="cat mascot"
                            class="absolute -left-10 bottom-0 translate-y-[-17%] translate-x-[10%] w-[300px] h-80 z-5 pointer-events-none select-none">
                    </div>

                    <div class="-mt-[140px] ml-[70px]">
                        <h2 id="assignmentTitle" class="font-semibold text-3xl leading-tight">Essay Submission</h2>
                        <p id="assignmentAuthor" class="text-gray-500 text-base mt-1">Mr. Santos</p>
                    </div>
                </div>

                <div class="-mt-15 flex items-center justify-between">
                    <p id="assignmentDate" class="text-gray-400 text-sm">Posted: Nov 2, 2025</p>
                    <div class="flex-1 ml-4 border-t-[5px] border-[#F9CADA]"></div>
                    <p id="assignmentDueDate" class="text-gray-400 text-sm ml-4">Due: Nov 10, 2025</p>
                </div>
            </div>

            <div class="mt-6 space-y-6 flex-1 overflow-y-auto">
                <div class="flex items-start gap-6">
                    <h3 id="submissionStatus" class="font-semibold text-gray-700 text-lg w-[150px]">Not Turned In</h3>
                    <div id="submissionContainer" class="relative border-[3px] border-[#F9CADA] rounded-xl p-3 flex-1 shadow-[5px_5px_0_0_#F9CADA]">
                        <!-- Not submitted state -->
                        <div id="notSubmittedState" class="flex items-center gap-3">
                            <input
                                type="file"
                                id="assignmentFile"
                                class="border border-gray-300 rounded-xl p-3 flex-1 text-base focus:ring-2 focus:ring-[#F9CADA] outline-none transition" />
                            <button
                                class="bg-[#F9CADA] px-4 py-2 rounded-xl font-semibold hover:opacity-80 transition shrink-0"
                                onclick="submitAssignment()">
                                SUBMIT
                            </button>
                        </div>

                        <!-- Submitted state (hidden by default) -->
                        <div id="submittedState" class="hidden">
                            <div class="flex items-center gap-3 text-green-600">
                                <iconify-icon icon="mdi:check-circle" width="24" height="24"></iconify-icon>
                                <div class="flex-1">
                                    <p class="font-semibold" id="submittedFileName">filename.pdf</p>
                                    <p class="text-sm text-gray-500" id="submittedDate">Submitted on Nov 9, 2025</p>
                                </div>
                                <a id="downloadSubmissionLink" href="#" download class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl font-semibold transition shrink-0">
                                    <iconify-icon icon="mdi:download" width="20" height="20" class="inline"></iconify-icon>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-6">
                    <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Instructions</h3>
                    <p id="assignmentContent" class="text-gray-600 text-base leading-relaxed flex-1 max-h-[400px] overflow-y-auto">
                        Write your essay according to the prompt.
                    </p>
                </div>

                <!-- Assignment File/Link Section -->
                <div id="assignmentFileSection" class="flex items-start gap-6 hidden">
                    <h3 class="font-semibold text-gray-700 text-lg w-[150px]">Attached File</h3>
                    <div id="assignmentFileContent" class="flex-1">
                        <!-- File or link will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MEMBER AVATAR MODAL -->
    <div id="memberProfileModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-6" onclick="closeMemberProfile()">
        <div class="relative" onclick="event.stopPropagation()">
            <button
                onclick="closeMemberProfile()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition">
                <iconify-icon icon="mdi:close" width="40" height="40"></iconify-icon>
            </button>
            <div id="profileAvatarContainer" class="rounded-2xl overflow-hidden shadow-2xl"></div>
        </div>
    </div>

    <!-- EDIT POST MODAL -->
    <div id="editPostModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-6" onclick="closeEditModal()">
        <div class="relative bg-white rounded-2xl w-full max-w-2xl p-8 shadow-2xl" onclick="event.stopPropagation()">
            <button
                onclick="closeEditModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-black transition">
                <iconify-icon icon="mdi:close" width="32" height="32"></iconify-icon>
            </button>

            <h2 class="text-2xl font-bold font-outfit mb-6">Edit <span id="editPostTypeLabel">Post</span></h2>

            <form id="editPostForm" class="space-y-4">
                <input type="hidden" id="editPostId" name="post_id">
                <input type="hidden" id="editPostType" name="post_type">

                <!-- Title Field -->
                <div>
                    <label for="editPostTitle" class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                    <input
                        type="text"
                        id="editPostTitle"
                        name="post_title"
                        required
                        class="w-full border-2 border-gray-300 rounded-xl p-3 text-base focus:ring-2 focus:ring-[#F9CADA] focus:border-[#F9CADA] outline-none transition">
                </div>

                <!-- Content/Description Field -->
                <div>
                    <label for="editPostContent" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span id="editContentLabel">Content</span>
                    </label>
                    <textarea
                        id="editPostContent"
                        name="content"
                        rows="6"
                        required
                        class="w-full border-2 border-gray-300 rounded-xl p-3 text-base focus:ring-2 focus:ring-[#F9CADA] focus:border-[#F9CADA] outline-none transition resize-none"></textarea>
                </div>

                <!-- File/Link Fields (only for materials) -->
                <div id="editMaterialFileContainer" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Attached File or Link</label>

                    <!-- Current file/link display -->
                    <div id="currentFileDisplay" class="mb-3"></div>

                    <!-- New file upload -->
                    <input
                        type="file"
                        id="editMaterialFile"
                        name="material_file"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.zip"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#F9CADA] focus:border-[#F9CADA] outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800">

                    <p class="text-xs text-gray-500 mt-2 mb-2">Or update the link below</p>

                    <!-- Link input -->
                    <input
                        type="url"
                        id="editMaterialLink"
                        name="material_link"
                        placeholder="https://example.com/resource"
                        class="w-full border-2 border-gray-300 rounded-xl p-3 text-base focus:ring-2 focus:ring-[#F9CADA] focus:border-[#F9CADA] outline-none transition">
                </div>

                <!-- Due Date Field (only for assignments) -->
                <div id="editDueDateContainer" class="hidden">
                    <label for="editDueDate" class="block text-sm font-semibold text-gray-700 mb-2">Due Date</label>
                    <input
                        type="datetime-local"
                        id="editDueDate"
                        name="due_date"
                        class="w-full border-2 border-gray-300 rounded-xl p-3 text-base focus:ring-2 focus:ring-[#F9CADA] focus:border-[#F9CADA] outline-none transition">
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 justify-end mt-6">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-6 py-3 border-2 border-gray-300 rounded-xl font-semibold hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-3 bg-[#F9CADA] rounded-xl font-semibold hover:opacity-80 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let currentPostId = null;
    let currentAssignmentId = null;

    function toggleClassCodePopup() {
        const popup = document.getElementById('classCodePopup');
        popup.classList.toggle('hidden');
    }

    function copyClassCode() {
        const codeText = document.getElementById('classCodeText').textContent;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(codeText).then(showToast);
        } else {
            const textarea = document.createElement("textarea");
            textarea.value = codeText;
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
            toast.textContent = `Copied ${codeText}`;
            toast.className = `
                fixed bottom-5 right-5 bg-main text-white
                px-4 py-2 rounded-xl shadow-lg text-sm font-outfit
                z-9999 opacity-0 transition-opacity duration-300
            `;
            document.body.appendChild(toast);

            requestAnimationFrame(() => toast.classList.add('opacity-100'));
            setTimeout(() => {
                toast.classList.remove('opacity-100');
                setTimeout(() => toast.remove(), 300);
            }, 1500);
        }
    }

    function showTab(tab) {
        document.getElementById('postsSection').classList.add('hidden');
        document.getElementById('assignmentsSection').classList.add('hidden');
        document.getElementById('membersSection').classList.add('hidden');

        ['postsTab', 'assignmentsTab', 'membersTab'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('border-b-4', 'border-[#F9CADA]', 'font-semibold', 'text-main');
                el.classList.add('text-gray-500');
            }
        });

        document.getElementById(`${tab}Section`).classList.remove('hidden');

        const activeTab = document.getElementById(`${tab}Tab`);
        activeTab.classList.add('border-b-4', 'border-[#F9CADA]', 'font-semibold', 'text-main');
        activeTab.classList.remove('text-gray-500');

        const classCountElement = document.getElementById('classCount');
        const classLabel = document.getElementById('classLabel');
        const countContainer = classCountElement.parentElement;

        const counts = {
            posts: parseInt(countContainer.dataset.postsCount),
            assignments: parseInt(countContainer.dataset.assignmentsCount),
            members: parseInt(countContainer.dataset.membersCount)
        };

        const labels = {
            posts: 'Posts',
            assignments: 'Assignments',
            members: 'Members'
        };

        classCountElement.textContent = counts[tab];
        classLabel.textContent = labels[tab];
    }

    function openPostPopupById(element) {
        const postData = element.dataset.post;
        if (postData) {
            const post = JSON.parse(postData);
            openPostPopup(post);
        }
    }

    function openAssignmentPopupById(element) {
        const assignmentData = element.dataset.assignment;
        const submissionData = element.dataset.submission;
        if (assignmentData) {
            const assignment = JSON.parse(assignmentData);
            const submission = submissionData ? JSON.parse(submissionData) : null;
            openAssignmentPopup(assignment, submission);
        }
    }

    function openPostPopup(post) {
        const postType = post.post_type || 'material';
        const userRole = document.getElementById('classViewPage').dataset.userRole;
        const isTeacher = userRole === 'admin' || userRole === 'coadmin';

        currentPostId = post.post_id;

        document.getElementById('classViewPage').classList.add('hidden');

        if (postType === 'announcement') {
            const page = document.getElementById('announcementDetailPage');
            document.getElementById('announcementTitle').textContent = post.post_title || 'Announcement';
            document.getElementById('announcementAuthor').textContent = post.author_name || 'Unknown';
            document.getElementById('announcementDate').textContent = post.created_at ? 'Posted: ' + new Date(post.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Posted: Unknown date';
            document.getElementById('announcementContent').textContent = post.content || 'No content available.';

            const btn = document.getElementById('announcementActionBtn');
            if (isTeacher) {
                btn.textContent = 'Edit';
                btn.onclick = function() {
                    openEditModal(post);
                };
            } else {
                btn.textContent = 'Mark As Read';
                btn.onclick = markAsRead;
            }

            page.classList.remove('hidden');
        } else {
            const page = document.getElementById('materialDetailPage');
            document.getElementById('materialTitle').textContent = post.post_title || 'Material';
            document.getElementById('materialAuthor').textContent = post.author_name || 'Unknown';
            document.getElementById('materialDate').textContent = post.created_at ? 'Posted: ' + new Date(post.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Posted: Unknown date';
            document.getElementById('materialContent').textContent = post.content || 'No content available.';

            const fileSection = document.getElementById('materialFileSection');
            const fileContent = document.getElementById('materialFileContent');

            if (post.file_path || post.file_link) {
                fileSection.classList.remove('hidden');

                if (post.file_link) {
                    fileContent.innerHTML = `
                        <a href="${post.file_link}" target="_blank"
                           class="inline-flex items-center gap-3 px-6 py-3 bg-[#CBE8E9] text-black rounded-xl font-semibold hover:opacity-80 transition">
                            <iconify-icon icon="mdi:link" width="24" height="24"></iconify-icon>
                            Open Link
                        </a>
                    `;
                } else if (post.file_path) {
                    const fileName = post.file_path.split('/').pop();
                    fileContent.innerHTML = `
                        <a href="/storage/${post.file_path}" target="_blank" download
                           class="inline-flex items-center gap-3 px-6 py-3 bg-[#CBE8E9] text-black rounded-xl font-semibold hover:opacity-80 transition">
                            <iconify-icon icon="mdi:file-download" width="24" height="24"></iconify-icon>
                            Download File
                        </a>
                        <p class="text-sm text-gray-500 mt-2">File: ${fileName}</p>
                    `;
                }
            } else {
                fileSection.classList.add('hidden');
            }

            const btn = document.getElementById('materialActionBtn');
            if (isTeacher) {
                btn.textContent = 'Edit';
                btn.onclick = function() {
                    openEditModal(post);
                };
            } else {
                btn.textContent = 'Mark As Read';
                btn.onclick = markAsRead;
            }

            page.classList.remove('hidden');
        }
    }

    function openAssignmentPopup(assignment, submission = null) {
        const userRole = document.getElementById('classViewPage').dataset.userRole;
        const isTeacher = userRole === 'admin' || userRole === 'coadmin';

        currentAssignmentId = assignment.post_id;

        document.getElementById('classViewPage').classList.add('hidden');

        const page = document.getElementById('assignmentDetailPage');
        document.getElementById('assignmentTitle').textContent = assignment.post_title || 'Untitled Assignment';
        document.getElementById('assignmentAuthor').textContent = assignment.author_name || 'Unknown';
        document.getElementById('assignmentDate').textContent = assignment.created_at ? 'Posted: ' + new Date(assignment.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Posted: Unknown date';
        document.getElementById('assignmentDueDate').textContent = assignment.due_date ? 'Due: ' + new Date(assignment.due_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Due: No due date';
        document.getElementById('assignmentContent').textContent = assignment.content || 'No content available.';

        const fileSection = document.getElementById('assignmentFileSection');
        const fileContent = document.getElementById('assignmentFileContent');

        if (assignment.file_path || assignment.file_link) {
            fileSection.classList.remove('hidden');

            if (assignment.file_link) {
                fileContent.innerHTML = `
                    <a href="${assignment.file_link}" target="_blank"
                       class="inline-flex items-center gap-3 px-6 py-3 bg-[#F9CADA] text-black rounded-xl font-semibold hover:opacity-80 transition">
                        <iconify-icon icon="mdi:link" width="24" height="24"></iconify-icon>
                        Open Link
                    </a>
                `;
            } else if (assignment.file_path) {
                const fileName = assignment.file_path.split('/').pop();
                fileContent.innerHTML = `
                    <a href="/storage/${assignment.file_path}" target="_blank" download
                       class="inline-flex items-center gap-3 px-6 py-3 bg-[#F9CADA] text-black rounded-xl font-semibold hover:opacity-80 transition">
                        <iconify-icon icon="mdi:file-download" width="24" height="24"></iconify-icon>
                        Download File
                    </a>
                    <p class="text-sm text-gray-500 mt-2">File: ${fileName}</p>
                `;
            }
        } else {
            fileSection.classList.add('hidden');
        }

        const submissionStatus = document.getElementById('submissionStatus');
        const notSubmittedState = document.getElementById('notSubmittedState');
        const submittedState = document.getElementById('submittedState');
        const assetBase = '{{ asset("") }}';

        if (submission) {
            submissionStatus.textContent = 'Turned In';
            notSubmittedState.classList.add('hidden');
            submittedState.classList.remove('hidden');

            const fileName = submission.file_path.split('/').pop();
            document.getElementById('submittedFileName').textContent = fileName;
            document.getElementById('submittedDate').textContent = 'Submitted on ' + new Date(submission.submitted_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            document.getElementById('downloadSubmissionLink').href = assetBase + 'storage/' + submission.file_path;
        } else {
            submissionStatus.textContent = 'Not Turned In';
            notSubmittedState.classList.remove('hidden');
            submittedState.classList.add('hidden');
        }

        const btn = document.getElementById('assignmentActionBtn');
        const submissionSection = document.querySelector('#assignmentDetailPage .mt-6.space-y-6 > div:first-child');

        if (isTeacher) {
            btn.textContent = 'Edit';
            btn.onclick = function() {
                openEditModal(assignment);
            };
            if (submissionSection) {
                submissionSection.style.display = 'none';
            }
        } else {
            btn.textContent = 'Mark As Done';
            btn.onclick = markAsDone;
            if (submissionSection) {
                submissionSection.style.display = 'flex';
            }
        }

        page.classList.remove('hidden');
    }

    function goBackToClassView() {
        document.getElementById('materialDetailPage').classList.add('hidden');
        document.getElementById('announcementDetailPage').classList.add('hidden');
        document.getElementById('assignmentDetailPage').classList.add('hidden');

        document.getElementById('classViewPage').classList.remove('hidden');
    }

    function markAsRead() {
        if (currentPostId) {
            fetch('{{ route("posts.mark-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    post_id: currentPostId
                })
            })
            .then(response => response.json())
            .then(data => {
                const postCard = document.querySelector(`[data-post-id="${currentPostId}"]`);
                if (postCard) {
                    if (data.status === 'read') {
                        postCard.dataset.read = 'true';
                        const indicator = postCard.querySelector('.read-indicator iconify-icon');
                        if (indicator) {
                            indicator.setAttribute('icon', 'mdi:check-circle');
                            indicator.classList.remove('text-gray-300');
                            indicator.classList.add('text-green-500');
                        }
                    }
                }
            })
            .catch(error => console.error('Error marking as read:', error));
        }

        const toast = document.createElement('div');
        toast.textContent = 'Marked as read!';
        toast.className = 'fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit animate-fade-in';
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 2000);

        goBackToClassView();
    }

    function markAsDone() {
        if (currentAssignmentId) {
            fetch('{{ route("posts.mark-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    post_id: currentAssignmentId
                })
            })
            .then(response => response.json())
            .then(data => {
                const assignmentCard = document.querySelector(`[data-assignment-id="${currentAssignmentId}"]`);
                if (assignmentCard) {
                    if (data.status === 'read') {
                        assignmentCard.dataset.done = 'true';
                        const indicator = assignmentCard.querySelector('.done-indicator iconify-icon');
                        if (indicator) {
                            indicator.setAttribute('icon', 'mdi:check-circle');
                            indicator.classList.remove('text-gray-300');
                            indicator.classList.add('text-green-500');
                        }
                    }
                }
            })
            .catch(error => console.error('Error marking as done:', error));
        }

        const toast = document.createElement('div');
        toast.textContent = 'Marked as done!';
        toast.className = 'fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit animate-fade-in';
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 2000);

        goBackToClassView();
    }

    function submitAssignment() {
        const fileInput = document.getElementById('assignmentFile');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please select a file to submit.');
            return;
        }

        if (!currentAssignmentId) {
            alert('Assignment ID not found.');
            return;
        }

        const formData = new FormData();
        formData.append('post_id', currentAssignmentId);
        formData.append('assignment_file', file);

        const loadingToast = document.createElement('div');
        loadingToast.textContent = 'Submitting...';
        loadingToast.className = 'fixed top-5 right-5 bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit';
        loadingToast.id = 'loadingToast';
        document.body.appendChild(loadingToast);

        fetch('{{ route("submissions.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingToast')?.remove();

            if (data.success) {
                const toast = document.createElement('div');
                toast.textContent = 'Assignment submitted successfully!';
                toast.className = 'fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit';
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);

                const submissionStatus = document.getElementById('submissionStatus');
                const notSubmittedState = document.getElementById('notSubmittedState');
                const submittedState = document.getElementById('submittedState');
                const assetBase = '{{ asset("") }}';

                submissionStatus.textContent = 'Turned In';
                notSubmittedState.classList.add('hidden');
                submittedState.classList.remove('hidden');

                const submission = data.submission;
                const fileName = submission.file_path.split('/').pop();
                document.getElementById('submittedFileName').textContent = fileName;
                document.getElementById('submittedDate').textContent = 'Submitted on ' + new Date(submission.submitted_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                document.getElementById('downloadSubmissionLink').href = assetBase + 'storage/' + submission.file_path;

                const assignmentCard = document.querySelector(`[data-assignment-id="${currentAssignmentId}"]`);
                if (assignmentCard) {
                    assignmentCard.dataset.submission = JSON.stringify(submission);

                    const uploadIcon = assignmentCard.querySelector('iconify-icon[icon="ic:round-upload"]');
                    if (uploadIcon) {
                        uploadIcon.setAttribute('icon', 'mdi:check-circle');
                        uploadIcon.setAttribute('width', '24');
                        uploadIcon.setAttribute('height', '24');
                        uploadIcon.className = 'text-green-500';
                    }

                    const cardContent = assignmentCard.querySelector('.flex-1');
                    let turnedInText = cardContent.querySelector('.text-green-600');
                    if (!turnedInText) {
                        turnedInText = document.createElement('p');
                        turnedInText.className = 'text-xs text-green-600 font-outfit font-medium mt-1';
                        turnedInText.innerHTML = '<iconify-icon icon="mdi:check-circle" class="inline" width="14" height="14"></iconify-icon> Turned In just now';
                        cardContent.appendChild(turnedInText);
                    }
                }
            } else {
                alert('Error: ' + (data.message || 'Failed to submit assignment'));
            }
        })
        .catch(error => {
            document.getElementById('loadingToast')?.remove();
            console.error('Error:', error);
            alert('An error occurred while submitting the assignment.');
        });
    }

    function openMemberProfile(element) {
        const memberData = element.dataset.member;
        if (!memberData) return;

        const member = JSON.parse(memberData);

        const avatarContainer = document.getElementById('profileAvatarContainer');
        const assetBase = '{{ asset("") }}';
        const defaultAvatar = '{{ asset("images/default-avatar.png") }}';

        if (member.avatar) {
            let avatarPath;
            if (member.avatar.startsWith('http')) {
                avatarPath = member.avatar;
            } else if (member.avatar.startsWith('avatars/') || member.avatar.startsWith('images/')) {
                avatarPath = assetBase + member.avatar;
            } else {
                avatarPath = assetBase + 'storage/avatars/' + member.avatar;
            }

            avatarContainer.innerHTML = `
                <img src="${avatarPath}"
                    alt="${member.name || 'Avatar'}"
                    class="w-[500px] h-[500px] object-cover"
                    onerror="this.src='${defaultAvatar}'">
            `;
        } else {
            avatarContainer.innerHTML = `
                <img src="${defaultAvatar}"
                    alt="${member.name || 'Avatar'}"
                    class="w-[500px] h-[500px] object-cover">
            `;
        }

        document.getElementById('memberProfileModal').classList.remove('hidden');
    }

    function closeMemberProfile() {
        document.getElementById('memberProfileModal').classList.add('hidden');
    }

    function openEditModal(postData) {
        const modal = document.getElementById('editPostModal');
        const form = document.getElementById('editPostForm');

        document.getElementById('editPostId').value = postData.post_id;
        document.getElementById('editPostType').value = postData.post_type;
        document.getElementById('editPostTitle').value = postData.post_title || '';
        document.getElementById('editPostContent').value = postData.content || '';

        const postTypeLabel = document.getElementById('editPostTypeLabel');
        const contentLabel = document.getElementById('editContentLabel');
        const dueDateContainer = document.getElementById('editDueDateContainer');
        const dueDateInput = document.getElementById('editDueDate');

        if (postData.post_type === 'assignment') {
            postTypeLabel.textContent = 'Assignment';
            contentLabel.textContent = 'Instructions';
            dueDateContainer.classList.remove('hidden');

            if (postData.due_date) {
                const dueDate = new Date(postData.due_date);
                const year = dueDate.getFullYear();
                const month = String(dueDate.getMonth() + 1).padStart(2, '0');
                const day = String(dueDate.getDate()).padStart(2, '0');
                const hours = String(dueDate.getHours()).padStart(2, '0');
                const minutes = String(dueDate.getMinutes()).padStart(2, '0');
                dueDateInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
            dueDateInput.required = true;

            const materialFileContainer = document.getElementById('editMaterialFileContainer');
            materialFileContainer.classList.remove('hidden');

            const currentFileDisplay = document.getElementById('currentFileDisplay');
            const editMaterialLink = document.getElementById('editMaterialLink');

            if (postData.file_path || postData.file_link) {
                let displayHtml = '<p class="text-sm text-gray-600 mb-2">Current:</p>';

                if (postData.file_link) {
                    displayHtml += `<a href="${postData.file_link}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-2">
                        <iconify-icon icon="mdi:link" width="16"></iconify-icon>
                        ${postData.file_link}
                    </a>`;
                    editMaterialLink.value = postData.file_link;
                } else if (postData.file_path) {
                    const fileName = postData.file_path.split('/').pop();
                    displayHtml += `<a href="/storage/${postData.file_path}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-2">
                        <iconify-icon icon="mdi:file" width="16"></iconify-icon>
                        ${fileName}
                    </a>`;
                }

                currentFileDisplay.innerHTML = displayHtml;
            } else {
                currentFileDisplay.innerHTML = '';
                editMaterialLink.value = '';
            }
        } else if (postData.post_type === 'announcement') {
            postTypeLabel.textContent = 'Announcement';
            contentLabel.textContent = 'Content';
            dueDateContainer.classList.add('hidden');
            dueDateInput.required = false;
            document.getElementById('editMaterialFileContainer').classList.add('hidden');
        } else {
            postTypeLabel.textContent = 'Material';
            contentLabel.textContent = 'Content';
            dueDateContainer.classList.add('hidden');
            dueDateInput.required = false;

            const materialFileContainer = document.getElementById('editMaterialFileContainer');
            materialFileContainer.classList.remove('hidden');

            const currentFileDisplay = document.getElementById('currentFileDisplay');
            const editMaterialLink = document.getElementById('editMaterialLink');

            if (postData.file_path || postData.file_link) {
                let displayHtml = '<p class="text-sm text-gray-600 mb-2">Current:</p>';

                if (postData.file_link) {
                    displayHtml += `<a href="${postData.file_link}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-2">
                        <iconify-icon icon="mdi:link" width="16"></iconify-icon>
                        ${postData.file_link}
                    </a>`;
                    editMaterialLink.value = postData.file_link;
                } else if (postData.file_path) {
                    const fileName = postData.file_path.split('/').pop();
                    displayHtml += `<a href="/storage/${postData.file_path}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-2">
                        <iconify-icon icon="mdi:file" width="16"></iconify-icon>
                        ${fileName}
                    </a>`;
                    editMaterialLink.value = '';
                }

                currentFileDisplay.innerHTML = displayHtml;
            } else {
                currentFileDisplay.innerHTML = '<p class="text-sm text-gray-500">No file or link attached</p>';
                editMaterialLink.value = '';
            }
        }

        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editPostModal').classList.add('hidden');
        document.getElementById('editPostForm').reset();
    }

    document.getElementById('editPostForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        const loadingToast = document.createElement('div');
        loadingToast.textContent = 'Updating...';
        loadingToast.className = 'fixed top-5 right-5 bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit';
        loadingToast.id = 'editLoadingToast';
        document.body.appendChild(loadingToast);

        fetch('{{ route("posts.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            document.getElementById('editLoadingToast')?.remove();

            if (result.success) {
                const toast = document.createElement('div');
                toast.textContent = 'Post updated successfully!';
                toast.className = 'fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-9999 font-outfit';
                document.body.appendChild(toast);

                setTimeout(() => toast.remove(), 3000);

                closeEditModal();

                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                alert('Error: ' + (result.message || 'Failed to update post'));
            }
        })
        .catch(error => {
            document.getElementById('editLoadingToast')?.remove();
            console.error('Error:', error);
            alert('An error occurred while updating the post.');
        });
    });

    document.addEventListener('click', function(event) {
        const classCodePopup = document.getElementById('classCodePopup');
        if (classCodePopup && !event.target.closest('#classCodePopup') && !event.target.closest('button[onclick="toggleClassCodePopup()"]')) {
            classCodePopup.classList.add('hidden');
        }
    });

    setTimeout(() => {
        document.getElementById('successToast')?.remove();
        document.getElementById('errorToast')?.remove();
    }, 3000);
    </script>
</x-layouts.mainlayout>
