<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Service\TaskService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{

    public function __construct(protected TaskService $taskService){}
    public function index(Request $request)
    {
       $tasks = $this->taskService->list($request);

        return Inertia::render('tasks/Index', [
            'tasks' => $tasks,
            'filters' => $request->only(['name', 'started_at', 'finished_at'])
        ]);
    }

    public function show(Task $task)
    {

        return Inertia::render('tasks/Show', [
            'task' => $task
        ]);
    }

    public function create()
    {
        return Inertia::render('tasks/Create');
    }

    public function store(StoreTaskRequest $request)
    {
        $this->taskService->create($request->validated());

        return redirect()->route('tasks.index')
        ->with('success', 'Tarefa cadastrada com sucesso!');
    }
    public function edit(Task $task)
    {

        return Inertia::render('tasks/Edit', ['task' => $task]);
    }

    public function update(Task $task, UpdateTaskRequest $request)
    {
        $this->taskService->update($task, $request->validated());

        return redirect()->route('tasks.index')
        ->with('success', 'Tarefa editada com sucesso!');
    }


    public function destroy(Task $task)
    {
        $this->taskService->delete($task);

        return redirect()->route('tasks.index')
        ->with( 'success', 'Tarefa excluída com sucesso!');
    }
}
