<x-layouts.mainlayout title="Account Settings">
    <section class="min-h-screen w-full font-poppins text-main bg-page flex flex-col">
        <h2 class="text-3xl md:text-4xl font-semibold p-8">Account Settings</h2>

        <div class="flex flex-col md:flex-row items-stretch gap-16 flex-1 p-9">
            <div class="flex-1 flex flex-col md:mx-14 gap-12">
                <div class="flex items-center gap-6">
                    <div class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-pastel-blue"></div>
                    <div>
                        <h3 class="text-2xl md:text-4xl font-semibold">John Doe</h3>
                        <p class="text-gray-500 text-xl">johndoe@email.com</p>
                    </div>
                </div>

                <div class="border-2 border-pastel-pink p-12 rounded-xl shadow-3xl shadow-[12px_12px_0_0_#FFD6EA] bg-white w-full mx-0 mt-0 flex flex-col gap-9">
                    <p class="flex flex-col gap-1">
                        <strong class="text-2xl md:text-3xl font-semibold">Contact Number:</strong><br>
                        <span class="text-gray-700 text-xl">09123456789</span>
                    </p>
                    <p class="flex flex-col gap-1">
                        <strong class="text-2xl md:text-3xl font-semibold">Birthdate:</strong><br>
                        <span class="text-gray-700 text-xl">Nov. 1, 2025</span>
                    </p>
                    <p class="flex flex-col gap-1">
                        <strong class="text-2xl md:text-3xl font-semibold">Address:</strong><br>
                        <span class="text-gray-700 text-">Phase 1 Package 1 Bagong Silang, Caloocan City</span>
                    </p>
                </div>
            </div>

            <div class="flex-1 h-full flex flex-col gap-48 md:mx-4 items-center">
                <div class="flex flex-col gap-5 w-96">
                    <h3 class="text-2xl md:text-3xl font-semibold mb-6">Notifications</h3>
                    <ul class="space-y-3 text-lg">
                        <li class="flex items-center justify-between">
                            <span class="truncate">Comments</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-100 ml-4">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-pastel-pink rounded-full peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full peer-checked:translate-x-5 transition-all"></div>
                            </label>
                        </li>

                        <li class="flex items-center justify-between">
                            <span class="truncate">Private comments on work</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-100 ml-4">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-12 h-7 bg-gray-200 rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full peer-checked:translate-x-5 transition-all"></div>
                            </label>
                        </li>

                        <li class="flex items-center justify-between">
                            <span class="truncate">Returned work from teachers</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-100 ml-4">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-12 h-7 bg-gray-200 rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full peer-checked:translate-x-5 transition-all"></div>
                            </label>
                        </li>

                        <li class="flex items-center justify-between">
                            <span class="truncate">Due-date reminders</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-100 ml-4">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-12 h-7 bg-gray-200 rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full peer-checked:translate-x-5 transition-all"></div>
                            </label>
                        </li>
                    </ul>
                </div>
                
                <div class="mt-8 flex flex-col gap-4 items-center">
                    <button class="bg-main text-white w-80 px-3 py-5 rounded-full text-lg">
                        Change Password
                    </button>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                        <button type="submit" id="logout-form-submit" class="hidden">Logout</button>
                    </form>

                    <button id="logout-open" type="button" class="bg-warning text-white w-80 px-3 py-5 rounded-full text-lg">
                        Log Out
                    </button>

                    <div id="logout-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center" aria-hidden="true" role="dialog" aria-modal="true">
                        <style>
                            @keyframes cg-fade-in { from { opacity: 0 } to { opacity: 1 } }
                            @keyframes cg-pop-in  { from { opacity: 0; transform: translateY(8px) scale(.98) } to { opacity: 1; transform: translateY(0) scale(1) } }

                            .cg-fade-in { animation: cg-fade-in 220ms cubic-bezier(.22,.9,.35,1) forwards; }
                            .cg-pop-in  { animation: cg-pop-in 260ms cubic-bezier(.22,.9,.35,1) forwards; }
                        </style>

                        <div class="absolute inset-0 bg-black/50 cg-fade-in"></div>

                        <div class="relative bg-white rounded-lg shadow-lg w-11/12 max-w-md mx-auto p-6 transform cg-pop-in">
                            <h3 class="text-xl font-semibold mb-4">Confirm Log Out</h3>
                            <p class="text-gray-700 mb-6">Are you sure you want to log out? You will be redirected to the landing page.</p>

                            <div class="flex justify-end gap-3">
                                <button id="logout-cancel" type="button" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700">Cancel</button>
                                <button id="logout-confirm" type="button" class="px-4 py-2 rounded-full bg-warning text-white">Log Out</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            var openBtn = document.getElementById('logout-open');
                            var modal = document.getElementById('logout-modal');
                            var cancelBtn = document.getElementById('logout-cancel');
                            var confirmBtn = document.getElementById('logout-confirm');
                            var logoutFormSubmit = document.getElementById('logout-form-submit');

                            function showModal() {
                                if (!modal) return;
                                modal.classList.remove('hidden');
                                modal.setAttribute('aria-hidden', 'false');
                                // trap focus on confirm button for a simple accessibility improvement
                                confirmBtn && confirmBtn.focus();
                            }

                            function hideModal() {
                                if (!modal) return;
                                modal.classList.add('hidden');
                                modal.setAttribute('aria-hidden', 'true');
                                openBtn && openBtn.focus();
                            }

                            openBtn && openBtn.addEventListener('click', function (e) {
                                e.preventDefault();
                                showModal();
                            });

                            cancelBtn && cancelBtn.addEventListener('click', function (e) {
                                e.preventDefault();
                                hideModal();
                            });

                            confirmBtn && confirmBtn.addEventListener('click', function (e) {
                                e.preventDefault();
                                // submit the hidden logout form which contains the CSRF token
                                logoutFormSubmit && logoutFormSubmit.click();
                            });

                            // close modal on ESC
                            document.addEventListener('keydown', function (e) {
                                if (e.key === 'Escape') {
                                    hideModal();
                                }
                            });
                        })();
                    </script>
                </div>
            </div>
        </div>
    </section>
</x-layouts.mainlayout>
