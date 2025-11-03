<x-layouts.landinglayout>

    <section class="flex flex-col items-center justify-center min-h-[80vh] space-y-6">
        <h1 class="text-2xl font-bold">LOGIN</h1>
        <form action="{{ route('retrieveLogIn') }}" method="POST" class="flex flex-col space-y-4 w-80">
            @csrf
            <input type="email" name="email" placeholder="Enter Email" class="rounded-full bg-gray-200 px-4 py-2 focus:outline-none">
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Enter Password" 
                    class="rounded-full bg-gray-200 px-4 py-2 w-full focus:outline-none">
                <button type="button" id="togglePassword" 
                    class="absolute right-4 top-2.5 text-gray-500 hover:text-black transition">
                    <iconify-icon icon="grommet-icons:form-view-hide" width="24" height="24"></iconify-icon>
                </button>
            </div>
            <a href="#" class="text-right text-sm underline">Forgot Password</a>
            <button type="submit" class="bg-black text-white py-2 rounded-full hover:bg-gray-800 transition">LOGIN</button>
        </form>

        <p class="text-sm">
            Doesn’t have an account?
            <a href="{{ route('signup') }}" class="text-placeholder hover:underline">Sign Up</a>
        </p>
    </section>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        let isHidden = true;

        togglePassword.addEventListener("click", () => {
            isHidden = !isHidden;
            passwordInput.type = isHidden ? "password" : "text";

            togglePassword.innerHTML = isHidden 
                ? '<iconify-icon icon="grommet-icons:form-view-hide" width="24" height="24"></iconify-icon>'
                : '<iconify-icon icon="grommet-icons:form-view" width="24" height="24"></iconify-icon>';
        });
    </script>

</x-layouts.landinglayout>

