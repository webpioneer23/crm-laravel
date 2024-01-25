<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Lead;
use App\Models\Listing;
use App\Models\Task;
use App\Models\TaskBoard;
use App\Models\TaskProperty;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $listings = Listing::all();
        $appraisals = Appraisal::all();
        $contacts = Contact::all();
        $contracts = Contract::all();

        return view('task.list', compact(
            'users',
            'listings',
            'appraisals',
            'contacts',
            'contracts',
        ));
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
    public function update(Request $request, $id)
    {
        $task_id = $request->task_id;
        $task = Task::find($task_id);
        if ($task) {
            $task->name = $request->name;
            $task->save();

            TaskProperty::where('task_id', $task->id)->delete();

            $property_list = ["users", "listings",  "appraisals",  "contacts",  "contracts"];

            foreach ($property_list as $property) {
                $list = $request[$property];
                if ($list) {
                    foreach ($list as $item) {
                        TaskProperty::create([
                            'task_id' => $task->id,
                            'type' => $property,
                            'property_id' => $item,
                        ]);
                    }
                }
            }
        }
        return back();
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
