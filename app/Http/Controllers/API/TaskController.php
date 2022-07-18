<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $tasks = Task::all();
        return response([
            'tasks' => TaskResource::collection($tasks), 'message' => 'Retrieved Successfully'
        ], 200);

    }

    public function store(Request $request)
    {
        $data      = $request->all();
        $validator = validator::make($data, [
            'name'     =>  'required|max:225',
            'comment'    =>  'required|string',
            'state' =>  'required|boolean',
            'time' =>  'required|date',
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Errors.']);
        }
        $task = Task::create($data);
        return response([
            'task'    => new TaskResource($task),
            'message' => 'Created Successfuly',
        ], 201);

    }


    public function show(Task $task)
    {
        return response([
            'task'    => new TaskResource($task),
            'message' => 'Retrivied Successfuly',
        ], 200);
    }


    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response([
            'task'    => new TaskResource($task),
            'message' => 'Updated Successfuly',
        ], 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response([
            'message' => ' Data Deleted',
        ], 200);

    }
    public function search($time){
        $user = Auth::user();
        if($user->is_admin == 1){
            $tasks = Task::where("time", "like", "%".$time."%")->get();
            return response([
                'tasks' => TaskResource::collection($tasks), 'message' => 'Retrieved Successfully'
            ], 200);     
        }
       

    }
    public function sort(){
        $user = Auth::user();
        if($user->is_admin == 1){
            $tasks = Task::orderBy("state", "desk")->get();
            return response([
                'tasks' => TaskResource::collection($tasks), 'message' => 'Retrieved Successfully'
            ], 200);     
        }


    
}
