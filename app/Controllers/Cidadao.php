<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Cidadao extends BaseController
{
    public function index() {
        if(!$this->request->is('POST')) {
            return view('dashboard-cidadao', ['conta' => 'cidadao']);
        }
    }
}
