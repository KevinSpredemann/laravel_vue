<?php

namespace App\Service;

use App\Filters\TaskFilter;
use App\Models\Task;

class TaskService
{
    public function list($request)
    {
       return Task::filter(new TaskFilter($request))
       ->orderBy('started_at', 'ASC')
       ->paginate(5)
       ->withQueryString();
    }
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
         return $task->update($data);
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}
