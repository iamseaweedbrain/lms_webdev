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
                @php
                    // Set icon & color based on type
                    switch ($notification->type) {
                        case 'assignment':
                            $icon = 'mdi:book-open-variant';
                            $bgColor = '#F9CADA';
                            break;
                        case 'announcement':
                            $icon = 'mdi:bullhorn-outline';
                            $bgColor = '#D9CCF1';
                            break;
                        case 'reminder':
                            $icon = 'mdi:calendar-alert';
                            $bgColor = '#FCEED1';
                            break;
                        default:
                            $icon = 'mdi:bell-outline';
                            $bgColor = '#E3E8EF';
                    }

                    $date = 'Posted: ' . \Carbon\Carbon::parse($notification->created_at)->format('M d, Y');
                    $title = ucfirst($notification->type) . ': ' . ($notification->message ?? '');
                @endphp

                <x-notification-card 
                    :title="$title"
                    :date="$date"
                    :icon="$icon"
                    :bgColor="$bgColor"
                    :url="$notification->url"
                    class="border-[3px] shadow-[8px_8px_0_0_{{ $bgColor }}] {{ $notification->is_read ? 'opacity-60' : '' }}"
                />
            @endforeach
        </div>
    </div>

    <script>
        function markAsRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json())
            .then(data => location.reload());
        }
    </script>
</x-layouts.mainlayout>
