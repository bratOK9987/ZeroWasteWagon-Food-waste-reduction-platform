<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

class GoogleTranslateController extends Controller
{
    public function changeLocale($locale)
    {
        session(['locale' => $locale]);
        App::setLocale($locale);
        $currentLocale = App::getLocale();
        // dd($currentLocale);
        return redirect()->back();
    }
}
