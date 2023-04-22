<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    // タスクリポジトリ
    // @var TaskRepository
    protected $tasks;

// 認証機能をTaskControllerで有効にするための機能
// @return void
   public function __construct(TaskRepository $tasks)
   {
        $this->middleware('auth');
        $this->tasks = $tasks;
   } 
   
    //タスク一覧
    // @param Request $request
    // @return Response

    public function index(Request $request)
    {
        // $tasks = Task::orderBY('created_at', 'asc')->get();
        // $tasks = $request->user()->tasks()->get();
        return view('tasks.index', [
        'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    //タスク作成
    // @param Request $request
    // @return Response

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        // Task::create([
        //     'user_id' => 0,
        //     'name'=> $request->name
        // ]);
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    // * タスク削除
    // *
    // * @param Request $request
    // * @param Task $task
    // * @return Response

        public function destroy(Request $request, Task $task)
        {
            $this->authorize('destroy', $task);
            $task->delete();
            return redirect('/tasks');
        }

}