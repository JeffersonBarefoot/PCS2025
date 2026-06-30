<form action="{{ route('positions.update', $position->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="w-full mb-6 border-b pb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                    @if ($readonly == 'readonly')
                        {{ $position->descr }}
                    @else
                        <input type="text"
                               name="descr"
                               value="{{ $position->descr }}"
                               class="border rounded px-3 py-1 text-lg w-96"
                        >
                    @endif

                    <small class="text-gray-500 text-base">
                        {{ $position->company }} / {{ $position->posno }}
                    </small>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                {{-- Toggle Edit Mode --}}
                <a href="{{ route('positions.show', $position->id) }}?editmode=switch"
                   class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">
                    {{ Session::get('editModeButtonText') }}
                </a>

                {{-- Save Changes --}}
                <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                    Save Changes
                </button>

                {{-- Add New --}}
                <a href="{{ route('positions.create') }}"
                   class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">
                    Add New Position
                </a>

                {{-- Delete --}}
                <a href="{{ route('verifydestroy') }}?positiontodelete={{ $position->id }}"
                   class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                    Delete
                </a>
            </div>
        </div>
    </div>
</form>
