<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Halaman index PUBLIC (sebelum login) - TAMBAH INI
    public function indexPublic()
    {
        return view('index'); // halaman landing/public
    }

    // Halaman home SETELAH login (protected)
    public function index()
    {
        return view('home'); // halaman dashboard setelah login
    }
}
