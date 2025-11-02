<header class="flex justify-between items-center px-8 py-4">
    <a href="{{ url('/') }}" class="font-bold text-xl">
        LEARN<span class="text-yellow-400">FINITY</span>
    </a>

    <nav>
        @if (Route::currentRouteName() === 'landingpage')
            <a href="{{ route('login') }}" class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3m12 0l-4-4m4 4l-4 4m4 0h6"/></svg>
                <span>SIGN IN</span>
            </a>
        @else
            <a href="{{ route('landingpage') }}" class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4 4h10a2 2 0 002-2V12a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>HOME</span>
            </a>
        @endif
    </nav>
</header>