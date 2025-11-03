<x-layouts.mainlayout title="Account Settings">
    <section class="p-10 font-poppins text-main bg-page min-h-screen">
        <h2 class="text-2xl font-semibold mb-8">Account Settings</h2>

        <div class="flex flex-col md:flex-row gap-16">
            {{-- LEFT: Profile Info --}}
            <div class="flex-1">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 rounded-full bg-pastel-blue"></div>
                    <div>
                        <h3 class="text-lg font-semibold">John Doe</h3>
                        <p class="text-gray-500">johndoe@email.com</p>
                    </div>
                </div>

                <div class="mt-10 border-2 border-pastel-pink p-6 rounded-xl w-[380px] shadow-pastel-pink bg-white">
                    <p class="mb-3">
                        <strong>Contact Number:</strong><br>
                        <span class="text-gray-700">09123456789</span>
                    </p>
                    <p class="mb-3">
                        <strong>Birthdate:</strong><br>
                        <span class="text-gray-700">Nov. 1, 2025</span>
                    </p>
                    <p>
                        <strong>Address:</strong><br>
                        <span class="text-gray-700">Phase 1 Package 1 Bagong Silang, Caloocan City</span>
                    </p>
                </div>
            </div>

            {{-- RIGHT: Notifications --}}
            <div class="flex-1">
                <h3 class="text-xl font-semibold mb-4">Notifications</h3>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between">
                        <span>Comments</span>
                        <input type="checkbox" checked class="accent-pastel-pink w-5 h-5">
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Private comments on work</span>
                        <input type="checkbox" checked class="accent-pastel-pink w-5 h-5">
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Returned work from teachers</span>
                        <input type="checkbox" checked class="accent-pastel-pink w-5 h-5">
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Due-date reminders</span>
                        <input type="checkbox" checked class="accent-pastel-pink w-5 h-5">
                    </li>
                </ul>

                <div class="mt-6 flex flex-col gap-3">
                    <button class="bg-main text-white px-5 py-2 rounded-lg">
                        Change Password
                    </button>
                    <button class="bg-warning text-white px-5 py-2 rounded-lg">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.mainlayout>
