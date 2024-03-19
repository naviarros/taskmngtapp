<?php

namespace App\Services;

use App\Http\Requests\UserRequests;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserService extends UserRepository
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 10;

            $paginated_results = $this->userRepository->getAllUsers($limit);

            return response()->json([
                'success' => true,
                'data' => $paginated_results,
                'server_response' => 'ok'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
                'server_response' => 'error'
            ], 500); // Consider using an appropriate status code for errors
        }
    }

    public function getById(Request $request)
    {
        try {
            $user = $this->userRepository->getUserById($request->get('user_id'));

            return response()->json([
                'success' => true,
                'data' => $user,
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

    public function userCreate(Request $request, UserRequests $validate)
    {
        try {
            $validator = $validate->authorize($request);

            if ($validator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $validator;
            }

            // Here, $validator is the validator instance, and you can use it if needed
            $validatedData = $validator->validated();

            $validatedData['password'] = bcrypt($validatedData['password']);

            $user = $this->userRepository->createUser($validatedData);

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

    public function userUpdate(Request $request, UserRequests $validate)
    {
        try {
            $validator = $validate->authorize($request);

            if ($validator instanceof JsonResponse) {
                // If validation failed, return the JSON response with errors
                return $validator;
            }

            // Here, $validator is the validator instance, and you can use it if needed
            $validatedData = $validator->validated();

            $validatedData['password'] = bcrypt($validatedData['password']);

            $user = $this->userRepository->updateUser($validatedData['user_id'], $validatedData);

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

    public function userDelete(Request $request)
    {
        try {

            $user_id = $request->get('user_id');

            $user = $this->userRepository->deleteUser($user_id);

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
