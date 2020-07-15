<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome to my crud app';
        return view('pages.index', ['title'=>$title]);
    }

    public function about(){
        $title = 'About us';
        return view('pages.about')->with('title', $title);
    }

    public function services(){
        $data = array(
            'title'=> 'Services',
            'services' => ['Programming', 'SEO', 'WebDesign']
        );
        
        return view('pages.services', $data);
    }
}
