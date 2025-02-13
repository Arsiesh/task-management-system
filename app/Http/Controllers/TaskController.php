<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());
    
        if ($request->has('status') && in_array($request->status, ['todo', 'in-progress', 'done'])) {
            $query->where('status', $request->status);
        }
    
        $tasks = $query->orderBy('due_date', 'asc')->paginate(5);
    
        return view('tasks.index', compact('tasks'));
    }
    

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in-progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|max:2048'
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('uploads', 'public') : null;

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in-progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|max:2048'
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            if ($task->file_path) {
                Storage::disk('public')->delete($task->file_path);
            }
            $data['file_path'] = $request->file('file')->store('uploads', 'public');
        }

        $task->update($data);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if ($task->status !== 'done') {
            return redirect()->back()->with('error', 'Only completed tasks can be archived.');
        }
    
        $task->delete(); // Soft delete the task
        return redirect()->back()->with('success', 'Task archived successfully.');
    }
    

    public function restore($id)
    {
        $task = Task::onlyTrashed()->where('user_id', Auth::id())->find($id);
    
        if (!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }
    
        $task->restore();
        return redirect()->route('dashboard')->with('success', 'Task restored successfully.');
    }
    public function archived()
    {
        $tasks = Task::onlyTrashed()->where('user_id', Auth::id())->paginate(5);
        return view('tasks.archived', compact('tasks'));
    }

    public function filter(Request $request)
    {
        $query = Task::where('user_id', Auth::id());
    
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
    
        $tasks = $query->paginate(5); // Ensure pagination
    
        return view('tasks.filter', compact('tasks'));
    }


}
