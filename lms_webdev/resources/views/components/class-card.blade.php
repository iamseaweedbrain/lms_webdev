@props(['creatorName', 'className', 'count', 'colorPrefix', 'role'])

@php
    $borderColor = "border-pastel-$colorPrefix";
    $shadowClass = "shadow-pastel-$colorPrefix";
    $bgClass = "bg-pastel-$colorPrefix";
    $textColor = "text-pastel-$colorPrefix";
    $roleClass = ($role === 'admin') ? 'text-main font-extrabold' : '';
@endphp

<div class="bg-white border-[5px] {{ $borderColor }} {{ $shadowClass }} rounded-[40px] p-7 flex flex-col justify-between cursor-pointer hover:scale-[1.02] transition duration-200" title="{{ $className }}">
    
    <div class="flex justify-center gap-1.5">
        <div>
            <p class="text-gray-500 text-sm font-light font-poppins">{{ $creatorName }}</p>
            <p class="font-bold text-2xl font-outfit mb-6">{{ $className }}</p>
        </div>
        <iconify-icon icon="ic:round-more-vert" width="32" height="32" class="text-main"></iconify-icon>
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
