<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Pusher\Pusher;
use App\Events\MyEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $users = DB::select("
            SELECT users.id, users.name, users.avatar, users.email, count(is_read) AS unread
            FROM users
            LEFT JOIN messages
            ON users.id = messages.from
            AND is_read = 0 
            AND messages.to = " .Auth::id(). "
            WHERE users.id != " .Auth::id(). "
            GROUP BY users.id, users.name, users.avatar, users.email
        ");

        return view('home', ['users' => $users]);
    }

    public function getMessage($user_id){
        $my_id = Auth::id();

        //When get message, update all to read
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

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

    public function sendMessage(Request $request){

        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; //Unread
        $data->save();

        $data = ['from' => $from, 'to' => $to];

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from'=>$from, 'to'=>$to];
        $response = $pusher->trigger('my-channel', 'my-event', $data);
    }
}
