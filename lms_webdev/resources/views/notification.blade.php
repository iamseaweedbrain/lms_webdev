<x-layouts.mainlayout>
    <div class="p-10">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold font-poppins">Notifications</h1>

            <div class="relative flex items-center">
                <input
                    type="text"
                    placeholder="Search activity..."
                    class="pl-8 py-2 pr-10 shadow-md rounded-[15px] w-[250px] h-[50px] focus:outline-none">
                <iconify-icon icon="mingcute:search-line" width="20" height="20" class="absolute right-4 text-gray-500"></iconify-icon>
            </div>
        </div>

        <div class="flex flex-col gap-5">
            @foreach($notifications as $notification)
                <x-notification-card 
                    :title="$notification['title']"
                    :date="$notification['date']"
                    :icon="$notification['icon']"
                    :bgColor="$notification['bgColor']"
                    :url="$notification['url']"
                    class="border-[3px] shadow-[8px_8px_0_0_{{ $notification['bgColor'] }}]" />
            @endforeach
        </div>
    </div>
</x-layouts.mainlayout>