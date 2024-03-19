<?php

namespace App\Services;

use App\Repositories\TasksRepository;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequests;
use Illuminate\Http\JsonResponse;

class TasksService
{
    private $tasksRepository;

    public function __construct(TasksRepository $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }

    public function getAllTasks(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            if($request->has('sort_by') && $request->has('order_by'))
            {
                $get_tasks = $this->tasksRepository->sortTasks($limit, $request->get('sort_by'), $request->get('order_by'));
            }
            else {
                $get_tasks = $this->tasksRepository->getTasks($limit);
            }

            return response()->json([
                'success' => true,
                'data' => $get_tasks,
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTask(Request $request)
    {
        try {
            $task_id = $request->get('task_id');

            if($request->has('user_id'))
            {
                $get_tasks = $this->tasksRepository->tasksPerUser($request->get('user_id'));
            }
            else if($request->has('title'))
            {
                $get_tasks = $this->tasksRepository->searchTask($request->get('title'));
            }
            else {
                $get_tasks = $this->tasksRepository->getTask($task_id);
            }

            return response()->json([
                'success' => true,
                'data' => $get_tasks,
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function taskCreate(Request $request, TaskRequests $validate)
    {
        try {
            $validator = $validate->authorize($request);

            if ($validator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $validator;
            }

            // Here, $validator is the validator instance, and you can use it if needed
            $validatedData = $validator->validated();

            $validatedData['created_at'] = now()->format('Y-m-d H:i:s');

            $create_task = $this->tasksRepository->createTask($validatedData);

            return response()->json([
                'success' => true,
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
                'server_response' => 'error'
            ]);
        }
    }

    public function taskUpdate(Request $request, TaskRequests $validate)
    {
        try {
            $validator = $validate->authorize($request);

            if ($validator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $validator;
            }

            // Here, $validator is the validator instance, and you can use it if needed
            $validatedData = $validator->validated();

            $validatedData['updated_at'] = now()->format('Y-m-d H:i:s');

            $update_task = $this->tasksRepository->updateTask($validatedData['task_id'], $validatedData);

            return response()->json([
                'success' => true,
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
                'server_response' => 'error'
            ]);
        }
    }

    public function taskDelete(Request $request)
    {
        try {
            $delete_task = $this->tasksRepository->deleteTask($request->get('task_id'));

            return response()->json([
                'success' => true,
                'server_response' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
                'server_response' => 'error'
            ]);
        }
    }
}
