<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ShowAllTasks(){

        $user_id = auth()->user()->id;
        $tasks = Task::where('employee_id','=',$user_id)->get();
        return $this->success($tasks);
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function SubmitTask($id){
        $data = ['id' => $id];
        $check = $this->Validator([
            'id' => 'required|integer|exists:tasks,id',
        ], $data);
        if ($check !== true)
            return $check;
        $user_id = auth()->user()->id;
        $task = Task::where('employee_id','=',$user_id)->find($id);

        if ($task->status == 'Submit'){
            return $this->fail('method_not_allowed', "This Task Is Already Submit", [], 405);
        }else{

            $task->update([
                'status'=>'Submit'
            ]);

            return $this->success([
                'status' => 'success',
                "response" => ["action" => 'The Task is Submit']
            ], 202);

        }

    }

}
