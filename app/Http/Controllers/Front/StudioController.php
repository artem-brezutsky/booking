<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Studio;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class StudioController extends Controller
{
    /**
     * Show front studio list
     *
     * @return Factory|View
     */
    public function index()
    {
        $user = auth()->user();
        $studios = Studio::all();

        return view('front.pages.studios.index', compact('studios', 'user'));
    }
}
