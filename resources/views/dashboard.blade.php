<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p>Welcome, {{ Auth::user()->name }}</p>
    </x-slot>


    <!-- Independent Test Sidebar lang naman-->
            {{-- Multiple Comment lang naman
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 bg-gray-800 text-white h-screen">
                    <div class="flex items-center p-4">
                        <img src="{{ asset('images/OMSCLogo.png') }}" alt="Logo" class="h-12 w-12 mr-2">
                        <span class="text-lg font-semibold">{{ Auth::user()->name }}</span>
                    </div>
                    <nav class="mt-6">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-700">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">Logout</button>
                        </form>
                    </nav>
                </div>
            </div> --}}

            {{-- <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium">Welcome to the Faculty Dashboard!</h3>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="py-12"> 
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <a href="{{ route('clearance') }}" class="inline-block mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">
                        <h3 class="text-lg font-medium">Checklist Requirements</h3>
                    </a>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">List of Documents</th>
                                <th class="border px-4 py-2">Compiled</th>
                                <th class="border px-4 py-2">Not Compiled</th>
                                <th class="border px-4 py-2">Not Applicable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">1. Soft and hard copies of OBE syllabus/syllabi of the subject/s handled as reflected in the teaching load/assignment</td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center"></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">2. Updated TORs and PDS</td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center"></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">3. Certificate of Employment and/or related professional experience for newly hired faculty.</td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center"></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">4. Copy of latest Employment Contract and/or notice of Renewal of Contract (for Part-Time Faculty)</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                                <td class="border px-4 py-2 text-center"></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">5. Hard copy of research presented (Completed or on-going)</td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center"></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">6. Copy of research journal where the paper was published</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                                <td class="border px-4 py-2 text-center"></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">7. Certificate of Recognition/Participation for research presented</td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center"></td>
                                <td class="border px-4 py-2 text-center">✔️</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg relative">
                        <h3 class="text-lg font-medium">Archived Files</h3>
                        <p class="text-2xl">0</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-8 top-1/2 transform -translate-y-1/2 h-10 w-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg relative">
                        <h3 class="text-lg font-medium">Shared Files</h3>
                        <p class="text-2xl">0</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-8 top-1/2 transform -translate-y-1/2 h-10 w-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                        </svg>
                    </div>
                    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg relative">
                        <h3 class="text-lg font-medium">Submitted Reports</h3>
                        <p class="text-2xl">4</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-8 top-1/2 transform -translate-y-1/2 h-10 w-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                </div>
            </div>

   

            <!-- Include My Files partial view -->
            <!--  include('faculty.partials.my-files')

            <!-- Include Shared Files partial view -->
            <!-- include('faculty.partials.shared-files') -->
        </div>
    </div>
</x-app-layout>
