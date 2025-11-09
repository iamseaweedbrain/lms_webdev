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
                <input type="text" placeholder="Search class..." class="pl-8 py-2 focus:outline-none pr-10 shadow-md rounded-[15px] w-[250px] h-[50px]">
                <iconify-icon icon="mingcute:search-line" width="20" height="20" class="absolute right-4 text-gray-500"></iconify-icon>
            </div>
        </div>

        <div class="flex flex-col xl:flex-row justify-between items-start gap-6 xl:gap-8 mb-5">
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
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Join Class
                                </a>
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
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
                                <a href="#" class="text-main hover:underline hover:text-pastel-yellow flex items-center gap-1">
                                    <iconify-icon icon="ic:twotone-arrow-right" width="24" height="24" class="text-pastel-yellow"></iconify-icon>
                                    Manage Class
                                </a>
                            </div>
                        </div>
                    </div>

                    <img src="{{ asset('images/cat-mascot.png') }}" 
                        alt="cat-mascot" 
                        class="hidden lg:block absolute right-6 xl:right--50 -top-[50px] w-44 xl:w-56 h-auto z-20">
                </div>
            </div>

            <div class="w-full xl:w-[420px] justify-center xl:pt-10"> 
                <div class="flex items-center gap-5 pl-3 md:pl-5 mb-6">
                    <iconify-icon icon="mingcute:horn-2-fill" width="24" height="24"></iconify-icon>
                    <p class="font-bold text-[26px] font-outfit">Recent Announcements</p>
                </div>

                <div class="flex flex-col gap-4 justify-center">
                    @forelse ($recentPosts as $post)
                        @php
                            $color = data_get($post, 'color_prefix', 'gray');
                            $borderColor = "border-pastel-{$color}";
                            $textColor = "text-pastel-{$color}";
                            $shadowColor = "shadow-pastel-{$color}";
                            $bgColor = "bg-pastel-{$color}";
                        @endphp
                        
                        <a href="{{ data_get($post, 'post_link', '#') }}" 
                            class="flex items-center gap-5 bg-white border-3 {{ $borderColor }} p-6 w-full max-w-[480px] min-h-[116px] rounded-[25px] {{ $shadowColor }} hover:scale-[1.03] transition">
                            
                            <img src="{{ data_get($post, 'avatar', 'avatars/active-cat.jpg') }}" 
                                alt="avatar" 
                                class="flex w-[82px] h-[82px] rounded-[50px] shrink-0">

                            <div class="h-20 border-l border-5 {{ $borderColor }}"></div>

                            <div class="flex flex-col justify-center grow min-w-0">
                                <p class="font-bold text-[20px] font-outfit">{{ data_get($post, 'class_name', 'Class Name') }}</p>
                                <p class="text-[14px] text-gray-500 font-outfit font-light truncate">
                                    {{ data_get($post, 'content', 'No post content provided.') }}
                                </p>
                            </div>

                            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="32" height="32" 
                                class="{{ $textColor }} border {{ $borderColor }}  rounded-[50px] shrink-0 hover:text-page hover:{{ $bgColor }}"></iconify-icon>
                        </a>
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
                <x-class-card 
                    :creatorName="data_get($class, 'creator')" 
                    :className="data_get($class, 'name')" 
                    :count="data_get($class, 'count')" 
                    :colorPrefix="data_get($class, 'color')" 
                    :role="data_get($class, 'role')" 
                />
            @empty
                <div class="text-center">
                    <p class="text-gray-500 col-span-full italic">You haven't joined any classes yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.mainlayout>