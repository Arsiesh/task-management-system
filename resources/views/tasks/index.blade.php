@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h2 class="text-2xl font-semibold mb-4">Task List</h2>

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6">
        <div class="flex space-x-4">
            <select name="status" class="p-2 border rounded">
                <option value="">All Status</option>
                <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>To-Do</option>
                <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
        </div>
    </form>
    
    <div class="bg-white shadow rounded p-4">
        @if ($tasks->isEmpty())
            <p class="text-gray-500">No tasks found.</p>
        @else
            <ul>
                @foreach ($tasks as $task)
                    <li class="p-4 border-b flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                            <p class="text-sm text-gray-500">Status: {{ ucfirst($task->status) }} | Due: {{ $task->due_date }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
