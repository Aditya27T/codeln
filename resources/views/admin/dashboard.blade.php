@extends('layouts.admin')

@section('content')
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
                        <div class="bg-blue-100 p-6 rounded shadow">
                            <div class="text-lg font-bold text-blue-800">Total Students</div>
                            <div class="text-3xl">{{ $totalStudents }}</div>
                        </div>
                        <div class="bg-green-100 p-6 rounded shadow">
                            <div class="text-lg font-bold text-green-800">Total Questions</div>
                            <div class="text-3xl">{{ $totalQuestions }}</div>
                        </div>
                        <div class="bg-yellow-100 p-6 rounded shadow">
                            <div class="text-lg font-bold text-yellow-800">Total Materials</div>
                            <div class="text-3xl">{{ $totalMaterials }}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                        <div class="bg-white p-6 rounded shadow">
                            <canvas id="statsBarChart" height="100"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded shadow">
                            <canvas id="statsPieChart" height="100"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded shadow">
                            <canvas id="statsLineChart" height="100"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-6 mt-8 rounded shadow">
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
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart
    const barCtx = document.getElementById('statsBarChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Students', 'Questions', 'Materials'],
            datasets: [{
                label: 'Statistics',
                data: [{{ $totalStudents }}, {{ $totalQuestions }}, {{ $totalMaterials }}],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(253, 224, 71, 0.7)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(253, 224, 71, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Dashboard Statistics (Bar)' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('statsPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Students', 'Questions', 'Materials'],
            datasets: [{
                data: [{{ $totalStudents }}, {{ $totalQuestions }}, {{ $totalMaterials }}],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(253, 224, 71, 0.7)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(253, 224, 71, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Dashboard Statistics (Pie)' }
            }
        }
    });

    // Line Chart (dummy growth data)
    const lineCtx = document.getElementById('statsLineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Students',
                    data: [{{ $totalStudents - 3 }}, {{ $totalStudents - 2 }}, {{ $totalStudents - 1 }}, {{ $totalStudents - 1 }}, {{ $totalStudents }}, {{ $totalStudents }}],
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4
                },
                {
                    label: 'Questions',
                    data: [{{ $totalQuestions - 2 }}, {{ $totalQuestions - 1 }}, {{ $totalQuestions - 1 }}, {{ $totalQuestions }}, {{ $totalQuestions }}, {{ $totalQuestions }}],
                    borderColor: 'rgba(34, 197, 94, 1)',
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    tension: 0.4
                },
                {
                    label: 'Materials',
                    data: [{{ $totalMaterials - 1 }}, {{ $totalMaterials - 1 }}, {{ $totalMaterials }}, {{ $totalMaterials }}, {{ $totalMaterials }}, {{ $totalMaterials }}],
                    borderColor: 'rgba(253, 224, 71, 1)',
                    backgroundColor: 'rgba(253, 224, 71, 0.2)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Growth Over Time (Line)' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection