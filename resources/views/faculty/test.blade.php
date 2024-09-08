<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test Page') }}
        </h2>
    </x-slot>

   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Checklist Sent by Admin -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Checklist Sent by Admin</h3>
                <table class="min-w-full bg-white mt-4">
                    <thead>
                        <tr>
                            <th class="py-2">List of Documents</th>
                            <th class="py-2">Upload File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checklistRequirements as $requirement)
                        <tr>
                            <td class="border px-4 py-2">{{ $requirement->name }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('faculty.upload-file', $requirement->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" required>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Upload</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>