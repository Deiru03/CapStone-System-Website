
    <h3 class="text-lg font-medium text-gray-900">Checklist Requirements</h3>
    <form action="{{ route('admin.update-clearance-checklist', $table) }}" method="POST">
        @csrf
        @foreach ($requirements as $requirement)
        <div class="mt-4">
            <label for="requirement_name" class="block text-sm font-medium text-gray-700">Requirement Name:</label>
            <input type="text" name="requirement_name[]" value="{{ $requirement->requirement_name }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
            <button type="button" onclick="removeRequirement(this)" class="mt-2 bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
        </div>
        @endforeach
        <!--<button type="button" onclick="addRequirement()" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add Requirement</button>
        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save</button>
        </div>-->
    </form>