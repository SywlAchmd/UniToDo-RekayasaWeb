<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index() {
        $data = Task::all();
        return Inertia::render('Task/Index', compact('data'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'status' => 'required',
            'course' => 'required',
        ]);

        Task::create($validatedData);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task) {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'status' => 'required',
            'course' => 'required',
        ]);

        $task->update($validatedData);

        // return redirect()->back()->with('success', 'Task updated successfully.');
        return redirect()->route('task.index');
    }

    public function destroy(Task $task) {
        $task->delete();

        // return redirect()->back()->with('success', 'Task deleted successfully.');
        return redirect()->route('task.index');
    }
}
