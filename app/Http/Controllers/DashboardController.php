<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
    
        $totalTasks = Task::where('user_id', $userId)->count();
        $completedTasks = Task::where('user_id', $userId)
                              ->where('status', 'done')
                              ->count();
        $tasks = Task::where('user_id', $userId)->withTrashed()->get();
    
        return view('dashboard', compact('totalTasks', 'completedTasks', 'tasks'));
    }
    
    

    
    
}


