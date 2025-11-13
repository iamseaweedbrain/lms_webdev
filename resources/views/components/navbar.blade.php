<header class="flex justify-between items-center px-8 py-4">
    <a href="{{ route('landingpage') }}" class="font-bold font-outfit text-xl">
        MEOW<span class="text-yellow-400">DULES</span>
    </a>

    <nav>
        @if (Route::currentRouteName() === 'landingpage')
            <a href="{{ route('login') }}" class="flex font-regular font-outfit items-center space-x-1">
                <iconify-icon icon="tabler:user-filled" width="20" height="20"></iconify-icon>
                <span>SIGN IN</span>
            </a>
        @else
            <a href="{{ route('landingpage') }}" class="flex items-center gap-2 px-4 py-2 text-main font-poppins text-sm hover:text-pastel-yellow ">
                <iconify-icon icon="iconamoon:home-fill" class="w-5 h-5"></iconify-icon>
                <span>HOME</span>
            </a>
        @endif
    </nav>
</header>