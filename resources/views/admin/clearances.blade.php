<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clearances') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-2xl font-bold">Clearance Management</h2>
                <p>Here you can manage clearances.</p>
            </div>
            <a href="{{ route('admin.clearance-management') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Manage Clearance Checklists
            </a>
        </div>
        
    
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('admin.clearances') }}" class="mb-4 flex items-center">
            <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}" class="border rounded p-2 mr-2">
            <select name="sort" class="border rounded p-2 mr-2 w-40">
                <option value="" disabled selected>Sort by Name</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A to Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z to A</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
        </form>
    
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Program</th>
                    <th class="py-2">Clearance Status</th>
                    <th class="py-2">Checked By</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clearances as $clearance)
                <tr>
                    <td class="border px-4 py-2">{{ $clearance->id }}</td>
                    <td class="border px-4 py-2">{{ $clearance->user->name }}</td>
                    <td class="border px-4 py-2">{{ $clearance->user->email }}</td>
                    <td class="border px-4 py-2">{{ $clearance->user->program }}</td>
                    <td class="border px-4 py-2">{{ $clearance->status }}</td>
                    <td class="border px-4 py-2">{{ $clearance->checked_by }}</td>
                    <td class="border px-4 py-2">
                        <button onclick="openModal({{ $clearance->id }})" class="text-blue-500">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-medium">Edit Clearance</h3>
            <form id="editForm" method="post" action="{{ route('admin.update-clearance') }}">
                @csrf
                <input type="hidden" name="id" id="editId">
                <div class="mt-4">
                    <label for="editStatus" class="block">Clearance Status</label>
                    <select name="status" id="editStatus" class="border rounded w-full" required>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="editCheckedBy" class="block">Checked By</label>
                    <input type="text" name="checked_by" id="editCheckedBy" class="border rounded w-full" required>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeModal()" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openModal(id) {
            // Fetch clearance data and populate the modal fields
            const clearance = @json($clearances).find(clearance => clearance.id === id);
            document.getElementById('editId').value = clearance.id;
            document.getElementById('editStatus').value = clearance.status;
            document.getElementById('editCheckedBy').value = clearance.checked_by;
            document.getElementById('editModal').classList.remove('hidden');
        }
    
        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>