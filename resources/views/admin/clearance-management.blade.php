<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearance Management') }}
        </h2>
    </x-slot>

    <style>
        /* Set a maximum height for the modal content and enable overflow scrolling */
        .modal-content {
            max-height: 80vh; /* Adjust the height as needed */
            overflow-y: auto;
        }
    </style>
    <!-- resources\views\admin\clearance-management.blade.php -->
    <div class="py-12">
        <!--Notification-->
        <div id="notification" class="fixed top-4 right-4 bg-green-100 text-green-700 p-6 rounded-lg shadow-lg hidden text-lg w-1/3">
            <span id="notification-message" class="block text-center"></span>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Clearance Management</h3>
                <button onclick="openAddModal()" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add New Clearance Checklist</button>
                <table class="min-w-full bg-white mt-4">
                    <thead>
                        <tr>
                            <th class="py-2">ID</th>
                            <th class="py-2">Document Name</th>
                            <th class="py-2">Description</th>
                            <th class="py-2">Units</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clearanceChecklists as $checklist)
                        <tr>
                            <td class="border px-4 py-2">{{ $checklist->id }}</td>
                            <td class="border px-4 py-2">{{ $checklist->document_name }}</td>
                            <td class="border px-4 py-2">{{ $checklist->name }}</td>
                            <td class="border px-4 py-2">{{ $checklist->units }}</td>
                            <td class="border px-4 py-2">{{ $checklist->type }}</td>
                            <td class="border px-4 py-2">
                                <button onclick="openEditModal('{{ $checklist->table_name }}')" class="text-blue-500">Edit</button>
                                <form action="{{ route('admin.delete-clearance-checklist', $checklist->table_name) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;">
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-2xl">
            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Add New Clearance Checklist</h3>
            <form id="addForm" action="{{ route('admin.add-clearance-checklist') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type/Position:</label>
                    <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" required>
                        <option value="Permanent">Permanent</option>
                        <option value="Part-Timer">Part-Timer</option>
                        <option value="Temporary">Temporary</option>
                    </select>
                </div>
                <div>
                    <label for="document_name" class="block text-sm font-medium text-gray-700 mb-1">Document Name:</label>
                    <input type="text" name="document_name" id="document_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" required>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                    <textarea name="name" id="name" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out resize-none" required></textarea>
                </div>
                <div>
                    <label for="units" class="block text-sm font-medium text-gray-700 mb-1">Units:</label>
                    <input type="number" name="units" id="units" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" required>
                </div>
                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" onclick="closeAddModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-400">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">Create</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;">
        <div class="bg-white p-6 rounded-lg shadow-lg modal-content w-3/4 flex flex-col max-h-[80vh]">
            <h3 class="text-lg font-medium mb-4">Edit Clearance Checklist</h3>
            <form id="editForm" action="" method="POST">
                @csrf
                <div id="editChecklistContent" class="overflow-y-auto flex-grow">
                    <!-- Checklist content will be loaded here -->
                </div>
                <div class="mt-4 flex justify-between">
                    <button type="button" onclick="addRequirement()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add Requirement</button>
                    <div>
                        <button type="button" onclick="closeEditModal()" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
    
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }
    
        function openEditModal(table) {
            fetch(`/admin/edit-clearance-checklist/${table}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('editChecklistContent').innerHTML = html;
                    document.getElementById('editForm').action = `/admin/update-clearance-checklist/${table}`;
                    document.getElementById('editModal').classList.remove('hidden');
                });
        }
    
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    
        function addRequirement() {
            const requirementHtml = `
                <div class="mt-4 flex items-center">
                    <input type="text" name="requirement_name[]" class="flex-grow mr-2 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="Enter requirement name" required>
                    <button type="button" onclick="removeRequirement(this)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">Remove</button>
                </div>
            `;
            document.getElementById('editChecklistContent').insertAdjacentHTML('beforeend', requirementHtml);
        }
    
        function removeRequirement(button) {
            button.closest('.mt-4').remove();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            const message = "{{ session('message') }}";
            const error = "{{ session('error') }}";
    
            if (message) {
                document.getElementById('notification-message').innerText = message;
                notification.classList.remove('hidden');
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 3000); // Change to 5000 for 5 seconds
            }
    
            if (error) {
                document.getElementById('notification-message').innerText = error;
                notification.classList.remove('hidden');
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 3000); // Change to 5000 for 5 seconds
            }
        });
    </script>
</x-admin-layout>