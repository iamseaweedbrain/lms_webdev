<section class="font-poppins bg-page m-0">
    <div id="sidebarPanel" class="w-[120px] h-screen bg-white shadow-[2px_0_10px_rgba(0,0,0,0.05)] 
                flex flex-col justify-between items-center fixed top-0 left-0 gap-[60px] z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

        <button type="button" id="sidebarClose" class="md:hidden absolute top-4 right-3 flex items-center justify-center w-8 h-8 rounded-full border border-pastel-yellow text-main shadow-sm focus:outline-none focus:ring-2 focus:ring-pastel-yellow" aria-label="Close navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                <path fill="currentColor" d="M18.3 5.7a1 1 0 0 0-1.4-1.4L12 9.17L7.11 4.29A1 1 0 0 0 5.7 5.7L10.59 10.6L5.7 15.49a1 1 0 1 0 1.41 1.41L12 12l4.89 4.9a1 1 0 0 0 1.41-1.41L13.41 10.6z"/>
            </svg>
        </button>

        {{-- Top Icon --}}
        <a href="{{ route('notification') }}" 
           class="flex justify-center items-center w-[50px] h-[50px] my-10 rounded-full 
                  transition-all duration-200 ease-in-out text-main text-[22px] 
                  {{ request()->is('notification') ? 'bg-main text-pastel-pink' : 'hover:bg-main hover:text-pastel-pink' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                <rect width="24" height="24" fill="none"/>
                <path fill="currentColor" fill-rule="evenodd"
                      d="M12 1a2 2 0 0 0-1.98 2.284A7 7 0 0 0 5 10v8H4a1 1 0 1 0 0 2h16a1 1 0 1 0 0-2h-1v-8a7 7 0 0 0-5.02-6.716Q14 3.144 14 3a2 2 0 0 0-2-2m2 21a1 1 0 0 1-1 1h-2a1 1 0 1 1 0-2h2a1 1 0 0 1 1 1" 
                      clip-rule="evenodd"/>
            </svg>
        </a>

        {{-- Middle Navigation --}}
        <div class="flex flex-col items-center gap-9">
            <a href="{{ route('dashboard') }}" 
               class="flex justify-center items-center w-[50px] h-[50px] rounded-full text-[22px] transition-all duration-200 
                      {{ request()->is('dashboard') ? 'bg-main text-pastel-pink' : 'text-main hover:bg-main hover:text-pastel-pink' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <rect width="24" height="24" fill="none"/>
                    <path fill="currentColor"
                          d="M14 9q-.425 0-.712-.288T13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9zM4 13q-.425 0-.712-.288T3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13zm10 8q-.425 0-.712-.288T13 20v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21zM4 21q-.425 0-.712-.288T3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21z"/>
                </svg>
            </a>

            <a href="{{ route('classes') }}" 
               class="flex justify-center items-center w-[50px] h-[50px] rounded-full text-[22px] transition-all duration-200 
                      {{ request()->is('classes') ? 'bg-main text-pastel-pink' : 'text-main hover:bg-main hover:text-pastel-pink' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <rect width="24" height="24" fill="none"/>
                    <path fill="currentColor"
                          d="M17.25 2A2.75 2.75 0 0 1 20 4.75v14.5A2.75 2.75 0 0 1 17.25 22H6.75A2.75 2.75 0 0 1 4 19.249V4.75A2.75 2.75 0 0 1 6.75 2h.291v8.167c0 .748.79 1.014 1.319.74l.09-.055l2.093-1.197l2.14 1.23c.446.308 1.261.1 1.35-.59l.008-.128V2zm-4.709 0v7.076l-1.621-.932a.93.93 0 0 0-.793.022l-.107.063l-1.479.846V2z"/>
                </svg>
            </a>

            <a href="{{ route('grades') }}" 
               class="flex justify-center items-center w-[50px] h-[50px] rounded-full text-[22px] transition-all duration-200 
                      {{ request()->is('grades') ? 'bg-main text-pastel-pink' : 'text-main hover:bg-main hover:text-pastel-pink' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 48 48">
                    <rect width="48" height="48" fill="none"/>
                    <path fill="currentColor" fill-rule="evenodd"
                          d="M30.989 1.409C29.373 1.193 27.07 1 23.999 1c-3.07 0-5.372.193-6.988.409l.1.23c.234.53.581 1.307 1.033 2.283a168 168 0 0 0 3.883 7.83l.14.263a108 108 0 0 1 3.666 0l.14-.263a168 168 0 0 0 3.883-7.83a128 128 0 0 0 1.132-2.513M3.835 16.244c-.536-.782-.655-1.774-.255-2.634C6.85 6.588 14 2 14 2s3.333 7.948 8.655 17.06a15 15 0 0 0-11.353 6.95a124 124 0 0 1-7.466-9.766m32.862 9.767a124 124 0 0 0 7.466-9.767c.536-.782.655-1.774.255-2.634C41.15 6.588 33.999 2 33.999 2s-3.332 7.948-8.654 17.06a15 15 0 0 1 11.352 6.95M24 21.5c-6.904 0-12.5 5.596-12.5 12.5S17.096 46.5 24 46.5S36.5 40.904 36.5 34S30.904 21.5 24 21.5m1.11 6.14l1.51 2.912l3.22.634a1.25 1.25 0 0 1 .688 2.062l-2.288 2.545l.419 3.395a1.25 1.25 0 0 1-1.799 1.272L24 39.032l-2.86 1.428a1.25 1.25 0 0 1-1.799-1.272l.419-3.395l-2.288-2.545a1.25 1.25 0 0 1 .688-2.062l3.22-.634l1.51-2.913a1.25 1.25 0 0 1 2.22 0" 
                          clip-rule="evenodd"/>
                </svg>
            </a>

            <a href="{{ route('settings') }}" 
               class="flex justify-center items-center w-[50px] h-[50px] rounded-full text-[22px] transition-all duration-200 
                      {{ request()->is('account-settings') ? 'bg-main text-pastel-pink' : 'text-main hover:bg-main hover:text-pastel-pink' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <rect width="24" height="24" fill="none"/>
                    <path fill="currentColor"
                          d="M10.825 22q-.675 0-1.162-.45t-.588-1.1L8.85 18.8q-.325-.125-.612-.3t-.563-.375l-1.55.65q-.625.275-1.25.05t-.975-.8l-1.175-2.05q-.35-.575-.2-1.225t.675-1.075l1.325-1Q4.5 12.5 4.5 12.337v-.675q0-.162.025-.337l-1.325-1Q2.675 9.9 2.525 9.25t.2-1.225L3.9 5.975q.35-.575.975-.8t1.25.05l1.55.65q.275-.2.575-.375t.6-.3l.225-1.65q.1-.65.588-1.1T10.825 2h2.35q.675 0 1.163.45t.587 1.1l.225 1.65q.325.125.613.3t.562.375l1.55-.65q.625-.275 1.25-.05t.975.8l1.175 2.05q.35.575.2 1.225t-.675 1.075l-1.325 1q.025.175.025.338v.674q0 .163-.05.338l1.325 1q.525.425.675 1.075t-.2 1.225l-1.2 2.05q-.35.575-.975.8t-1.25-.05l-1.5-.65q-.275.2-.575.375t-.6.3l-.225 1.65q-.1.65-.587 1.1t-1.163.45zm1.225-6.5q1.45 0 2.475-1.025T15.55 12t-1.025-2.475T12.05 8.5q-1.475 0-2.488 1.025T8.55 12t1.013 2.475T12.05 15.5"/>
                </svg>
            </a>
        </div>

        {{-- Bottom Icon - Toggle Student/Teacher View --}}
        <button
           id="viewToggleBtn"
           onclick="toggleViewMode()"
           class="flex justify-center items-center w-[50px] h-[50px] my-10 rounded-full text-[22px] transition-all duration-200
                  {{ request()->is('classes') || request()->is('grades') ? 'text-main hover:bg-main hover:text-pastel-pink cursor-pointer' : 'text-gray-300 cursor-not-allowed' }}"
           title="{{ request()->is('classes') || request()->is('grades') ? 'Toggle Student/Teacher View' : 'Only available on Classes page' }}">
            <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256">
                <rect width="256" height="256" fill="none"/>
                <path fill="currentColor"
                      d="m231.65 194.55l-33.19-157.8a16 16 0 0 0-19-12.39l-46.81 10.06a16.08 16.08 0 0 0-12.3 19l33.19 157.8A16 16 0 0 0 169.16 224a16.3 16.3 0 0 0 3.38-.36l46.81-10.06a16.09 16.09 0 0 0 12.3-19.03M136 50.15v-.09l46.8-10l3.33 15.87L139.33 66Zm10 47.38l-3.35-15.9l46.82-10.06l3.34 15.9Zm70 100.41l-46.8 10l-3.33-15.87l46.8-10.07l3.33 15.85zM104 32H56a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h48a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16M56 48h48v16H56Zm48 160H56v-16h48z"/>
            </svg>
        </button>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden"></div>

    <div class="ml-0 md:ml-[120px]">
        {{ $slot }}
    </div>
</section>

<script>
function toggleViewMode() {
    const onTogglePage = window.location.pathname === '/classes' || window.location.pathname === '/grades';

    if (!onTogglePage) {
        const toast = document.createElement('div');
        toast.textContent = 'This feature is only available on the Classes page';
        toast.className = `
            fixed bottom-5 right-5 bg-gray-600 text-white
            px-4 py-2 rounded-xl shadow-lg text-sm font-outfit
            z-[9999] opacity-0 transition-opacity duration-300
        `;
        document.body.appendChild(toast);

        requestAnimationFrame(() => toast.classList.add('opacity-100'));

        setTimeout(() => {
            toast.classList.remove('opacity-100');
            setTimeout(() => toast.remove(), 300);
        }, 2000);

        return; 
    }

    const currentMode = localStorage.getItem('viewMode') || 'student';
    const newMode = currentMode === 'student' ? 'teacher' : 'student';

    localStorage.setItem('viewMode', newMode);
    const url = new URL(window.location.href);
    url.searchParams.set('view', newMode);
    window.location.href = url.toString();

    window.dispatchEvent(new CustomEvent('viewModeChanged', { detail: { mode: newMode } }));

    updateToggleButton(newMode);

    showViewModeToast(newMode);
}

function updateToggleButton(mode) {
    const btn = document.getElementById('viewToggleBtn');
    const icon = document.getElementById('toggleIcon');
    const onTogglePage = window.location.pathname === '/classes' || window.location.pathname === '/grades';

    if (!btn || !icon) return;

    if (onTogglePage) {
        if (mode === 'teacher') {
            btn.classList.add('bg-main', 'text-pastel-pink');
            btn.classList.remove('text-main', 'text-gray-300');
            icon.innerHTML = `
                <rect width="256" height="256" fill="none"/>
                <path fill="currentColor" d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h13.39a8 8 0 0 0 7.23-4.57a48 48 0 0 1 86.76 0a8 8 0 0 0 7.23 4.57H216a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16M80 144a24 24 0 1 1 24 24a24 24 0 0 1-24-24m136 56h-56.57a63.93 63.93 0 0 0-13.16-16.06a40 40 0 1 0-52.54 0A63.93 63.93 0 0 0 80.57 200H40V56h176Zm-88-56a24 24 0 1 1 24-24a24 24 0 0 1-24 24m0-40a16 16 0 1 0 16 16a16 16 0 0 0-16-16"/>
            `;
        } else {
            btn.classList.remove('bg-main', 'text-pastel-pink', 'text-gray-300');
            btn.classList.add('text-main');
            icon.innerHTML = `
                <rect width="256" height="256" fill="none"/>
                <path fill="currentColor" d="m231.65 194.55l-33.19-157.8a16 16 0 0 0-19-12.39l-46.81 10.06a16.08 16.08 0 0 0-12.3 19l33.19 157.8A16 16 0 0 0 169.16 224a16.3 16.3 0 0 0 3.38-.36l46.81-10.06a16.09 16.09 0 0 0 12.3-19.03M136 50.15v-.09l46.8-10l3.33 15.87L139.33 66Zm10 47.38l-3.35-15.9l46.82-10.06l3.34 15.9Zm70 100.41l-46.8 10l-3.33-15.87l46.8-10.07l3.33 15.85zM104 32H56a16 16 0 0 0-16 16v160a16 16 0 0 0 16 16h48a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16M56 48h48v16H56Zm48 160H56v-16h48z"/>
            `;
        }
    }
}

function showViewModeToast(mode) {
    const toast = document.createElement('div');
    toast.textContent = `Switched to ${mode.charAt(0).toUpperCase() + mode.slice(1)} View`;
    toast.className = `
        fixed bottom-5 right-5 bg-main text-white
        px-4 py-2 rounded-xl shadow-lg text-sm font-outfit
        z-[9999] opacity-0 transition-opacity duration-300
    `;
    document.body.appendChild(toast);

    requestAnimationFrame(() => toast.classList.add('opacity-100'));

    setTimeout(() => {
        toast.classList.remove('opacity-100');
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
    const currentMode = localStorage.getItem('viewMode') || 'student';
    updateToggleButton(currentMode);

    const sidebarPanel = document.getElementById('sidebarPanel');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const openButton = document.getElementById('sidebarToggle');
    const closeButton = document.getElementById('sidebarClose');

    if (!sidebarPanel) {
        return;
    }

    const closeSidebar = () => {
        sidebarPanel.classList.add('-translate-x-full');
        sidebarOverlay?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        if (openButton) {
            openButton.classList.remove('invisible');
            openButton.setAttribute('aria-expanded', 'false');
        }
    };

    const openSidebar = () => {
        if (window.innerWidth >= 768) {
            return;
        }
        sidebarPanel.classList.remove('-translate-x-full');
        sidebarOverlay?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        if (openButton) {
            openButton.classList.add('invisible');
            openButton.setAttribute('aria-expanded', 'true');
        }
    };

    openButton?.addEventListener('click', openSidebar);
    closeButton?.addEventListener('click', closeSidebar);
    sidebarOverlay?.addEventListener('click', closeSidebar);

    window.addEventListener('keydown', (event) => {
        const overlayVisible = sidebarOverlay ? !sidebarOverlay.classList.contains('hidden') : false;
        if (event.key === 'Escape' && window.innerWidth < 768 && overlayVisible) {
            closeSidebar();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebarPanel.classList.remove('-translate-x-full');
            sidebarOverlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (openButton) {
                openButton.classList.remove('invisible');
                openButton.setAttribute('aria-expanded', 'false');
            }
        } else {
            closeSidebar();
        }
    });
});
</script>

