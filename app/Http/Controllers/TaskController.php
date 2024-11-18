<?php

namespace App\Http\Controllers;

use App\Models\Statu;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * @return response()
    */
    public function index()
    {
        $tasks = Task::with('status')->orderBy('created_at', 'desc')->get();
        $statuses = Statu::all(); //pegando os status para os filtrar no front
        
        return Inertia::render('Task/Index', [
            'tasks' => $tasks, //exibir a lista das tarefas 
            'statuses' => $statuses, //para filtrar os dados na tb
        ]);
    }

    /**
     * @return response()
    */
    public function create()
    {
        return Inertia::render('Task/Create');
    }

    /**
     * @return response()
    */
    public function store(Request $request)
    {
        $task = new Task($request->all());
        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     * @return response()
    */
    public function edit(Task $task)
    {
        $statuses = Statu::all();
        return Inertia::render('Task/Edit', [
            'task' => $task, //para editar
            'statuses' => $statuses, //exibir no select em edit.vue
        ]);
    }

    /**
     * @return response()
    */
    public function update(Request $request, Task $task)
    {
      $task->update($request->all());
      return redirect()->route('tasks.index');
    }

    /**
     * @return response()
    */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
}
