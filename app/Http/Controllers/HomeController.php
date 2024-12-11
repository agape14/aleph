<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $estudiantes=Estudiante::all();
        return view('admin.home', [
            'msg' => "Hello! I am admin",
            'estudiantes' => $estudiantes // Pasar la colección a la vista
        ]);
    }
    public function userHome()
    {
        return view('user.home',["msg"=>"Hello! I am user"]);
    }
}
