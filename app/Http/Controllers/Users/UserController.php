<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\UserRequests;

use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userService->getAll($request);
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
    public function store(Request $request, UserRequests $validate)
    {
        return $this->userService->userCreate($request, $validate);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->userService->getById($request);
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
    public function update(Request $request, UserRequests $validate)
    {
        return $this->userService->userUpdate($request, $validate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, UserRequests $validate)
    {
        return $this->userService->userDelete($request, $validate);
    }
}
