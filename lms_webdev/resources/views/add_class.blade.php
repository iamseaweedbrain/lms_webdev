<x-layouts.mainlayout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAF8F5] px-6">
        <div class="w-full max-w-4xl">
            <form action="{{ route('classes.store') }}" method="POST" class="bg-white border-2 border-black shadow-[8px_8px_0_0_#000] rounded-2xl overflow-hidden">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="relative bg-white p-6 flex flex-col justify-between items-center">
                        <img src="{{ asset('images/cat-mascot.png') }}" alt="cat-mascot" class="w-80 h-auto object-contain drop-shadow-lg pl-4">
                        <div class="mt-auto mb-6 flex gap-3">
                            <button type="submit" class="px-8 py-2 bg-black text-white rounded-md font-semibold">Create</button>
                            <a href="{{ route('classes') }}" class="px-8 py-2 border-2 border-black text-black rounded-md font-semibold">Cancel</a>
                        </div>
                    </div>

                    <div class="p-8">
                        <h2 class="text-2xl font-bold mb-6">Create a class</h2>

                        <div class="mb-4">
                            <label for="class_name" class="block text-sm font-medium text-gray-700 mb-2">Class Name</label>
                            <input id="class_name" name="class_name" type="text" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black" />
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Class Description</label>
                            <textarea id="description" name="description" rows="6"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"></textarea>
                        </div>

                        @php
                            $selectedColor = old('color', 'pink');
                            $colorMap = [
                                'pink' => '#FFB7C5',
                                'blue' => '#A7C7E7',
                                'purple' => '#C3B1E1',
                                'yellow' => '#FBE7A1',
                            ];
                            $selectedHex = $colorMap[$selectedColor] ?? '#FFB7C5';
                        @endphp
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Accent Color</label>

                            <div class="flex items-center gap-3">
                                <button type="button" id="color-picker-open" class="flex items-center gap-3 px-3 py-2 border border-gray-300 rounded-md">
                                    <span class="text-sm">Choose color</span>
                                    <span id="color-preview" class="w-6 h-6 rounded-full border" data-color-hex="{{ $selectedHex }}"></span>
                                </button>
                                <input type="hidden" id="color-input" name="color" value="{{ $selectedColor }}">
                            </div>

                            <div id="color-picker-modal" class="fixed inset-0 z-50 hidden items-center justify-center" aria-hidden="true">
                                <style>
                                    @keyframes cg-fade-in { from { opacity: 0 } to { opacity: 1 } }
                                    @keyframes cg-pop-in  { from { opacity: 0; transform: translateY(8px) scale(.98) } to { opacity: 1; transform: translateY(0) scale(1) } }
                                    .cg-fade-in { animation: cg-fade-in 220ms cubic-bezier(.22,.9,.35,1) forwards; }
                                    .cg-pop-in  { animation: cg-pop-in 260ms cubic-bezier(.22,.9,.35,1) forwards; }
                                </style>

                                <div class="absolute inset-0 bg-black/50 cg-fade-in"></div>

                                <div class="relative bg-white rounded-lg shadow-lg w-11/12 max-w-sm mx-4 p-6 cg-pop-in">
                                    <h3 class="text-lg font-semibold mb-6">Pick an accent color</h3>

                                    <div class="grid grid-cols-4 gap-6 mb-6 w-max mx-auto justify-items-center">
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="pink" style="background:#FFB7C5"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="blue" style="background:#A7C7E7"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="purple" style="background:#C3B1E1"></button>
                                        <button type="button" class="color-option w-10 h-10 rounded-full transition-transform" data-color="yellow" style="background:#FBE7A1"></button>
                                    </div>

                                    <div class="flex justify-end gap-4">
                                        <button id="color-picker-cancel" type="button" class="px-3 py-2 rounded-full border border-gray-300">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function(){
            var modal = document.getElementById('color-picker-modal');
            var openBtn = document.getElementById('color-picker-open');
            var cancelBtn = document.getElementById('color-picker-cancel');
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