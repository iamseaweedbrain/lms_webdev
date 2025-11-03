<x-format>
    <div class="flex min-h-screen bg-page font-poppins text-main">
        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Main Content --}}
        <main class="flex-1 p-8 md:p-12">
            {{ $slot }}
        </main>
    </div>
</x-format>
