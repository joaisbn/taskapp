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

    public function show($id)
    {
        $taskModel = new \App\Models\TaskModel();

        $task = $taskModel->find($id);

        return view('Tasks/show', [
            'task' => $task
        ]);
    }

    public function new()
    {
        return view('Tasks/new');
    }

    public function create()
    {
        $taskModel = new \App\Models\TaskModel();

        $description = $this->request->getPost('description');

        $data = [
            'description' => $description
        ];

        $result = $taskModel->insert($data);

        if ($result === false) {
            return redirect()
                ->back()
                ->with('errors', $taskModel->errors())
                ->with('warning', 'Invalid data');
        } else {
            return redirect()
                ->to(site_url('/tasks/show/' . $result))
                ->with('info', 'Task created successfully');
        }
    }
}
