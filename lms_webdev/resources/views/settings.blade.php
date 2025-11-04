<x-layouts.mainlayout title="Account Settings">
    <section class="min-h-screen w-full font-poppins text-main bg-page flex flex-col">
        <h2 class="text-3xl md:text-4xl font-semibold p-8">Account Settings</h2>

        <div class="flex flex-col md:flex-row gap-16 items-stretch flex-1 p-8">
            <div class="flex-1 flex flex-col gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-pastel-blue"></div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-semibold">John Doe</h3>
                        <p class="text-gray-500 text-lg">johndoe@email.com</p>
                    </div>
                </div>

                <div class="mt-10 border-2 border-pastel-pink p-14 rounded-xl shadow-pastel-pink bg-white w-full flex flex-col gap-9">
                    <p class="mb-4 text-xl">
                        <strong>Contact Number:</strong><br>
                        <span class="text-gray-700 text-lg">09123456789</span>
                    </p>
                    <p class="mb-4 text-xl">
                        <strong>Birthdate:</strong><br>
                        <span class="text-gray-700 text-lg">Nov. 1, 2025</span>
                    </p>
                    <p class="text-xl">
                        <strong>Address:</strong><br>
                        <span class="text-gray-700 text-lg">Phase 1 Package 1 Bagong Silang, Caloocan City</span>
                    </p>
                </div>
            </div>

            <div class="flex-1 h-full flex flex-col gap-36 md:ml-12 md:mr-12">
                <div class="flex flex-col gap-5">
                    <h3 class="text-2xl md:text-3xl font-semibold mb-6">Notifications</h3>
                    <ul class="space-y-4 text-lg">
                        <li class="flex items-center justify-between">
                            <span>Comments</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-110">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-pastel-pink rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full peer-checked:translate-x-6 transition-all"></div>
                            </label>
                        </li>

                        <li class="flex items-center justify-between">
                            <span>Private comments on work</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-110">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-14 h-8 bg-gray-200 rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full peer-checked:translate-x-6 transition-all"></div>
                            </label>
                        </li>

                        <li class="flex items-center justify-between">
                            <span>Returned work from teachers</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-110">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-14 h-8 bg-gray-200 rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full peer-checked:translate-x-6 transition-all"></div>
                            </label>
                        </li>

                        <li class="flex items-center justify-between">
                            <span>Due-date reminders</span>
                            <label class="relative inline-flex items-center cursor-pointer transform scale-110">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-14 h-8 bg-gray-200 rounded-full peer peer-checked:bg-pastel-pink transition-all"></div>
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full peer-checked:translate-x-6 transition-all"></div>
                            </label>
                        </li>
                    </ul>
                </div>
                
                <div class="mt-8 flex flex-col gap-4">
                    <button class="bg-main text-white px-4 py-5 rounded-xl text-lg">
                        Change Password
                    </button>
                    <button class="bg-warning text-white px-4 py-5 rounded-xl text-lg">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.mainlayout>
