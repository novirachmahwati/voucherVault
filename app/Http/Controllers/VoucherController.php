<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('vouchers.index');
    }

    public function create()
    {
        return view('vouchers.create');
    }
}
