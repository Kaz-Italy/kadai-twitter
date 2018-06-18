<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User; 
use App\Micropost; 

class MicropostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            
            $user = \Auth::user();
            $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
            $micropost_childs = array();
            $user_childs = array();
        
        foreach ($microposts as $micropost) {
                // select * from micropsots wjhere responseid == 1
                $micropost_childs[$micropost->id] =  Micropost::where('response_id', $micropost->id)->get();
        }

        $data = [
            'user' => $user,
            'microposts' => $microposts,
            'micropost_childs' =>  $micropost_childs,
        ];

        $data += $this->counts($user);        
    
        }
       return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::user()->id === $micropost->user_id) {
            $micropost->delete();
        }

        return redirect()->back();
    }
    
    public function reply($id)
    {
        
        /*返信先のIDを用いて返信先のmicropostオブジェクト生成*/
        /*このオブジェクトを用いてビューでuserとかを生成*/
        /*belongToとかのおかげで簡単にユーザー情報を得られる*/
        
        $micropost = \App\Micropost::find($id);
        
        $data = [
            'micropost'=> $micropost,
        ];
        
        return view('users.reply', $data);
        
    }
    public function update(Request $request, $reply_id)
    {
        
        \Auth::user()->microposts()->create([
            
            'response_id'=> $reply_id,
            'content' => $request->content,
        ]);
        
        return redirect('/');
        
    }
}