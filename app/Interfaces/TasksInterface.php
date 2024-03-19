<?php

namespace App\Interfaces;

interface TasksInterface
{
    public function getTasks();
    public function getTask($id);
    public function searchTask($title);
    public function createTask($data);
    public function updateTask($id, $data);
    public function deleteTask($id);
}
