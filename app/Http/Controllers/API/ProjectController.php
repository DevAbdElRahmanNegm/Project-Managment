<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $projects = Project::get();
        return $this->success($projects);
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $check = $this->Validator([
            'name' => 'max:255|required',
        ], $request->all());

        if ($check !== true)
            return $check;

        $project = Project::create($request->all());

        return $this->success($project);
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = ['id' => $id];
        $check = $this->Validator([
            'id' => 'required|integer|exists:projects,id',
        ], $data);
        if ($check !== true)
            return $check;
        $project = Project::findOrfail($id);
        return $this->success($project);
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
            'id' => 'required|integer|exists:projects,id',
            'name' => 'required|string|max:100',
        ], $data);
        if ($check !== true)
            return $check;

        unset($data['id']);
        $project = Project::findOrfail($id);
        $project->update($data);

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
            'id' => 'required|integer|exists:projects,id',
        ], $data);
        if ($check !== true)
            return $check;

        $project = Project::findOrfail($id);
        $project->delete();


        if($project)
            return $this->success([
                'status' => 'success',
                "response" => ["action" => 'The request has been accepted for processing']
            ], 202);
        else
            return $this->fail('method_not_allowed', "Method Not Allowed", [], 405);

    }
}
