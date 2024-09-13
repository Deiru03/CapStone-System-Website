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

        /* Sticky header styles */
        .sticky-header {
        position: sticky;
        top: 0;
        background-color: rgb(228, 250, 255); /* Background color to cover content below */
        z-index: 10; /* Ensure it stays above other content */
        }

        /* Ensure the table has a defined height */
        .table-container {
            max-height: 400px; /* Adjust as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }
           /* Add sticky header styles for the modal */
        .modal-header {
            position: sticky;
            top: 0;
            background-color: white; /* Adjust as needed */
            z-index: 20; /* Ensure it stays above other content */
        }
    </style>
    <!-- resources\views\admin\clearance-management.blade.php -->

        <!--Notification-->
        <div id="notification" class="fixed top-4 right-4 bg-green-100 text-green-700 p-6 rounded-lg shadow-lg hidden text-lg w-1/3">
            <span id="notification-message" class="block text-center"></span>
        </div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-bold text-gray-900 border-b-2 border-blue-500 pb-2 inline-block">Faculty Checklist</h3>
            <button onclick="openAddModal()" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
                Add New Clearance Checklist
            </button>
        </div>
            
        <div class="table-container overflow-x-auto" style="max-height: 490px;">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="sticky-header">
                        <th class="py-3">ID</th>
                        <th class="py-3">Document Name</th>
                        <th class="py-3">Description</th>
                        <th class="py-3">Units</th>
                        <th class="py-3">Type</th>
                        <th class="py-3">Created At</th>
                        <th class="py-3">Updated At</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200"> 
                    @foreach ($clearanceChecklists as $checklist)
                    <tr class="h-20">
                        <td class="border px-4 py-2 text-sm">{{ $checklist->id }}</td>
                        <td class="border px-4 py-2 text-sm cursor-pointer" onclick="viewRequirements('{{ $checklist->table_name }}')">{{ $checklist->document_name }}</td>
                        <td class="border px-4 py-2 text-sm cursor-pointer" onclick="viewRequirements('{{ $checklist->table_name }}')">{{ $checklist->name }}</td>
                        <td class="border px-4 py-2 text-sm">{{ $checklist->units }}</td>
                        <td class="border px-4 py-2 text-sm">{{ $checklist->type }}</td>
                        <td class="border px-4 py-2 text-sm">{{ $checklist->created_at }}</td>
                        <td class="border px-4 py-2 text-sm">{{ $checklist->updated_at }}</td>
                        <td class="border px-4 py-2">
                            <button onclick="openEditModal('{{ $checklist->table_name }}')" class="text-blue-500 flex items-center text-sm mr-2">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </button>
                            <button onclick="confirmDelete('{{ $checklist->table_name }}')" class="text-red-500 flex items-center text-sm mr-2">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Delete
                            </button>
                            <button onclick="openSendModal('{{ $checklist->table_name }}')" class="text-green-600 flex items-center text-sm mr-2">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Send
                            </button>
                            <button onclick="viewRequirements('{{ $checklist->table_name }}')" class="text-black-500 flex items-center text-sm">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden backdrop-blur-sm animate-fadeIn" style="z-index: 1050;" onclick="closeModal(event, 'addModal')">
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-2xl relative animate-scaleIn" onclick="event.stopPropagation()">
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
                    <input type="text" name="document_name" id="document_name" placeholder="Enter document name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out" required oninput="checkLength(this)">
                    <div id="warning-message" class="text-red-500 text-sm hidden">Document name should not exceed 64 characters.</div>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                    <textarea name="name" id="name" rows="4" maxlength="255" placeholder="Enter description or what is this checklist for" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out resize-none" required></textarea>
                </div>
                <div>
                    <label for="units" class="block text-sm font-medium text-gray-700 mb-1">Units:</label>
                    <input type="number" name="units" id="units" placeholder="Enter units or leave it blank, if not applicable" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out">
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
        <div class="bg-white p-8 rounded-xl shadow-3xl modal-content w-11/12 max-w-6xl flex flex-col max-h-[100vh] relative" onclick="event.stopPropagation()">
            <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <span class="text-lg">✖</span> Close
            </button>
            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Clearance Checklist</h3>
            <!-- Name of the document or document name -->
            <h6 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">
            <!--    <strong>Document Description:</strong> { $checklist ? $checklist->name : 'No checklist available' }} -->
            </h6>
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
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-4xl relative" onclick="event.stopPropagation()">
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
        <div class="bg-white p-8 rounded-xl shadow-2xl modal-content w-11/12 max-w-8xl relative" onclick="event.stopPropagation()">
            <div class="modal-header sticky top-0 bg-white z-30 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">View Requirements</h3>
                <button onclick="closeViewRequirementsModal()" class="text-gray-500 hover:text-gray-700">
                    <span class="text-lg">✖</span> Close
                </button>
            </div>
            <hr class="border-t border-gray-300 my-4">
            <div id="requirementsContent" class="space-y-4 overflow-y-auto max-h-[50vh]">
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