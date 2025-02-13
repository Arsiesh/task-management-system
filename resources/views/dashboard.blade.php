<x-app-layout>
    {{-- Flash Messages --}}
    @if (session('error'))
        <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            

      

            <div class="flex justify-end mb-6">
                <a href="{{ route('tasks.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Create Task
                </a>
                <a href="{{ route('tasks.filter') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Filter Tasks
            </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

<div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Tasks Created</h3>
    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $totalTasks }}</p>
</div>


<div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Tasks Assigned to You</h3>
    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $totalTasks }}</p>
</div>

<div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Completed Tasks</h3>
    <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $completedTasks }}</p>
</div>
</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                

                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Active Tasks</h3>
                    
                    @if ($tasks->whereNull('deleted_at')->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No active tasks.</p>
                    @else
                        <ul>
                            @foreach ($tasks as $task)
                                <li class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-4 rounded mb-2 shadow">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $task->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ ucfirst($task->status) }} | Due: {{ $task->due_date }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $task->description }}</p>

                                        @if ($task->file_path)
                                            <p class="text-sm text-blue-500 dark:text-blue-400 mt-1">
                                                <a href="{{ asset('storage/' . $task->file_path) }}" target="_blank">
                                                    View Uploaded File
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">

                                        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 rounded text-sm">
                                            Edit
                                        </a>


                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded text-sm"
                                                onclick="return confirm('Are you sure you want to archive this task?')">
                                                Archive
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>


                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Archived Tasks</h3>
                    
                    @php
                        $archivedTasks = $tasks->whereNotNull('deleted_at');
                    @endphp

                    @if ($archivedTasks->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No archived tasks.</p>
                    @else
                        <ul>
                            @foreach ($archivedTasks as $task)
                                <li class="flex justify-between items-center bg-gray-200 dark:bg-gray-600 p-4 rounded mb-2 shadow">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $task->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Archived</p>
                                    </div>

                                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded text-sm">
                                            Restore
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
