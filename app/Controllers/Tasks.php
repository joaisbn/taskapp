<?php

namespace App\Controllers;

class Tasks extends BaseController
{
    public function index(): string
    {
        $taskModel = new \App\Models\TaskModel();

        $data['tasks'] = $taskModel->findAll();

        return view('Tasks/index', $data);
    }
}
