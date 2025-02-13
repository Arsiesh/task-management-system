<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Filter Tasks') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('tasks.filter') }}" class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Status Filter --}}
                    <div>
                        <label for="status" class="block text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="w-full mt-1 p-2 border rounded">
                            <option value="todo">To Do</option>
                            <option value="in-progress">In-Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-full">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>

            {{-- Filtered Tasks List --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filtered Tasks</h3>
                
                @if ($tasks->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No tasks found.</p>
                @else
                    <ul>
                        @foreach ($tasks as $task)
                            <li class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-4 rounded mb-2 shadow">
                                <div>
                                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $task->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($task->status) }}
                                    </p>
                                </div>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 rounded text-sm">
                                    Edit
                                </a>
                            </li>
                        @endforeach
                        <div class="mt-4">
    {{ $tasks->appends(request()->query())->links() }}
</div>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
