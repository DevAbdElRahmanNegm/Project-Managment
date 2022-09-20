<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $tasks = Task::get();
        return $this->success($tasks);
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $check = $this->Validator([
            'name' => 'max:255|required',
            'details' => 'max:500|required',
            'project_id'=>'required|integer|exists:projects,id',
            'employee_id'=>'required|integer|exists:users,id',
        ], $request->all());

        if ($check !== true)
            return $check;

        $task = Task::create($request->all());

        return $this->success($task);
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = ['id' => $id];
        $check = $this->Validator([
            'id' => 'required|integer|exists:tasks,id',
        ], $data);
        if ($check !== true)
            return $check;
        $task = Task::findOrfail($id);
        return $this->success($task);
    }


    /**
     * @param Request $request
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $check = $this->Validator([
            'name' => 'max:255|required',
            'details' => 'max:500|required',
            'project_id'=>'required|integer|exists:projects,id',
            'employee_id'=>'required|integer|exists:users,id',
        ], $data);
        if ($check !== true)
            return $check;

        unset($data['id']);
        $task = Task::findOrfail($id);
        $task->update($data);

        return $this->success([
            'status' => 'success',
            "response" => ["action" => 'The request has been accepted for processing']
        ], 202);
    }


    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function delete($id){

        $data['id'] = $id;
        $check = $this->Validator([
            'id' => 'required|integer|exists:tasks,id',
        ], $data);
        if ($check !== true)
            return $check;

        $task = Task::findOrfail($id);
        $task->delete();


        if($task)
            return $this->success([
                'status' => 'success',
                "response" => ["action" => 'The request has been accepted for processing']
            ], 202);
        else
            return $this->fail('method_not_allowed', "Method Not Allowed", [], 405);

    }


}
