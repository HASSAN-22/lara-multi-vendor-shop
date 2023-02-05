<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(){
        $sliders = Slider::get();
        return view('index',compact('sliders'));
    }
}
