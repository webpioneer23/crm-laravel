<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskBoard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title'
    ];

    // public function getItemAttribute()
    // {
    //     $result = [];
    //     $tasks = Task::where('board_id', $this->id)->get();
    //     foreach ($tasks as $key => $task) {
    //         array_push($result, [
    //             'title' => $task->name
    //         ]);
    //     }
    //     return $result;
    // }
}
