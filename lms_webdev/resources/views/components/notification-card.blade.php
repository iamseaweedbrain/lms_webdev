<div 
  {{ $attributes->merge(['class' => 'notification-card relative rounded-2xl px-6 py-4 flex items-center justify-between bg-white cursor-pointer transition-transform ease-in-out']) }}
  onclick="window.location.href='{{ $url }}'">
  <div class="flex items-center gap-4">
    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $bgColor }}">
      <iconify-icon icon="{{ $icon }}" width="22" height="22" class="text-black"></iconify-icon>
    </div>
    <div>
      <h3 class="font-semibold text-lg font-outfit">{{ $title }}</h3>
      <p class="text-gray-500 text-sm font-outfit">{{ $date }}</p>
    </div>
  </div>
</div>
