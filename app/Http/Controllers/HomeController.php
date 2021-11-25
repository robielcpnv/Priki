<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Practice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(int $nbDays)
    {
        $practices = Practice::all()
            ->where('updated_at','>=',Carbon::now()->subDay($nbDays));
        return view('home', compact('practices','nbDays'));
    }

}
