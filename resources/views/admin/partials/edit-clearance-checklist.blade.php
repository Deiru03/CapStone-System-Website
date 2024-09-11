    <h6 class="text-lg font-medium text-gray-900">Checklist Requirements</h6>
    <form action="{{ route('admin.update-clearance-checklist', $table) }}" method="POST">
        @csrf
        @foreach ($requirements as $requirement)
        <div class="mt-4">
            <label for="requirement_name" class="block text-sm font-medium text-gray-700">Requirement Name:</label>
            <input type="text" name="requirement_name[]" value="{{ $requirement->requirement_name }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
            <button type="button" onclick="removeRequirement(this)" class="mt-2 bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
        </div>
        
        @endforeach
        <div class="mt-4">
            <input type="hidden" id="updated_at" name="updated_at" value="{{ now()->format('Y-m-d H:i:s') }}">
            <small class="text-gray-500">Last Updated: {{ now()->format('Y-m-d H:i:s') }}</small>
        </div>
    </form>