<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Migrate extends BaseController
{
    public function index()
    {
        $migrate = \Config\Services::migrations();
        echo 'migrated';

        try {
            dd($migrate);
            $migrate->latest();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
