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

        <!--Notification-->
        <div id="notification" class="fixed top-4 right-4 bg-green-100 text-green-700 p-6 rounded-lg shadow-lg hidden text-lg w-1/3">
            <span id="notification-message" class="block text-center"></span>
        </div>
       
                <h3 class="text-lg font-medium text-gray-900"></h3>
                <button onclick="openAddModal()" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add New Clearance Checklist</button>
                <div class="my-8"></div>
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-2">ID</th>
                            <th class="py-2">Document Name</th>
                            <th class="py-2">Description</th>
                            <th class="py-2">Units</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Created At</th>
                            <th class="py-2">Updated At</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200"> 
                        @foreach ($clearanceChecklists as $checklist)
                        <tr class="h-16">
                            <td class="border px-4 py-2">{{ $checklist->id }}</td>
                            <td class="border px-4 py-2 cursor-pointer" onclick="viewRequirements('{{ $checklist->table_name }}')">{{ $checklist->document_name }}</td>
                            <td class="border px-4 py-2 cursor-pointer" onclick="viewRequirements('{{ $checklist->table_name }}')">{{ $checklist->name }}</td>
                            <td class="border px-4 py-2">{{ $checklist->units }}</td>
                            <td class="border px-4 py-2">{{ $checklist->type }}</td>
                            <td class="border px-4 py-2">{{ $checklist->created_at }}</td>
                            <td class="border px-4 py-2">{{ $checklist->updated_at }}</td>
                            <td class="border px-4 py-2">
                                <button onclick="openEditModal('{{ $checklist->table_name }}')" class="text-blue-500">Edit</button><br>
                                <button onclick="confirmDelete('{{ $checklist->table_name }}')" class="text-red-500">Delete</button><br>
                                <!-- New Send button -->
                                <button onclick="openSendModal('{{ $checklist->table_name }}')" class="text-green-600">Send</button><br>
                                <button onclick="viewRequirements('{{ $checklist->table_name }}')" class="text-black-500">View</button><br>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        
   
    
    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;" onclick="closeModal(event, 'addModal')">
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-2xl relative" onclick="event.stopPropagation()">
            <button onclick="closeAddModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <span class="text-lg">✖</span> Close
            </button>
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
                    <input type="text" name="document_name" id="document_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" required oninput="checkLength(this)">
                    <div id="warning-message" class="text-red-500 text-sm hidden">Document name should not exceed 64 characters.</div>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                    <textarea name="name" id="name" rows="4" maxlength="255" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out resize-none" required></textarea>
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
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;" onclick="closeModal(event, 'editModal')">
        <div class="bg-white p-8 rounded-xl shadow-3xl modal-content w-11/12 max-w-4xl flex flex-col max-h-[100vh] relative" onclick="event.stopPropagation()">
            <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <span class="text-lg">✖</span> Close
            </button>
            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Clearance Checklist</h3>
            <!-- Name of the document or document name -->
            <h6 class="text-2xl font-bold mb-56text-gray-800"> Document Name: {{ $checklist->document_name }} </h6 >
            <form id="editForm" action="" method="POST" class="flex-grow overflow-y-auto">
                @csrf
                <div id="editChecklistContent" class="space-y-4">
                    <!-- Checklist content will be loaded here -->
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <button type="button" onclick="addRequirement()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">Add Requirement</button>
                    <div class="space-x-2">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-150 ease-in-out">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Send Modal -->
    <div id="sendModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;" onclick="closeModal(event, 'sendModal')">
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-2xl relative" onclick="event.stopPropagation()">
            <button onclick="closeSendModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <span class="text-lg">✖</span> Close
            </button>
            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Send Clearance Checklist</h3>
            <p class="mb-4">Are you sure you want to send this checklist to all faculty members?</p>
            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" onclick="closeSendModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-400">Cancel</button>
                <button id="confirmSendButton" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">Send</button>
            </div>
        </div>
    </div>

    <!-- View Requirements Modal -->
    <div id="viewRequirementsModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;" onclick="closeModal(event, 'viewRequirementsModal')">
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-10xl relative" onclick="event.stopPropagation()">
            <button onclick="closeViewRequirementsModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <span class="text-lg">✖</span> Close
            </button>
            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">View Requirements</h3>
            <div id="requirementsContent" class="space-y-4">
                <!-- Requirements content will be loaded here -->
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeViewRequirementsModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-400">Close</button>
            </div>
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

        function confirmDelete(tableName) {
            if (confirm('Are you sure you want to delete this clearance checklist? This action cannot be undone.')) {
                // If confirmed, submit the form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.delete-clearance-checklist', '') }}/" + tableName;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function openSendModal(table) {
            document.getElementById('sendModal').classList.remove('hidden');
            document.getElementById('confirmSendButton').onclick = function() {
                sendChecklistToFaculty(table);
            };
        }

        function viewRequirements(table) {
            fetch(`/admin/view-clearance-checklist/${table}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('requirementsContent').innerHTML = html;
                    document.getElementById('viewRequirementsModal').classList.remove('hidden');
                });
        }

        function closeViewRequirementsModal() {
            document.getElementById('viewRequirementsModal').classList.add('hidden');
        }

        function closeSendModal() {
            document.getElementById('sendModal').classList.add('hidden');
        }

        function sendChecklistToFaculty(table) {
            // Implement the logic to send the checklist to all faculty members
            fetch(`/admin/send-clearance-checklist/${table}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ table_name: table })
            })
            .then(response => {
                if (response.ok) {
                    alert('Checklist sent successfully!');
                    closeSendModal();
                } else {
                    alert('Failed to send checklist.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the checklist.');
            });
        }
    </script>
    <script>
        function checkLength(input) {
            const warningMessage = document.getElementById('warning-message');
            if (input.value.length > 64) {
                warningMessage.classList.remove('hidden');
            } else {
                warningMessage.classList.add('hidden');
            }
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
                }, 5000); // 5 seconds
            }
    
            if (error) {
                document.getElementById('notification-message').innerText = error;
                notification.classList.remove('hidden');
                notification.classList.remove('bg-green-100', 'text-green-700');
                notification.classList.add('bg-red-100', 'text-red-700');
                setTimeout(() => {
                    notification.classList.add('hidden');
                    notification.classList.remove('bg-red-100', 'text-red-700');
                    notification.classList.add('bg-green-100', 'text-green-700');
                }, 5000); // 5 seconds
            }
        });
    </script>
</x-admin-layout>