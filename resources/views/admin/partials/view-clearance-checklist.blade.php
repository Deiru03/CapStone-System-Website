<div>
    <h4 class="text-lg font-medium text-gray-900">Document Name: {{ $checklist->document_name }}</h4>
    <p class="text-sm text-gray-600">Description: {{ $checklist->name }}</p>
    <p class="text-sm text-gray-600">Units: {{ $checklist->units }}</p>
    <p class="text-sm text-gray-600">Type: {{ $checklist->type }}</p>
    <p class="text-sm text-gray-600">Created At: {{ $checklist->created_at }}</p>
    <p class="text-sm text-gray-600">Updated At: {{ $checklist->updated_at }}</p>
    <!-- Add more fields as necessary -->
    <h3 class="text-lg font-medium text-gray-900">Checklist Requirements</h3>
    <form action="{{ route('admin.update-clearance-checklist', $table) }}" method="POST">
        @csrf
        @foreach ($requirements as $requirement)
        <div class="mt-4">
            <label for="requirement_name" class="block text-sm font-medium text-gray-700">Requirement Name:</label>
            <input type="text" name="requirement_name[]" value="{{ $requirement->requirement_name }}" 
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 
                focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 
                sm:text-sm rounded-md" required>
        </div>
        @endforeach
        <!--<button type="button" onclick="addRequirement()" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add Requirement</button>
        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save</button>
        </div>-->
    </form>
</div>