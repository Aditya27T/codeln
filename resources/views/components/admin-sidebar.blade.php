<aside class="w-64 h-screen bg-gray-900 text-white flex flex-col p-5 fixed top-0 left-0 overflow-y-auto z-30">
    <div class="mb-8 text-2xl font-bold">Admin Panel</div>
    <nav class="flex-1">
        <ul class="space-y-3">
            <li><a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.materials.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.materials.*') ? 'bg-gray-800' : '' }}">Materials</a></li>
            <li><a href="{{ route('admin.questions.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.questions.*') ? 'bg-gray-800' : '' }}">Questions</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">Users</a></li>
        </ul>
    </nav>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full mt-8 py-2 px-4 bg-red-600 hover:bg-red-700 rounded">Logout</button>
    </form>
</aside>
