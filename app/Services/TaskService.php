<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    protected $repo;

    public function __construct(TaskRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getMyTasks($userId)
    {
        return $this->repo->getByUser($userId);
    }

    public function getAll($request)
    {
        return $this->repo->all($request);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();

        $task = $this->repo->create($data);

        $this->repo->logActivity($task->id, 'task created');

        return $task;
    }

    public function update($id, array $data)
    {
        $task = $this->repo->update($id, $data);

        $this->repo->logActivity($id, 'task updated');

        return $task;
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
