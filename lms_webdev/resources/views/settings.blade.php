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
                    <button class="bg-warning text-white w-80 px-3 py-5 rounded-full text-lg">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.mainlayout>
