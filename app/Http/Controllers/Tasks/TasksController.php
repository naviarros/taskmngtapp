<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequests;

use App\Services\TasksService;

class TasksController extends Controller
{
    private $tasks;

    public function __construct(TasksService $tasks)
    {
        $this->tasks = $tasks;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->tasks->getAllTasks($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TaskRequests $validate)
    {
        return $this->tasks->taskCreate($request, $validate);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->tasks->getTask($request);
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
    public function update(Request $request, TaskRequests $validate)
    {
        return $this->tasks->taskUpdate($request, $validate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TaskRequests $validate)
    {
        return $this->tasks->taskDelete($request, $validate);
    }
}
