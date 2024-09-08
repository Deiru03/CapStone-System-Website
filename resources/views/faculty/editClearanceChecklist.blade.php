<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Clearance Checklistasdasdasdsad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Checklist Requirements</h3>
                <form action="{{ route('admin.update-clearance-checklist', $table) }}" method="POST">
                    @csrf
                    @foreach ($requirements as $requirement)
                    <div class="mt-4">
                        <label for="requirement_name" class="block text-sm font-medium text-gray-700">Requirement Name:</label>
                        <input type="text" name="requirement_name[]" value="{{ $requirement->requirement_name }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    </div>
                    @endforeach
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>