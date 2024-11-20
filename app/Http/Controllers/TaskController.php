<?php

namespace App\Http\Controllers;

use App\Models\Statu;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * @return response()
    */
    public function index()
    {
        $tasks = Task::with(['status', 'user'])->orderBy('created_at', 'desc')->get();
        $statuses = Statu::all(); //pegando os status para os filtrar no front

        $user = auth()->user();
        $isAdmin = Gate::allows('isAdmin', $user); // Verificar se o usuário é um admin usando a Gate
        
        return Inertia::render('Task/Index', [
            'tasks' => $tasks, //exibir a lista das tarefas 
            'statuses' => $statuses, //para filtrar os dados na tb
            'user' => $user, //usuário logado
            'isAdmin' => $isAdmin,  // passando a verificação de admin para o Vue
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
        $request->validate([
            'title' => 'required|min:4',
            'description' => 'required|min:12',
        ]);

        $task = new Task($request->all());
        $task->user_id = auth()->id();
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
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
        ]);
        
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
