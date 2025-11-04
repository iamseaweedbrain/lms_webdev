<x-format>
    <div class="flex min-h-screen bg-page font-poppins text-main">
        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Main Content --}}
        <main class="flex-1 bg-page">
            {{ $slot }}
        </main>
    </div>
</x-format>
