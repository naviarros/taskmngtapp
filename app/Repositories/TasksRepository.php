<?php

namespace App\Repositories;

use App\Interfaces\TasksInterface;
use App\Models\Task;

class TasksRepository implements TasksInterface
{
    protected $tasks;

    public function __construct(Task $task)
    {
        $this->tasks = $task;
    }

    public function getTasks($perPage = 10)
    {
        return $this->tasks->paginate($perPage);
    }

    public function sortTasks($perPage = 10, $sort_by, $sort_order)
    {
        return $this->tasks->orderBy($sort_by, $sort_order)->paginate($perPage);
    }

    public function getTask($id)
    {
        return $this->tasks->find($id);
    }

    public function searchTask($title)
    {
        return $this->tasks->where('title', 'LIKE', '%'.$title.'%')->get();
    }

    public function tasksPerUser($user_id)
    {
        return $this->tasks->where('user_id', $user_id)->get();
    }

    public function createTask($data)
    {
        return $this->tasks->create($data);
    }

    public function updateTask($id, $data)
    {
        return $this->tasks->where('task_id', $id)->update($data);
    }

    public function deleteTask($id)
    {
        return $this->tasks->where('task_id', $id)->delete();
    }
}
