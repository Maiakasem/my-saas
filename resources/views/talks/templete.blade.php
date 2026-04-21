
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Add Talk</h2>

            <form action="{{ route('talks.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Title -->
                <div>
                    <label class="block mb-1 font-medium">Title</label>
                    <input 
                        type="text" 
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                    >
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Length -->
                <div>
                    <label class="block mb-1 font-medium">Length</label>
                    <input 
                        type="text" 
                        name="length"
                        value="{{ old('length') }}"
                        placeholder="e.g. 30 min"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                    >
                    @error('length')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label class="block mb-1 font-medium">Type</label>
                    <select 
                        name="type"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                    >
                        <option value="">Select type</option>
                        @foreach(\App\Enums\TalkType::cases() as $type)
                            <option value="{{ $type->value }}" @selected(old('type') == $type->value)>{{ ucfirst($type->name) }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Abstract -->
                <div>
                    <label class="block mb-1 font-medium">Abstract</label>
                    <textarea 
                        name="abstract"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                    >{{ old('abstract') }}</textarea>
                    <p class="text-gray-600 text-sm mt-2">Describe the talk in a few sentences, in a way that's compelling and informative and could be presented to the public.</p>
                    @error('abstract')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organizer Notes -->
                <div>
                    <label class="block mb-1 font-medium">Organizer Notes</label>
                    <textarea 
                        name="organizer_notes"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                    >{{ old('organizer_notes') }}</textarea>
                    <p class="text-gray-600 text-sm mt-2">Write any notes you may want to pass to an event organizer about this talk.</p>
                    @error('organizer_notes')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div>
                    <button 
                        type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        Save Talk
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
