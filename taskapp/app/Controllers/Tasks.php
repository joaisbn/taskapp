<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Tasks extends BaseController
{
    protected $model = null;

    public function __construct()
    {
        $this->model = new \App\Models\TaskModel();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $data = $this->model->findAll();

        return view("Tasks/index", ['tasks' => $data]);
    }


    public function show($id)
    {
        $task = $this->model->find($id);

        return view('Tasks/show', ['task' => $task]);
    }


    public function new()
    {
        return view('Tasks/new');
    }


    public function create()
    {
        if (!$this->model->insert([
            'description' => $this->request->getPost('description'),
        ])) :
            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data');
        else :
            return redirect()
                ->to("tasks/show/{$this->model->insertID}")
                ->with('info', 'Task created successfully');
        endif;
    }
}
