@props(['creatorName', 'className', 'count', 'colorPrefix', 'role', 'code' => null])

@php
    $borderColor = "border-pastel-$colorPrefix";
    $shadowClass = "shadow-pastel-$colorPrefix";
    $bgClass = "bg-pastel-$colorPrefix";
    $textColor = "text-pastel-$colorPrefix";
    $roleClass = ($role === 'admin') ? 'text-main font-extrabold' : '';
@endphp

<a href="{{ $code ? route('classes.show', $code) : '#' }}" class="block no-underline">
<div class="bg-white border-[5px] {{ $borderColor }} {{ $shadowClass }} rounded-[40px] p-7 flex flex-col justify-between cursor-pointer hover:scale-[1.02] transition duration-200" title="{{ $className }}">

    <div class="flex justify-between gap-1.5">
        <div>
            <p class="text-gray-500 text-sm font-light font-poppins">{{ $creatorName }}</p>
            <p class="font-bold text-2xl font-outfit mb-6">{{ $className }}</p>
        </div>
        @if($code)
        <div class="relative" onclick="event.preventDefault(); event.stopPropagation();">
            <iconify-icon
                icon="ic:round-more-vert"
                width="32"
                height="32"
                class="text-main cursor-pointer hover:text-main/80"
                onclick="togglePinnedClassMenu(event, '{{ $code }}')">
            </iconify-icon>
            <div id="pinned-menu-{{ $code }}" class="hidden absolute right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg w-40 z-50">
                <button
                    onclick="togglePin(event, '{{ $code }}')"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg font-outfit flex items-center gap-2">
                    <iconify-icon icon="f7:pin-slash" width="16" height="16"></iconify-icon>
                    Unpin Class
                </button>
            </div>
        </div>
        @else
        <iconify-icon icon="ic:round-more-vert" width="32" height="32" class="text-main"></iconify-icon>
        @endif
    </div>

    <div class="flex justify-between items-end">
        
        <div>
            <div class="flex flex-col items-center justify-center {{ $bgClass }} rounded-[15px] px-6 py-4 text-center">
                <p class="text-main font-bold text-sm">Pending</p>
                <p class="text-main font-bold text-3xl">{{ $count }}</p>
            </div>
        </div>

        <div class="text-right">
            <p class="text-gray-500 text-xs font-light font-poppins">Joined as</p>
            <span class="font-bold text-sm font-poppins capitalize {{ $textColor }} {{ $roleClass }}">
                {{ $role }}
            </span>
        </div>

    </div>
</div>
</a>
