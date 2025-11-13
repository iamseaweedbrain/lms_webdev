<x-layouts.mainlayout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAF8F5] px-6">
        <div class="w-full max-w-4xl">
            <form action="{{ route('assignments.store', ['code' => $class->code]) }}" method="POST" enctype="multipart/form-data" class="bg-white border-2 border-black shadow-[8px_8px_0_0_#000] rounded-2xl overflow-hidden">
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
                        <h2 class="text-2xl font-bold mb-6">Create an assignment</h2>

                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                            <input type="datetime-local" id="due_date" name="due_date" required
                                   value="{{ old('due_date') }}"
                                   min="{{ date('Y-m-d\TH:i') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black cursor-pointer" />
                            @error('due_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Assignment Title</label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black" />
                            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">Assignment Instructions</label>
                            <textarea id="instructions" name="instructions" rows="8"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">{{ old('instructions') }}</textarea>
                            @error('instructions') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="assignment_file" class="block text-sm font-medium text-gray-700 mb-2">Attach File or Link (Optional)</label>
                            <input id="assignment_file" name="assignment_file" type="file"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.zip" />
                            <p class="text-xs text-gray-500 mt-1">Or paste a link below instead of uploading a file</p>
                            <input id="assignment_link" name="assignment_link" type="url" value="{{ old('assignment_link') }}"
                                   placeholder="https://example.com/resource"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black mt-2" />
                            @error('assignment_file') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            @error('assignment_link') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.mainlayout>
