<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $datas=Cart::all();
        return view('dashboard',compact('datas'));
    }
}
