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
<<!-- resources\views\admin\clearance-management.blade.php -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Add New Clearance Checklist Button -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <button onclick="openAddModal()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add New Clearance Checklist</button>
            </div>

            <!-- Sorting and Filtering Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="GET" action="{{ route('admin.clearance-management') }}">
                    <div class="flex items-center space-x-4">
                        <input type="text" name="search" placeholder="Search by name or email" class="border rounded w-full px-4 py-2" value="{{ request('search') }}">
                        <select name="sort_by" class="border rounded px-4 py-2">
                            <option value="">Sort by</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="program" {{ request('sort_by') == 'program' ? 'selected' : '' }}>Program</option>
                        </select>
                        <select name="direction" class="border rounded px-4 py-2">
                            <option value="">Direction</option>
                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>A to Z</option>
                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Z to A</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
                    </div>
                </form>
            </div>

            <!-- Display Message -->
            @if ($message)
                <div class="p-4 sm:p-8 bg-red-100 text-red-700 shadow sm:rounded-lg">
                    {{ $message }}
                </div>
            @endif

            <!-- Existing Clearance Checklists -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Existing Clearance Checklists</h3>
                <table class="min-w-full bg-white mt-4">
                    <thead>
                        <tr>
                            <th class="py-2">ID</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Program</th>
                            <th class="py-2">Clearance Status</th>
                            <th class="py-2">Checked By</th>
                            <th class="py-2">Checklist Sent</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requirements as $requirement)
                        <tr>
                            <td class="border px-4 py-2">{{ $requirement->id }}</td>
                            <td class="border px-4 py-2">{{ $requirement->name }}</td>
                            <td class="border px-4 py-2">{{ $requirement->email }}</td>
                            <td class="border px-4 py-2">{{ $requirement->program }}</td>
                            <td class="border px-4 py-2">{{ $requirement->clearance_status }}</td>
                            <td class="border px-4 py-2">{{ $requirement->checked_by }}</td>
                            <td class="border px-4 py-2">{{ $requirement->checklist_sent ? 'Yes' : 'No' }}</td>
                            <td class="border px-4 py-2">
                                <button onclick="openEditModal({{ $requirement->id }}, '{{ $requirement->type }}', '{{ $requirement->name }}')" class="text-blue-500">Edit</button>
                                <button onclick="sendChecklist({{ $requirement->id }})" class="text-green-500">Send Checklist</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 modal-content">
            <h3 class="text-lg font-medium">Clearance Checklist Requirements</h3>
            <div id="checklistContent" class="mt-4">
                <!-- Checklist content will be loaded here -->
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeViewModal()" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 modal-content">
            <h3 class="text-lg font-medium">Edit Clearance Checklist</h3>
            <form id="editForm" action="{{ route('admin.update-clearance-checklist') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="editId">
                <div class="mt-4">
                    <label for="editType">Type:</label>
                    <select name="type" id="editType" required>
                        <option value="Permanent">Permanent</option>
                        <option value="Part-Timer">Part-Timer</option>
                        <option value="Temporary">Temporary</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="editName">Name:</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div class="mt-4">
                    <h4 class="text-lg font-medium">Checklist Requirements</h4>
                    <div id="editChecklistContent" class="mt-4">
                        <!-- Checklist content will be loaded here -->
                    </div>
                    <button type="button" onclick="addRequirementRow()" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add Requirement</button>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeEditModal()" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden" style="z-index: 1050;">
    <div class="bg-white p-6 rounded-lg shadow-lg modal-content">
        <h3 class="text-lg font-medium">Add New Clearance Checklist</h3>
        <form id="addForm" action="{{ route('admin.add-clearance-checklist') }}" method="POST">
            @csrf
            <div class="mt-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type:</label>
                <select name="type" id="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    <option value="Permanent">Permanent</option>
                    <option value="Part-Timer">Part-Timer</option>
                    <option value="Temporary">Temporary</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Document Name:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="units" class="block text-sm font-medium text-gray-700">Units:</label>
                <input type="number" name="units" id="units" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeAddModal()" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Create</button>
            </div>
        </form>
    </div>
</div>

    <script>
        function openViewModal(id) {
            // Fetch the checklist requirements via AJAX
            fetch(`/admin/clearance-checklist/${id}`)
                .then(response => response.json())
                .then(data => {
                    let content = '<table class="min-w-full bg-white mt-4"><thead><tr><th class="py-2">File</th><th class="py-2">List of Documents</th><th class="py-2">Complied</th><th class="py-2">Not Complied</th><th class="py-2">Not Applicable</th></tr></thead><tbody>';
                    data.requirements.forEach(requirement => {
                        content += `<tr><td class="border px-4 py-2"><i class="fas fa-file-alt"></i></td><td class="border px-4 py-2">${requirement.name}</td><td class="border px-4 py-2"><input type="checkbox"></td><td class="border px-4 py-2"><input type="checkbox"></td><td class="border px-4 py-2"><input type="checkbox"></td></tr>`;
                    });
                    content += '</tbody></table>';
                    document.getElementById('checklistContent').innerHTML = content;
                    document.getElementById('viewModal').classList.remove('hidden');
                });
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function openEditModal(id, type, name) {
            document.getElementById('editId').value = id;
            document.getElementById('editType').value = type;
            document.getElementById('editName').value = name;

            // Fetch the checklist requirements via AJAX
            fetch(`/admin/clearance-checklist/${id}`)
                .then(response => response.json())
                .then(data => {
                    let content = '<table class="min-w-full bg-white mt-4"><thead><tr><th class="py-2">File</th><th class="py-2">List of Documents</th><th class="py-2">Complied</th><th class="py-2">Not Complied</th><th class="py-2">Not Applicable</th></tr></thead><tbody>';
                    data.requirements.forEach(requirement => {
                        content += `<tr><td class="border px-4 py-2"><i class="fas fa-file-alt"></i></td><td class="border px-4 py-2"><input type="text" name="requirement_name[]" value="${requirement.name}" class="w-full"></td><td class="border px-4 py-2"><input type="checkbox" name="complied[]" ${requirement.complied ? 'checked' : ''}></td><td class="border px-4 py-2"><input type="checkbox" name="not_complied[]" ${requirement.not_complied ? 'checked' : ''}></td><td class="border px-4 py-2"><input type="checkbox" name="not_applicable[]" ${requirement.not_applicable ? 'checked' : ''}></td></tr>`;
                    });
                    content += '</tbody></table>';
                    document.getElementById('editChecklistContent').innerHTML = content;
                    document.getElementById('editModal').classList.remove('hidden');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function addRequirementRow() {
            let content = `<tr><td class="border px-4 py-2"><i class="fas fa-file-alt"></i></td><td class="border px-4 py-2"><input type="text" name="requirement_name[]" class="w-full"></td><td class="border px-4 py-2"><input type="checkbox" name="complied[]"></td><td class="border px-4 py-2"><input type="checkbox" name="not_complied[]"></td><td class="border px-4 py-2"><input type="checkbox" name="not_applicable[]"></td></tr>`;
            document.querySelector('#editChecklistContent tbody').insertAdjacentHTML('beforeend', content);
        }
    </script>

    <script>
        function sendChecklist(id) {
            fetch(`/admin/send-checklist/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to send checklist.');
                }
            });
        }
    </script>   
</x-admin-layout>