<x-layouts.mainlayout>
    <div class="pt-6 pb-10 pl-6 pr-5 md:pl-8 md:pr-11 lg:pl-10 lg:pr-15 xl:pl-12 xl:pr-19 mt-8">
        @php
            $today = now();
            $formattedDay = $today->format('l'); 
            $formattedDate = $today->format('F j');
        @endphp

        <div class="flex justify-between items-center mb-5">
            <h1 class="text-3xl font-bold font-poppins">Dashboard</h1>

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
        
        <x-search_popup />

        <div class="flex flex-col xl:flex-row justify-between items-start gap-16 xl:gap-28 mb-5">
            <div class="relative overflow-visible w-full xl:flex-1">
                <p class="font-outfit font-regular text-[36px] md:text-[48px] text-main px-6 md:px-10 xl:px-12">It’s a brand new day!</p>
                <p class="font-outfit font-regular text-[18px] md:text-[20px] text-main px-6 md:px-10 xl:px-12 mb-6">{{ $formattedDay }}, {{ $formattedDate }}</p>

                <div class="relative bg-white w-full xl:max-w-none md:min-h-80 px-6 md:px-10 lg:px-[78px] py-8 md:py-10 lg:py-[51px] border-5 border-pastel-yellow shadow-[12px_12px_0_0_#FBE7A1] rounded-[35px] md:rounded-[45px] z-10">
                    <div class="grid gap-8 md:grid-rows-2 md:gap-10">
                        <div>
                            <p class="font-outfit font-bold text-[42px] md:text-[64px] text-main leading-tight md:leading-none">Hi, {{ $userFirstName }}!</p>
                            <p class="font-outfit font-light text-[20px] md:text-[24px] text-main mt-2">What are we gonna do today?</p>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6 gap-4 md:gap-0">
                            <div class="grid gap-2 font-outfit font-light">
                                <a href="#" onclick="handleAddButtonClick()" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Join Class
                                </a>
                                <a href="{{ route('grades') }}" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    View Grades
                                </a>
                            </div>
                            <div class="hidden md:block h-10 border-l border-pastel-yellow"></div>
                            <div class="grid gap-2">
                                <a href="{{ route('add_class') }}" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Create Class
                                </a>
                                <a href="{{ route('classes') }}" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Manage Class
                                </a>
                            </div>
                        </div>
                    </div>

                    <img src="{{ asset('images/cat-mascot.png') }}" 
                         alt="cat-mascot" 
                         class="hidden lg:block absolute right-6 xl:right--50 -top-24 w-48 md:w-64 lg:w-80 xl:w-[470px] h-auto z-20">
                </div>
            </div>

            <div class="w-full xl:w-[420px] justify-left xl:pt-10"> 
                <div class="flex items-center gap-5 pl-3 md:pl-5 mb-6">
                    <iconify-icon icon="mingcute:horn-2-fill" width="24" height="24"></iconify-icon>
                    <p class="font-bold text-[26px] font-outfit">Recent Announcements</p>
                </div>

                <div class="flex flex-col gap-4 justify-center">
                    @forelse ($recentPosts as $post)
                        @php
                            // Laravel/PHP variables
                            $color = data_get($post, 'color_prefix', 'gray');
                            $borderColor = "border-pastel-{$color}";
                            $textColor = "text-pastel-{$color}";
                            $shadowColor = "shadow-pastel-{$color}";
                            $bgColor = "bg-pastel-{$color}";

                            // Encode the post object for the JavaScript function
                            $postJson = json_encode($post);
                        @endphp
                        
                        <div 
                            onclick="openPostPopupById(this)"
                            data-post='{{ $postJson }}'
                            class="flex items-center gap-5 bg-white border-3 {{ $borderColor }} p-6 w-full max-w-[480px] min-h-[116px] rounded-[25px] {{ $shadowColor }} cursor-pointer hover:scale-[1.03] transition">
                            
                            <img src="{{ data_get($post, 'avatar')}}" 
                                alt="avatar" 
                                class="flex w-[82px] h-[82px] rounded-[50px] shrink-0">

                            <div class="h-20 border-l border-5 {{ $borderColor }}"></div>

                            <div class="flex flex-col justify-center grow min-w-0">
                                <p class="font-bold text-[20px] font-outfit truncate">{{ data_get($post, 'class_name', 'Class Name') }}</p>
                                <p class="text-[14px] text-gray-500 font-outfit font-light truncate">
                                    {{ data_get($post, 'content', 'No post content provided.') }}
                                </p>
                            </div>

                            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="32" height="32" 
                                class="{{ $textColor }} border {{ $borderColor }} rounded-[50px] shrink-0 hover:text-page hover:{{ $bgColor }}"></iconify-icon>
                        </div>
                    @empty
                        <p class="text-gray-500 italic p-4">No recent posts found in your classes.</p>
                    @endforelse
                </div>
            </div>
        </div>

       <div class="flex items-center gap-5 pl-5 mt-8 mb-6 pt-8">
            <iconify-icon icon="si:book-fill" width="26" height="26"></iconify-icon>
            <p class="font-bold text-[26px] font-outfit">All Classes</p>
       </div>
        <div id="your-classes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
            @forelse ($allClasses as $class)
                <div class="class-search-item" 
                     data-classname="{{ strtolower(data_get($class, 'name', '')) }}" 
                     data-creator="{{ strtolower(data_get($class, 'creator', '')) }}"
                     data-code="{{ data_get($class, 'code', '#') }}"
                     data-href="{{ route('classes.show', ['code' => data_get($class, 'code', '#')]) }}"
                     >
                    
                    <x-class-card 
                        :creatorName="data_get($class, 'creator')" 
                        :className="data_get($class, 'name')" 
                        :count="data_get($class, 'count')" 
                        :colorPrefix="data_get($class, 'color')" 
                        :role="data_get($class, 'role')" 
                        :code="data_get($class, 'code')" 
                    />
                </div>
            @empty
                <div class="text-center">
                    <p class="text-gray-500 col-span-full italic">You haven't joined any classes yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- hehe copy paste na code sa join modal ni benis --}}
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

    <script>
        function openPostPopup(post) {
            console.log('Opening post popup with data:', post);
            // Implement modal display logic here
            alert(`Post: ${post.content}`); 
        }

        // The function you provided
        function openPostPopupById(element) {
            const postData = element.dataset.post;
            if (postData) {
                // IMPORTANT: The data attribute is always a string, so we must parse it.
                try {
                    const post = JSON.parse(postData);
                    // This function should be defined to show your custom modal 
                    // (replacing the default browser alert)
                    openPostPopup(post); 
                } catch (e) {
                    console.error("Error parsing post data:", e);
                }
            }
        }
        function handleAddButtonClick() {
            const currentMode = localStorage.getItem('viewMode') || 'student';
            toggleJoinPopup();
        }
        function toggleJoinPopup() {
            const popup = document.getElementById('joinClassPopup');
            popup.classList.toggle('hidden');
        }
        function joinClassFromCode() {
            console.log('Join class function called');
            const codeInput = document.getElementById('joinClassCodeInput');
            const code = codeInput.value.trim().toUpperCase();

            console.log('Entered code:', code);

            if (!code) {
                errorElement.classList.remove('hidden');
                return;
            }
            errorElement.classList.add('hidden');

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

        function searchClasses() {
            const searchTerm = document.getElementById('searchClassInput').value.toLowerCase().trim();
            const resultsContainer = document.getElementById('searchResultsContainer');
            const emptyMsg = document.getElementById('searchModalEmptyMsg');
            const modal = document.getElementById('searchResultsModal');

            if (!resultsContainer || !emptyMsg || !modal) return;

            if (!searchTerm) {
                resultsContainer.innerHTML = '';
                emptyMsg.textContent = 'Type your search and hit Enter.';
                emptyMsg.style.display = 'block';
                modal.classList.add('hidden');
                return;
            }

            modal.classList.remove('hidden');

            let resultsHTML = '';
            let matchCount = 0;

            const allClassItems = document.querySelectorAll('.class-search-item');

            allClassItems.forEach(item => {
                const className = (item.dataset.classname || '').toLowerCase();
                const creator = (item.dataset.creator || '').toLowerCase();
                const href = item.dataset.href || '#';

                if (className.includes(searchTerm) || creator.includes(searchTerm)) {
                    resultsHTML += `
                        <a href="${href}" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-outfit flex items-center justify-between gap-2 transition rounded-md">
                            <div class="flex flex-col justify-center min-w-0 flex-grow">
                                <h4 class="font-medium text-black truncate capitalize">${item.dataset.classname}</h4>
                                <p class="text-xs text-gray-500 font-outfit truncate capitalize">${item.dataset.creator}</p>
                            </div>
                            <iconify-icon icon="mdi:chevron-right" width="16" height="16" class="text-gray-400 shrink-0"></iconify-icon>
                        </a>`;
                    matchCount++;
                }
            });

            if (matchCount === 0) {
                resultsContainer.innerHTML = '';
                emptyMsg.textContent = `No classes found matching "${searchTerm}".`;
                emptyMsg.style.display = 'block';
            } else {
                resultsContainer.innerHTML = resultsHTML;
                emptyMsg.style.display = 'none';
            }
        }

        function openSearchModal() {
            const modal = document.getElementById('searchResultsModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeSearchModal() {
            const modal = document.getElementById('searchResultsModal');
            const input = document.getElementById('searchClassInput');
            
            if (modal) {
                modal.classList.add('hidden');
            }
            
            if (input) {
                 input.value = "";
            }
        }
    </script>
</x-layouts.mainlayout>