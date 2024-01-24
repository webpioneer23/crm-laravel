<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskBoard;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('task.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $_board_id = explode("-", $request->boardId);
        $board_id = $_board_id[1];
        $task = Task::create([
            'name' => $request->name,
            'board_id' => $board_id,
        ]);
        return $task;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task) {
            $task->delete();
            return response()->json(true);
        }
        return response()->json(false);
    }

    public function updateOrder(Request $request)
    {
        $taskIds = $request->taskIds;
        $diffBoard = $request->diffBoard;
        $boardId = $request->boardId;

        foreach ($taskIds as $key => $taskId) {
            $task = Task::find($taskId);
            if ($task) {
                if ($diffBoard) {
                    $task->update([
                        'priority' => $key + 1,
                        'board_id' => $boardId
                    ]);
                } else {
                    $task->update([
                        'priority' => $key + 1,
                    ]);
                }
            }
        }
        return response()->json(true);
    }
}
