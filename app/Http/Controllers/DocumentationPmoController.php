<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationPmoController extends Controller
{
    public function index()
    {

        return view('pmo-documentation.index');
    }
}
