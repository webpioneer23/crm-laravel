<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskBoard;
use App\Models\TaskProperty;
use Illuminate\Http\Request;

class TaskBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = TaskBoard::orderBy('priority')->get();;
        foreach ($boards as $key => $board) {
            $result = [];
            $tasks = Task::where('board_id', $board->id)->orderBy('priority')->get();
            foreach ($tasks as $key => $task) {
                $properties = TaskProperty::where('task_id', $task->id)->get();
                $users = [];
                $listings = [];
                $appraisals = [];
                $contacts = [];
                $contracts = [];
                foreach ($properties as $property) {
                    if ($property->type == 'users') {
                        array_push($users, $property->property_id);
                    }
                    if ($property->type == 'listings') {
                        array_push($listings, $property->property_id);
                    }
                    if ($property->type == 'appraisals') {
                        array_push($appraisals, $property->property_id);
                    }
                    if ($property->type == 'contacts') {
                        array_push($contacts, $property->property_id);
                    }
                    if ($property->type == 'contracts') {
                        array_push($contracts, $property->property_id);
                    }
                }
                array_push($result, [
                    'id' => 'task-' . $task->id,
                    'title' => $task->name,
                    'users' => implode(",", $users),
                    'listings' => implode(",", $listings),
                    'appraisals' => implode(",", $appraisals),
                    'contacts' => implode(",", $contacts),
                    'contracts' => implode(",", $contracts),
                ]);
            }
            $board->item = $result;
        }
        return $boards;
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
        $priority_max = TaskBoard::max('priority');
        $newBoard = TaskBoard::create([
            'title' => $request->title,
            'priority' =>  $priority_max + 1
        ]);
        return $newBoard;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $board = TaskBoard::find($id);
        if ($board) {
            $board->update([
                'title' => $request->title
            ]);
        }
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $_ids = explode("-", $id);
        $board_id = $_ids[1];
        if ($board_id) {
            $board = TaskBoard::find($board_id);
            if ($board) {
                $board->forceDelete();
            }
        }
        return response()->json(true);
    }

    public function updateOrder(Request $request)
    {
        $board_ids = $request->boardIds;
        foreach ($board_ids as $key => $id) {
            $board = TaskBoard::find($id)->update([
                'priority' => $key + 1
            ]);
        }
        return response()->json(true);
    }
}
