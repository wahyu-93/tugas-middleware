<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class adminController extends Controller
{
    public function tesMasukAdmin(){
        
        return 'Selamat Datang Admin';
    }

    public function verifEmail(){
        return 'Email Anda Sudah diverifikasi';
    }
}
