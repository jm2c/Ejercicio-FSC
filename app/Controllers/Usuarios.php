<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;

class Usuarios extends BaseController
{
    public function loginForm()
    {
        $session = session();

        if($session->logged)
            return redirect('inicio');

        return view('layout/header')
             . view('loginForm')
             . view('layout/footer');
    }

    public function login()
    {
        $request = request();
        $db = \Config\Database::connect();

        $inputNick = $request->getPost('nickname');
        $inputPass = $request->getPost('password');

        $query = $db->table('usuarios')->where('nickname', $inputNick)->get()->getResultArray();
        if(isset($query[0]))
        {
            // Usuario encontrado
            if($inputPass == $query[0]['password'])
            {
                // OK
                $session = session();
                $session->set('nick', $inputNick);
                $session->set('logged', true);
                return redirect('dashboard');
            }
            else
            {
                // Contraseña incorrecta
                return redirect('loginForm');
            }
        }
        else
        {
            // Usuario no encontrado
            return redirect()->to('/login');
        }
    }

    public function logout() {
        $session = session();
        $session->destroy();
        return redirect('inicio');
    }
}
