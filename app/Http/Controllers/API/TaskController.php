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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
