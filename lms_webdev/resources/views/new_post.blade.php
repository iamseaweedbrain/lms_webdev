<x-layouts.mainlayout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAF8F5] px-6">
        <div class="w-full max-w-4xl">
            <form action="{{ route('posts.store', ['code' => $class->code]) }}" method="POST" enctype="multipart/form-data" class="bg-white border-2 border-black shadow-[8px_8px_0_0_#000] rounded-2xl overflow-hidden">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="relative bg-white p-6 flex flex-col justify-between items-center">
                        <img src="{{ asset('images/cat-mascot.png') }}" alt="cat-mascot" class="w-80 h-auto object-contain drop-shadow-lg pl-4">
                        <div class="mt-auto mb-6 flex gap-3">
                            <button type="submit" class="px-8 py-2 bg-black text-white rounded-md font-semibold hover:bg-gray-800 transition">Create</button>
                            <a href="{{ route('classes.show', ['code' => $class->code]) }}" class="px-8 py-2 border-2 border-black text-black rounded-md font-semibold hover:bg-gray-100 transition">Cancel</a>
                        </div>
                    </div>

                    <div class="p-8">
                        <h2 class="text-2xl font-bold mb-6">Create a post</h2>
                        @if(session('error'))
                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="post_type" class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                            <select id="post_type" name="post_type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                                    onchange="toggleMaterialFileUpload()">
                                <option value="material" {{ old('post_type') == 'material' ? 'selected' : '' }}>Material</option>
                                <option value="announcement" {{ old('post_type') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                            </select>
                            @error('post_type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title</label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black" />
                            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Post Description</label>
                            <textarea id="description" name="description" rows="4" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">{{ old('description') }}</textarea>
                            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4" id="material-file-section" style="display: none;">
                            <label for="material_file" class="block text-sm font-medium text-gray-700 mb-2">Attach File or Link (Optional)</label>
                            <input id="material_file" name="material_file" type="file"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.zip" />
                            <p class="text-xs text-gray-500 mt-1">Or paste a link below instead of uploading a file</p>
                            <input id="material_link" name="material_link" type="url" value="{{ old('material_link') }}"
                                   placeholder="https://example.com/resource"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black mt-2" />
                            @error('material_file') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            @error('material_link') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        @php
                            $selectedColor = old('color', '');
                            $colorMap = [
                                'pink' => '#FFB7C5',
                                'blue' => '#A7C7E7',
                                'purple' => '#C3B1E1',
                                'yellow' => '#FBE7A1',
                            ];
                            $selectedHex = $selectedColor ? ($colorMap[$selectedColor] ?? '#E5E7EB') : '#E5E7EB';
                        @endphp
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Post Color (Optional)</label>

                            <div class="flex items-center gap-3">
                                <button type="button" id="color-picker-open" class="flex items-center gap-3 px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                                    <span class="text-sm">Choose color</span>
                                    <span id="color-preview" class="w-6 h-6 rounded-full border" data-color-hex="{{ $selectedHex }}"></span>
                                </button>
                                <input type="hidden" id="color-input" name="color" value="{{ $selectedColor }}">
                            </div>
                            @error('color') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                            <div id="color-picker-modal" class="fixed inset-0 z-50 hidden items-center justify-center" aria-hidden="true">

                                <div class="absolute inset-0 bg-black/50 cg-fade-in" id="color-modal-backdrop"></div>

                                <div class="relative bg-white rounded-lg shadow-lg w-11/12 max-w-sm mx-4 p-6 cg-pop-in">
                                    <h3 class="text-lg font-semibold mb-6">Pick a post color</h3>

                                    <div class="grid grid-cols-5 gap-6 mb-6 w-max mx-auto justify-items-center">
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform border-2 border-gray-300" data-color="" style="background:#E5E7EB" title="Default"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="pink" style="background:#FFB7C5"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="blue" style="background:#A7C7E7"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="purple" style="background:#C3B1E1"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="yellow" style="background:#FBE7A1"></button>
                                    </div>

                                    <div class="flex justify-end gap-4">
                                        <button id="color-picker-cancel" type="button" class="px-3 py-2 rounded-full border border-gray-300 hover:bg-gray-50 transition">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes cg-fade-in { from { opacity: 0 } to { opacity: 1 } }
        @keyframes cg-pop-in  { from { opacity: 0; transform: translateY(8px) scale(.98) } to { opacity: 1; transform: translateY(0) scale(1) } }
        .cg-fade-in { animation: cg-fade-in 220ms cubic-bezier(.22,.9,.35,1) forwards; }
        .cg-pop-in  { animation: cg-pop-in 260ms cubic-bezier(.22,.9,.35,1) forwards; }
    </style>

    <script>
        function toggleMaterialFileUpload() {
            var postType = document.getElementById('post_type').value;
            var fileSection = document.getElementById('material-file-section');
            if (postType === 'material') {
                fileSection.style.display = 'block';
            } else {
                fileSection.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleMaterialFileUpload();
        });

        (function(){
            var modal = document.getElementById('color-picker-modal');
            var openBtn = document.getElementById('color-picker-open');
            var cancelBtn = document.getElementById('color-picker-cancel');
            var backdrop = document.getElementById('color-modal-backdrop');
            var options = document.querySelectorAll('.color-option');
            var input = document.getElementById('color-input');
            var preview = document.getElementById('color-preview');

            if(preview && preview.dataset.colorHex){
                preview.style.backgroundColor = preview.dataset.colorHex;
            }

            function showModal(){ if(!modal) return; modal.classList.remove('hidden'); modal.classList.add('flex'); modal.setAttribute('aria-hidden','false'); }
            function hideModal(){ if(!modal) return; modal.classList.add('hidden'); modal.classList.remove('flex'); modal.setAttribute('aria-hidden','true'); }

            if(openBtn) openBtn.addEventListener('click', function(){ showModal(); });
            if(cancelBtn) cancelBtn.addEventListener('click', function(){ hideModal(); });
            if(backdrop) backdrop.addEventListener('click', function(){ hideModal(); });

            options.forEach(function(btn){
                btn.addEventListener('click', function(){
                    var c = btn.getAttribute('data-color');
                    var bg = btn.style.background || btn.style.backgroundColor;
                    if(input) input.value = c;
                    if(preview && bg) preview.style.backgroundColor = bg;
                    hideModal();
                });
                btn.addEventListener('mouseenter', function(){ btn.classList.add('scale-110'); });
                btn.addEventListener('mouseleave', function(){ btn.classList.remove('scale-110'); });
            });

            document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ hideModal(); } });
        })();
    </script>
</x-layouts.mainlayout>