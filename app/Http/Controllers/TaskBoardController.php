<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskBoard;
use Illuminate\Http\Request;

class TaskBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = TaskBoard::all();
        foreach ($boards as $key => $board) {
            $result = [];
            $tasks = Task::where('board_id', $board->id)->get();
            foreach ($tasks as $key => $task) {
                array_push($result, [
                    'title' => $task->name
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
        $newBoard = TaskBoard::create([
            'title' => $request->title
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
        //
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
                $board->delete();
            }
        }
        return true;
    }
}
