<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'board_id',
        'due_date',
        'comment',
        'note',
        'priority'
    ];

    public function users()
    {
        $user_ids = TaskProperty::where(['task_id' => $this->id, 'type' => 'users'])->pluck('property_id');
        return User::whereIn('id', $user_ids);
    }
}
