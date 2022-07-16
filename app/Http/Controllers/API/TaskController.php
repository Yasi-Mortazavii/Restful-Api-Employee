<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $task = Task::all();
        return response([
            'tasks' => TaskResource::collection($task), 'message' => 'Retrieved Successfully'
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
}
