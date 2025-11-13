<x-layouts.mainlayout title="Account Settings">
    <section class="min-h-screen w-full font-poppins text-main bg-page flex flex-col mt-8">
        <h2 class="text-3xl md:text-4xl font-semibold p-8">Account Settings</h2>

        <div class="flex flex-col md:flex-row items-stretch gap-16 flex-1 p-9">
            <div class="flex-1 flex flex-col md:mx-14 gap-12">
                <form action="{{ route('settings-update') }}" method="POST" enctype="multipart/form-data" class="border-2 border-pastel-pink p-10 md:p-12 rounded-xl shadow-3xl shadow-[12px_12px_0_0_#FFD6EA] bg-white w-full mx-0 mt-0 flex flex-col gap-6 relative max-w-3xl items-center">
                    @csrf
                    <div class="flex items-center gap-6">
                        <div class="w-36 h-36 md:w-40 md:h-40 rounded-full overflow-hidden relative group cursor-pointer">
                            <img id="avatar-preview" src="{{ asset(optional(auth()->user())->avatar ?? 'images/default-avatar.png') }}" alt="Profile Picture" class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                <button id="avatar-edit-btn" type="button" class="p-2 rounded-full shadow-sm text-white" aria-label="Edit avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><mask id="SVGxtBLacqF" width="17" height="17" x="3" y="4" fill="#000" maskUnits="userSpaceOnUse"><path fill="#fff" d="M3 4h17v17H3z"/><path d="m13.586 7.414l-7.194 7.194c-.195.195-.292.292-.36.41c-.066.119-.1.252-.166.52l-.664 2.654c-.09.36-.135.541-.035.641s.28.055.641-.035l2.655-.664c.267-.066.4-.1.518-.167c.119-.067.216-.164.41-.359l7.195-7.194c.667-.666 1-1 1-1.414s-.333-.748-1-1.414l-.172-.172c-.667-.666-1-1-1.414-1s-.748.334-1.414 1"/></mask><g fill="none"><path stroke="#ffffff" stroke-width="3" d="m13.586 7.414l-7.194 7.194c-.195.195-.292.292-.36.41c-.066.119-.1.252-.166.52l-.664 2.654c-.09.36-.135.541-.035.641s.28.055.641-.035l2.655-.664c.267-.066.4-.1.518-.167c.119-.067.216-.164.41-.359l7.195-7.194c.667-.666 1-1 1-1.414s-.333-.748-1-1.414l-.172-.172c-.667-.666-1-1-1.414-1s-.748.334-1.414 1Z" mask="url(#SVGxtBLacqF)"/><path fill="#ffffff" d="m12.5 7.5l3-2l3 3l-2 3z"/></g></svg>
                                </button>
                            </div>
                            <input id="avatar-input" name="avatar_file" type="file" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" title="Click to change avatar" style="display:none;">
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 flex-1 pt-2">
                        <div class="flex flex-col md:flex-row gap-2">
                            <div class="flex-1 flex flex-col gap-2">
                                <strong class="text-lg md:text-lg font-semibold">First Name:</strong>
                                <input id="firstname" name="firstname" value="{{ old('firstname', optional(auth()->user())->firstname) }}" placeholder="First name" class="w-full px-3 py-4 border rounded-lg" />
                            </div>
                            <div class="flex-1 flex flex-col gap-2">
                                <strong class="text-lg md:text-lg font-semibold">Last Name:</strong>
                                <input id="lastname" name="lastname" value="{{ old('lastname', optional(auth()->user())->lastname) }}" placeholder="Last name" class="w-full px-3 py-4 border rounded-lg" />
                            </div>
                        </div>
                        <div class="mt-2 w-full">
                            <label class="flex flex-col gap-1">
                                <strong class="text-lg md:text-xl font-semibold">Email:</strong>
                                <input name="email" value="{{ old('email', optional(auth()->user())->email) }}" class="mt-2 px-3 py-4 border rounded-lg w-full" />
                            </label>
                        </div>
                    </div>

                    <input type="hidden" id="avatar-selected" name="avatar" value="{{ old('avatar', optional(auth()->user())->avatar) }}">
       
                    <div class="mt-4 flex justify-end">
                        <div class="flex gap-3">
                            <button type="submit" class="px-7 py-3 rounded-full bg-main text-white">Save</button>
                        </div>
                    </div>

                    <div id="avatar-picker-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center" aria-hidden="true">
                        <style>
                            @keyframes cg-fade-in { from { opacity: 0 } to { opacity: 1 } }
                            @keyframes cg-pop-in  { from { opacity: 0; transform: translateY(8px) scale(.98) } to { opacity: 1; transform: translateY(0) scale(1) } }
                            .cg-fade-in { animation: cg-fade-in 220ms cubic-bezier(.22,.9,.35,1) forwards; }
                            .cg-pop-in  { animation: cg-pop-in 260ms cubic-bezier(.22,.9,.35,1) forwards; }
                        </style>
                        <div class="absolute inset-0 bg-black/50 cg-fade-in"></div>
                        <div class="relative bg-white rounded-lg shadow-lg w-11/12 max-w-lg mx-4 p-6 cg-pop-in">
                            <h3 class="text-lg font-semibold mb-4">Choose an avatar</h3>
                            <div class="grid grid-cols-3 gap-4 mb-4">

                                <button type="button" class="avatar-option p-1 rounded" data-path="avatars/active-cat.jpg"><img src="{{ asset('avatars/active-cat.jpg') }}" class="w-full h-full object-cover rounded" alt=""></button>
                                <button type="button" class="avatar-option p-1 rounded" data-path="avatars/angel-cat.jpg"><img src="{{ asset('avatars/angel-cat.jpg') }}" class="w-full h-full object-cover rounded" alt=""></button>
                                <button type="button" class="avatar-option p-1 rounded" data-path="avatars/curious-cat.jpg"><img src="{{ asset('avatars/curious-cat.jpg') }}" class="w-full h-full object-cover rounded" alt=""></button>
                                <button type="button" class="avatar-option p-1 rounded" data-path="avatars/genius-cat.jpg"><img src="{{ asset('avatars/genius-cat.jpg') }}" class="w-full h-full object-cover rounded" alt=""></button>
                                <button type="button" class="avatar-option p-1 rounded" data-path="avatars/nonchalant-cat.jpg"><img src="{{ asset('avatars/nonchalant-cat.jpg') }}" class="w-full h-full object-cover rounded" alt=""></button>
                                <button type="button" class="avatar-option p-1 rounded" data-path="avatars/relaxed-cat.jpg"><img src="{{ asset('avatars/relaxed-cat.jpg') }}" class="w-full h-full object-cover rounded" alt=""></button>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button id="avatar-picker-cancel" type="button" class="px-3 py-2 rounded-full border border-gray-300">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function(){
                            var assetBase = "{{ asset('') }}";
                            var defaultAvatarUrl = "{{ asset('images/default-avatar.png') }}";
                            var avatarPreview = document.getElementById('avatar-preview');
                            var avatarInputHidden = document.getElementById('avatar-selected');
                            var avatarPickerModal = document.getElementById('avatar-picker-modal');
                            var avatarPickerCancel = document.getElementById('avatar-picker-cancel');
                            var avatarEditBtn = document.getElementById('avatar-edit-btn');
                            var avatarOptions = document.querySelectorAll('.avatar-option');
                            var avatarInput = document.getElementById('avatar-input');

                            if (avatarInput) avatarInput.style.display = 'none';

                            function openPicker(){ if(avatarPickerModal){ avatarPickerModal.classList.remove('hidden'); avatarPickerModal.setAttribute('aria-hidden','false'); }}
                            function closePicker(){ if(avatarPickerModal){ avatarPickerModal.classList.add('hidden'); avatarPickerModal.setAttribute('aria-hidden','true'); }}

                            avatarPreview && avatarPreview.addEventListener('click', function(){ openPicker(); });
                            avatarEditBtn && avatarEditBtn.addEventListener('click', function(e){ e.stopPropagation(); openPicker(); });

                            avatarOptions.forEach(function(btn){ btn.addEventListener('click', function(){ var path = btn.getAttribute('data-path'); if(path){ avatarPreview.src = assetBase + path; avatarInputHidden.value = path; } closePicker(); }); });

                            avatarPickerCancel && avatarPickerCancel.addEventListener('click', function(){ closePicker(); });

                            var clearBtn = document.getElementById('clear-profile');
                            if(clearBtn){
                                var original = {
                                    firstname: document.getElementById('firstname').value || '',
                                    lastname: document.getElementById('lastname').value || '',
                                    email: document.querySelector('input[name="email"]').value || '',
                                    avatar: avatarInputHidden.value || ''
                                };
                                clearBtn.addEventListener('click', function(){
                                    document.getElementById('firstname').value = original.firstname;
                                    document.getElementById('lastname').value = original.lastname;
                                    document.querySelector('input[name="email"]').value = original.email;
                                    avatarPreview.src = original.avatar ? (assetBase + original.avatar) : defaultAvatarUrl;
                                    avatarInputHidden.value = original.avatar;
                                });
                            }
                        })();
                    </script>
                </form>
            </div>

            <div class="flex-1 h-full flex flex-col gap-36 md:mx-4 items-center">
                <div class="flex flex-col gap-5 w-96">
                    <h3 class="text-2xl md:text-3xl font-semibold mb-6">Notifications</h3>
                    <ul class="space-y-6 text-lg">
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
                    <button id="change-password-open" class="bg-main text-white w-80 px-3 py-5 rounded-full text-lg" type="button">
                        Change Password
                    </button>

                    <div id="change-password-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center" aria-hidden="true" role="dialog" aria-modal="true">
                        <div class="absolute inset-0 bg-black/50 cg-fade-in"></div>
                        <div class="relative bg-white rounded-lg shadow-lg w-11/12 max-w-lg mx-auto p-6 transform cg-pop-in">
                            <h3 class="text-xl font-semibold mb-4">Change Password</h3>

                            <form id="change-password-form" method="POST" action="{{ route('change-password') }}">
                                @csrf
                                <div class="flex flex-col gap-4">
                                    <label class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-700">Current Password</span>
                                        <div class="relative mt-2">
                                            <input id="current_password" name="current_password" type="password" class="w-full px-3 py-2 pr-10 border rounded" required>
                                            <button type="button" data-target="current_password" class="show-password absolute right-3 text-gray-500 hover:text-gray-700 flex items-center" style="top: 50%; transform: translateY(-50%);" aria-label="Toggle password visibility">
                                                <iconify-icon icon="mdi:eye" width="20" height="20" class="eye-icon"></iconify-icon>
                                                <iconify-icon icon="mdi:eye-off" width="20" height="20" class="eye-off-icon hidden"></iconify-icon>
                                            </button>
                                        </div>
                                    </label>

                                    <label class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-700">New Password</span>
                                        <div class="relative mt-2">
                                            <input id="new_password" name="new_password" type="password" class="w-full px-3 py-2 pr-10 border rounded" required minlength="8">
                                            <button type="button" data-target="new_password" class="show-password absolute right-3 text-gray-500 hover:text-gray-700 flex items-center" style="top: 50%; transform: translateY(-50%);" aria-label="Toggle password visibility">
                                                <iconify-icon icon="mdi:eye" width="20" height="20" class="eye-icon"></iconify-icon>
                                                <iconify-icon icon="mdi:eye-off" width="20" height="20" class="eye-off-icon hidden"></iconify-icon>
                                            </button>
                                        </div>
                                    </label>

                                    <label class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-700">Confirm New Password</span>
                                        <div class="relative mt-2">
                                            <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="w-full px-3 py-2 pr-10 border rounded" required minlength="8">
                                            <button type="button" data-target="new_password_confirmation" class="show-password absolute right-3 text-gray-500 hover:text-gray-700 flex items-center" style="top: 50%; transform: translateY(-50%);" aria-label="Toggle password visibility">
                                                <iconify-icon icon="mdi:eye" width="20" height="20" class="eye-icon"></iconify-icon>
                                                <iconify-icon icon="mdi:eye-off" width="20" height="20" class="eye-off-icon hidden"></iconify-icon>
                                            </button>
                                        </div>
                                    </label>
                                </div>

                                <div class="mt-6 flex justify-end gap-3">
                                    <button id="change-password-cancel" type="button" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700">Cancel</button>
                                    <button id="change-password-confirm" type="button" class="px-4 py-2 rounded-full bg-main text-white">Confirm</button>
                                </div>

                                <button type="submit" id="change-password-submit" class="hidden">Submit</button>
                            </form>
                        </div>
                    </div>

                    <div id="change-password-confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center" aria-hidden="true" role="dialog" aria-modal="true">
                        <div class="absolute inset-0 bg-black/50 cg-fade-in"></div>
                        <div class="relative bg-white rounded-lg shadow-lg w-11/12 max-w-md mx-auto p-6 transform cg-pop-in">
                            <h3 class="text-lg font-semibold mb-2">Confirm password change</h3>
                            <p class="text-gray-700 mb-4">Are you sure you want to change your password?</p>
                            <div class="flex justify-end gap-3">
                                <button id="change-password-confirm-cancel" type="button" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700">Cancel</button>
                                <button id="change-password-confirm-ok" type="button" class="px-4 py-2 rounded-full bg-main text-white">Yes, change</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            var openBtn = document.getElementById('change-password-open');
                            var modal = document.getElementById('change-password-modal');
                            var cancelBtn = document.getElementById('change-password-cancel');
                            var confirmBtn = document.getElementById('change-password-confirm');
                            var submitBtn = document.getElementById('change-password-submit');

                            var confirmModal = document.getElementById('change-password-confirm-modal');
                            var confirmModalCancel = document.getElementById('change-password-confirm-cancel');
                            var confirmModalOk = document.getElementById('change-password-confirm-ok');

                            function showModal() { modal && modal.classList.remove('hidden'); modal && modal.setAttribute('aria-hidden', 'false'); }
                            function hideModal() { modal && modal.classList.add('hidden'); modal && modal.setAttribute('aria-hidden', 'true'); }

                            function showConfirmModal() { confirmModal && confirmModal.classList.remove('hidden'); confirmModal && confirmModal.setAttribute('aria-hidden','false'); }
                            function hideConfirmModal() { confirmModal && confirmModal.classList.add('hidden'); confirmModal && confirmModal.setAttribute('aria-hidden','true'); }

                            openBtn && openBtn.addEventListener('click', function (e) { e.preventDefault(); showModal(); });
                            cancelBtn && cancelBtn.addEventListener('click', function (e) { e.preventDefault(); hideModal(); });

                            confirmBtn && confirmBtn.addEventListener('click', function (e) {
                                e.preventDefault();
                                var newPass = document.getElementById('new_password').value;
                                var newPassConf = document.getElementById('new_password_confirmation').value;
                                var curr = document.getElementById('current_password').value;

                                if (!curr || !newPass) {
                                    alert('Please fill all password fields.');
                                    return;
                                }
                                if (newPass.length < 8) {
                                    alert('New password must be at least 8 characters.');
                                    return;
                                }
                                if (newPass !== newPassConf) {
                                    alert('New password and confirmation do not match.');
                                    return;
                                }
                                showConfirmModal();
                            });

                            confirmModalCancel && confirmModalCancel.addEventListener('click', function (e) { e.preventDefault(); hideConfirmModal(); });
                            confirmModalOk && confirmModalOk.addEventListener('click', function (e) { e.preventDefault(); hideConfirmModal(); hideModal(); submitBtn && submitBtn.click(); });

                            var toggles = document.querySelectorAll('.show-password');
                            toggles.forEach(function (btn) {
                                btn.addEventListener('click', function () {
                                    var targetId = btn.getAttribute('data-target');
                                    var input = document.getElementById(targetId);
                                    if (!input) return;

                                    var eyeIcon = btn.querySelector('.eye-icon');
                                    var eyeOffIcon = btn.querySelector('.eye-off-icon');

                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        eyeIcon.classList.add('hidden');
                                        eyeOffIcon.classList.remove('hidden');
                                    } else {
                                        input.type = 'password';
                                        eyeIcon.classList.remove('hidden');
                                        eyeOffIcon.classList.add('hidden');
                                    }
                                });
                            });

                            document.addEventListener('keydown', function (e) {
                                if (e.key === 'Escape') {
                                    hideModal(); hideConfirmModal();
                                }
                            });
                        })();
                    </script>
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
                                logoutFormSubmit && logoutFormSubmit.click();
                            });

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
