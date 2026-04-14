<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class TaskController extends ApiResponse
{
    use AuthorizesRequests;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function myTasks()
    {
        $userId = Auth::id();
        $response = $this->taskService->getMyTasks($userId);

        return TaskResource::collection($response->load(
            'assignedUser',
            'creator',
            'activities.user'
        ))->additional([
            'status' => true,
            'message' => 'My tasks retrieved successfully.',
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $response = $this->taskService->getAll($request);

        return TaskResource::collection($response)->additional([
            'status' => true,
            'message' => 'Tasks retrieved successfully.',
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $task = $this->taskService->create($request->validated());
        return $this->successResponse('Task created successfully', 201, new TaskResource($task));
    }

    public function show($id)
    {
        $task = $this->taskService->find($id);
        $this->authorize('viewAny', $task);

        return $this->successResponse('Task retrieved successfully', 200, new TaskResource($task->load(
            'assignedUser',
            'creator',
            'activities.user'
        )));
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->find($id);
        $this->authorize('update', $task);

        $task = $this->taskService->update($id, $request->validated());
        return $this->successResponse('Task updated successfully', 200, new TaskResource($task));
    }

    public function destroy($id)
    {
        $task = $this->taskService->find($id);
        $this->authorize('delete', $task);

        $this->taskService->delete($id);
        return $this->successResponse('Task deleted successfully', 200);
    }
}
