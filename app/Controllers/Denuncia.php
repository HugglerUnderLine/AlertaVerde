<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Denuncia extends BaseController
{
    public function index($tipoConta = null)
    {
        if(!$this->request->is('POST')) {
            return view('dashboard-'.$tipoConta);
        }
    }
}
