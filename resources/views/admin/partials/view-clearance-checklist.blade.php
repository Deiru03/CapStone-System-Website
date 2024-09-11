<div class="p-6 bg-white rounded-lg shadow-md">
    <h4 class="text-lg font-medium text-gray-900">Document Name: {{ $checklist->document_name }}</h4>
    <p class="text-sm text-gray-600"><strong>Description:</strong> {{ $checklist->name }}</p> <!-- Bold label -->
    <p class="text-sm text-gray-600"><strong>Units:</strong> {{ $checklist->units }}</p> <!-- Bold label -->
    <p class="text-sm text-gray-600"><strong>Type:</strong> {{ $checklist->type }}</p> <!-- Bold label -->
    <p class="text-sm text-gray-600"><strong>Created At:</strong> {{ $checklist->created_at }}</p> <!-- Bold label -->
    <p class="text-sm text-gray-600"><strong>Updated At:</strong> {{ $checklist->updated_at }}</p> <!-- Bold label -->
    <!-- Add more fields as necessary -->
    <h3 class="text-lg font-medium text-gray-900 mt-6">Checklist Requirements</h3>
    <form action="{{ route('admin.update-clearance-checklist', $table) }}" method="POST">
        @csrf
        @foreach ($requirements as $index => $requirement)
        <div class="mt-4">
            <label for="requirement_name" class="block text-sm font-medium text-gray-700">Requirement No: {{ $index + 1 }}</label>
            <textarea name="requirement_name[]" 
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 
                focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 
                sm:text-sm rounded-md" required disabled>{{ $requirement->requirement_name }}</textarea>
        </div>
        @endforeach
    </form>
</div>