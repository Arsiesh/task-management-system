<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Create Task') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
                <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" name="title" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white">
                            <option value="todo">To-Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Priority</label>
                        <select name="priority" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Due Date</label>
                        <input type="date" name="due_date" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Attach File</label>
                        <input type="file" name="file" class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Create Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
