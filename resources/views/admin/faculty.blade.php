<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculty Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Faculty Management</h2>
        <p>Here you can manage Faculty members.</p>

        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('admin.faculty') }}" class="mb-4 flex items-center">
            <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}" class="border rounded p-2 mr-2">
            <select name="sort" class="border rounded p-2 mr-2 w-40">
                <option value="">Sort by Name</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A to Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z to A</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
        </form>

        
        <!-- Users Table -->
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Program</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->id }}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ $user->program }}</td>
                    <td class="border px-4 py-2">{{ $user->status }}</td>
                    <td class="border px-4 py-2">
                        <button onclick="openModal({{ $user->id }})" class="text-blue-500">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-medium">Edit Faculty</h3>
            <form id="editForm" method="post" action="{{ route('admin.update-user') }}">
                @csrf
                <input type="hidden" name="id" id="editId">
                <div class="mt-4">
                    <label for="editName" class="block">Name</label>
                    <input type="text" name="name" id="editName" class="border rounded w-full" required>
                </div>
                <div class="mt-4">
                    <label for="editEmail" class="block">Email</label>
                    <input type="email" name="email" id="editEmail" class="border rounded w-full" required>
                </div>
                <div class="mt-4">
                    <label for="editProgram" class="block">Program</label>
                    <input type="text" name="program" id="editProgram" class="border rounded w-full" required>
                </div>
                <div class="mt-4">
                    <label for="editStatus" class="block">Status</label>
                    <select name="status" id="editStatus" class="border rounded w-full" required>
                        <option value="Permanent">Permanent</option>
                        <option value="Part Timer">Part Timer</option>
                        <option value="Temporary">Temporary</option>
                    </select>
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
            // Fetch user data and populate the modal fields
            const user = @json($users).find(user => user.id === id);
            document.getElementById('editId').value = user.id;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editProgram').value = user.program;
            document.getElementById('editStatus').value = user.status;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>