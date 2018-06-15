<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostFavoriteController extends Controller
{
    

    
    
    public function store(Request $request, $id)
    {
        \Auth::user()->do_favorite($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->undo_favorite($id);
        return redirect()->back();
    }
}
