<x-layouts.mainlayout>
    <div>
        @php
            $today = now();
            $formattedDay = $today->format('l'); 
            $formattedDate = $today->format('F j');
        @endphp

        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold">Dashboard</h1>

            <div class="relative flex items-center">
                <input type="text" placeholder="Search class..." class="pl-8 py-2 rounded-full shadow-md focus:outline-none pr-10 w-[250px]">
                <iconify-icon 
                    icon="mingcute:search-line" 
                    width="20" 
                    height="20" 
                    class="absolute right-4 text-gray-500">
                </iconify-icon>
            </div>
        </div>

        <div class="flex justify-between items-start">
            <div class="relative overflow-visible w-fit">
                <p class="font-outfit font-regular text-[48px] text-main px-10">It’s a brand new day!</p>
                <p class="font-outfit font-regular text-[20px] text-main px-10 mb-6">{{ $formattedDay }}, {{ $formattedDate }}</p>

                <div class="relative bg-white w-[947px] h-[342px] px-[78px] py-[51px] border-5 border-pastel-yellow shadow-[12px_12px_0_0_#FBE7A1] rounded-[45px] z-10">
                    <div class="grid grid-rows-2 gap-10">
                        <div>
                            <p class="font-outfit font-bold text-[64px] text-main leading-none">Hi, {{ $userFirstName }}!</p>
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

            <div class="w-auto justify-center"> 
                <div class="flex gap-5 pl-5">
                    <iconify-icon icon="mdi:bullhorn" width="24" height="24"></iconify-icon>
                    <p class="font-bold text-lg mb-4 font-outfit">Recent Announcements</p>
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
                        class="flex items-center gap-5 bg-white border-3 {{ $borderColor }} p-6 w-[483px] h-[116px] rounded-[25px] {{ $shadowColor }} cursor-pointer hover:scale-[1.02] transition">
                            
                            <img src="{{ data_get($post, 'avatar', 'avatars/active-cat.jpg') }}" 
                                alt="avatar" 
                                class="w-[82px] h-[82px] rounded-[50px] flex-shrink-0">

                            <div class="h-20 border-l border-5 {{ $borderColor }}"></div>

                            <div class="flex flex-col justify-center grow min-w-0">
                                <p class="font-bold text-[20px] font-outfit">{{ data_get($post, 'class_name', 'Class Name') }}</p>
                                <p class="text-[14px] text-gray-500 font-outfit font-light truncate">
                                    {{ data_get($post, 'content', 'No post content provided.') }}
                                </p>
                            </div>

                            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="32" height="32" class="{{ $textColor }} border {{ $borderColor }} rounded-[50px] shrink-0"></iconify-icon>
                        </a>
                    @empty
                        <p class="text-gray-500 italic p-4">No recent posts found in your classes.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <h3 class="font-bold text-xl mt-8 mb-4 border-t border-gray-200 font-outfit pt-8">All Classes</h3>
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
                <p class="text-gray-500 col-span-full italic">You haven't joined any classes yet.</p>
            @endforelse
        </div>
        
        <div class="flex justify-end space-x-2 text-gray-500 text-sm mt-2">
            <iconify-icon icon="ic:baseline-keyboard-arrow-left" width="20" height="20" class="cursor-pointer hover:text-main"></iconify-icon>
            <span class="font-semibold">1</span>
            <iconify-icon icon="ic:baseline-keyboard-arrow-right" width="20" height="20" class="cursor-pointer hover:text-main"></iconify-icon>
        </div>
    </div>
</x-layouts.mainlayout>