<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Platform Statistics</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="text-3xl font-bold text-blue-800">{{ $totalStudents }}</div>
                            <div class="text-gray-600 mt-1">Total Students</div>
                        </div>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="text-3xl font-bold text-green-800">{{ $totalQuestions }}</div>
                            <div class="text-gray-600 mt-1">Coding Challenges</div>
                        </div>
                        
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                            <div class="text-3xl font-bold text-purple-800">{{ $totalMaterials }}</div>
                            <div class="text-gray-600 mt-1">Learning Materials</div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-medium mb-4">Administration</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="{{ route('admin.materials.index') }}" class="block p-6 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <h3 class="text-lg font-medium mb-2">Manage Materials</h3>
                            <p>Add, edit, or remove learning materials</p>
                        </a>
                        
                        <a href="{{ route('admin.questions.index') }}" class="block p-6 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <h3 class="text-lg font-medium mb-2">Manage Challenges</h3>
                            <p>Add, edit, or remove coding challenges</p>
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="block p-6 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <h3 class="text-lg font-medium mb-2">Manage Users</h3>
                            <p>View and manage user accounts</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>