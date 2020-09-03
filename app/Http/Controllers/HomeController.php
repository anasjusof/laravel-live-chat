<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Select all user except auth id
        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('home', ['users' => $users]);
    }

    public function getMessage($user_id){
        $my_id = Auth::id();

        $messages = Message::where(function($q) use($user_id, $my_id){
                                        $q->where('from', $my_id);
                                        $q->where('to', $user_id);
                                    })
                            ->orWhere(function($q) use($user_id, $my_id){
                                        $q->where('from', $user_id);
                                        $q->where('to', $my_id);
                                    })
                            ->get(); 

        return view('message.index', ['messages' => $messages]);
    }
}
