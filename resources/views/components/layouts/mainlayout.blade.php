<x-format>
    <div class="flex min-h-screen bg-page font-poppins text-main">
        <button
            id="sidebarToggle"
            type="button"
            class="md:hidden fixed top-4 left-4 z-50 flex items-center justify-center w-11 h-11 rounded-full border border-pastel-yellow bg-white text-main shadow-md focus:outline-none focus:ring-2 focus:ring-pastel-yellow"
            aria-label="Open navigation"
            aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                <path fill="currentColor" d="M4 6a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H5A1 1 0 0 1 4 6m0 6a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H5a1 1 0 0 1-1-1m1 5a1 1 0 0 0 0 2h14a1 1 0 1 0 0-2z"/>
            </svg>
        </button>

        <x-sidebar />

        <main class="flex-1 bg-page">
            {{ $slot }}
        </main>
    </div>
</x-format>
