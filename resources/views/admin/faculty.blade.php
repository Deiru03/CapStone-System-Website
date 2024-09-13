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
            <input type="text" name="search" placeholder="Search by name, email, program, units, or position..." value="{{ request('search') }}" class="border rounded p-2 mr-2 w-1/2">
            <select name="sort" class="border rounded p-2 mr-2 w-40">
                <option value="" disabled selected>Sort name</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A to Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z to A</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Apply</button>
        </form>

        
        <!-- Users Table -->
         <!-- Users Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->program }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->units }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->position }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openModal({{ $user->id }})" class="text-blue-600 hover:text-blue-900">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Faculty
            </h3>
            <form id="editForm" method="post" action="{{ route('admin.update-user') }}">
                @csrf
                <input type="hidden" name="id" id="editId">
                <div class="space-y-4">
                    <div>
                        <label for="editName" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="editName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="editEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="editEmail" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="editProgram" class="block text-sm font-medium text-gray-700">Program</label>
                        <input type="text" name="program" id="editProgram" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="editUnits" class="block text-sm font-medium text-gray-700">Units</label>
                        <input type="number" name="units" id="editUnits" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="editStatus" class="block text-sm font-medium text-gray-700">Status/Position</label>
                        <select name="position" id="editStatus" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            // Fetch user data and populate the modal fields
            const users = @json($users);
            const user = users.find(user => user.id === id);
            if (user) {
                document.getElementById('editId').value = user.id;
                document.getElementById('editName').value = user.name;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editProgram').value = user.program;
                document.getElementById('editStatus').value = user.position;
                document.getElementById('editUnits').value = user.units;
                document.getElementById('editModal').classList.remove('hidden');
            } else {
                console.error('User not found');
            }
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>