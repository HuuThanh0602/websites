<?php

namespace App\Http\Controllers\Frontend\MyOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    public function index()  {

        
        return view('frontend.order.my-order');
    }


    public function detail()  {


        return view('frontend.order.detail');
    }
}
