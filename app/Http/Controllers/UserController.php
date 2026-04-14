<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiResponse
{
    public function user(Request $request)
    {
        return $this->successResponse('User data retrieved successfully', 200, [
            'user' => $request->user()
        ]);
    }

    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->get();
        return $this->successResponse('Users retrieved successfully', 200, [
            'users' => $users
        ]);
    }
}
