<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardContrller extends Controller
{
 public function index()
 {
      $data = [
         'active' => 'Pos ',
         'title' => 'Pos',
         'heading' => 'Pos',
      ];
    return view('layouts.admin',$data);
 }
}
