<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Lead;
use App\Models\Listing;
use App\Models\Task;
use App\Models\TaskActivity;
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

        TaskActivity::create([
            'task_id' => $task->id,
            'user_id' => auth()->user()->id,
            'note' => auth()->user()->name . " created the task."
        ]);
        return $task;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $activities = TaskActivity::where('task_id', $task->id)->with('user')->get()->toArray();
        return response()->json($activities);
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
            $old_name = $task->name;
            $task->name = $request->name;
            $task->save();
            if ($old_name != $task->name) {
                TaskActivity::create([
                    'task_id' => $task->id,
                    'user_id' => auth()->user()->id,
                    'note' => auth()->user()->name . " changed name from $old_name to $task->name."
                ]);
            }

            $property_list = ["users", "listings",  "appraisals",  "contacts",  "contracts"];

            $old_properties_query = TaskProperty::where('task_id', $task->id);
            $old_properties = $old_properties_query->get();
            $old_properties_query->delete();

            $old_data = [];
            foreach ($property_list as $property) {
                $old_data[$property] = [];
                foreach ($old_properties as $old_property) {
                    if ($old_property->type == $property) {
                        array_push($old_data[$property],  $old_property->property_id);
                    }
                }
            }

            $updated_properties = [];

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

                if ($list != $old_data[$property]) {
                    array_push($updated_properties, $property);
                }
            }
            TaskActivity::create([
                'task_id' => $task->id,
                'user_id' => auth()->user()->id,
                'note' => auth()->user()->name . " updated " . implode(",", $updated_properties) . "."
            ]);
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

        $board = TaskBoard::find($boardId);

        foreach ($taskIds as $key => $taskId) {
            $task = Task::find($taskId);
            if ($task) {
                if ($diffBoard) {
                    $old_board_id =  $task->board_id;
                    $old_board = TaskBoard::find($old_board_id);

                    $task->update([
                        'priority' => $key + 1,
                        'board_id' => $boardId
                    ]);

                    if ($old_board_id != $boardId) {
                        TaskActivity::create([
                            'task_id' => $task->id,
                            'user_id' => auth()->user()->id,
                            'note' => auth()->user()->name . " moved from $old_board->title to $board->title."
                        ]);
                    }
                } else {
                    $task->update([
                        'priority' => $key + 1,
                    ]);
                    TaskActivity::create([
                        'task_id' => $task->id,
                        'user_id' => auth()->user()->id,
                        'note' => auth()->user()->name . " changed task's priority."
                    ]);
                }
            }
        }

        return response()->json(true);
    }
}
