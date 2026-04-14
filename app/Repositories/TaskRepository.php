<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskActivity;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    public function getByUser($userId)
    {
        return Task::query()->where('assigned_to', $userId)->latest()->get();
    }

    public function all($request)
    {
        return Task::with([
            'assignedUser',
            'creator',
            'activities.user'
        ])->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
            });
        })->when($request->status, function ($query, $status) {
            $query->where('status', $status);
        })->when($request->priority, function ($query, $priority) {
            $query->where('priority', $priority);
        })->when($request->assigned_to, function ($query, $userId) {
            $query->where('assigned_to', $userId);
        })->latest()->paginate($request->input('per_page', 15));
    }

    public function find($id)
    {
        return Task::findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update($data);

        return $task;
    }

    public function delete($id)
    {
        return Task::findOrFail($id)->delete();
    }

    public function logActivity($taskId, $action)
    {
        TaskActivity::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'action' => $action,
        ]);
    }
}
