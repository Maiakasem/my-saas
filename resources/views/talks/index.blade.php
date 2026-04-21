<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                My Talks
            </h2>

            <a href="{{ route('talks.create') }}"
                class="bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2.5 rounded-xl shadow hover:scale-105 hover:shadow-lg transition"
                style="color: rgb(50, 46, 173);">
                    + Add Talk
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4">

            @if($talks->isEmpty())
                <div class="bg-white rounded-2xl shadow p-10 text-center border border-gray-100">
                    <p class="text-gray-500 mb-4 text-lg">No talks yet 😢</p>
                    <a href="{{ route('talks.create') }}"
                       class="text-blue-600 font-semibold hover:underline">
                        Create your first talk
                    </a>
                </div>
            @else

                <div class="grid md:grid-cols-2 gap-6">

                    @foreach($talks as $talk)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 border border-gray-100">

                            <!-- Title + Type -->
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $talk->title }}
                                </h3>

                                <span class="text-xs px-3 py-1 rounded-full
                                    {{ $talk->type === 'keynote'
                                        ? 'bg-purple-100 text-purple-700'
                                        : ($talk->type === 'lighting'
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-blue-100 text-blue-700') }}">
                                    {{ $talk->type }}
                                </span>
                            </div>

                            <!-- Length -->
                            <p class="text-sm text-gray-500 mb-3">
                                ⏱ {{ $talk->length }}
                            </p>

                            <!-- Abstract -->
                            <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 mb-4">
                                {{ $talk->abstract }}
                            </p>

                            <!-- Actions -->
                            <div class="border-t pt-3 flex items-center justify-between">

                                <div class="flex gap-4 text-sm">
                                    <a href="{{ route('talks.show', $talk) }}"
                                       class="text-blue-600 hover:underline">
                                        View
                                    </a>

                                    <a href="{{ route('talks.edit', $talk) }}"
                                       class="text-indigo-600 hover:underline">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('talks.destroy', $talk) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-500 hover:text-red-700"
                                                onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>
    </div>
</x-app-layout>