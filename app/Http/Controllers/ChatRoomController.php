<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\User;
use App\Models\Group;
use DB;

class ChatRoomController extends Controller
{
    public function get_all(){
        return response()->json([
            'message' => 'Berhasil mengambil data user',
            'data' => User::all()
        ], 200);
    }
    public function get_chat_rooms(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|integer',
        ]);
        $group_table = DB::table('chat_room_users')
            ->join('chat_rooms', 'chat_room_users.chat_room_id', '=', 'chat_rooms.id') // double titik dua
            ->where([
                ['chat_room_users.sender_id', '=', $validated['user_id']],
                ['chat_rooms.is_group', '=', '1']
                ])
            ->join('groups', 'groups.id', '=', 'chat_rooms.receiver_id')
            ->select('groups.name as name', 'chat_rooms.receiver_id as id', 'chat_rooms.is_group as is_group', 'chat_room_users.chat_room_id as chat_room_id');
            // ->get(); // get ambil record berdasarkan queery kalau get_all ambil semua
        $user_table = DB::table('chat_room_users')
            ->join('chat_rooms', 'chat_room_users.chat_room_id', '=', 'chat_rooms.id') // double titik dua
            ->where([
                ['chat_room_users.sender_id', '=', $validated['user_id']],
                ['chat_rooms.is_group', '=', '0']
                ])
            ->join('users', 'users.id', '=', 'chat_rooms.receiver_id')
            ->select('users.name as name', 'chat_rooms.receiver_id as id', 'chat_rooms.is_group as is_group', 'chat_room_users.chat_room_id as chat_room_id');
        $union_table = $group_table->union($user_table)->get();
        return response()->json(['result'=>'success','data_query'=>$union_table], 200);
    }
    public function get_cr_messages(Request $request){
        $validated = $request->validate([
            'chat_room_id' => 'required|integer',
        ]);
        $result_query = ChatRoomUser::join('messages', 'messages.chat_room_user_id', '=', 'chat_room_users.id')
            ->where([
                ['chat_room_users.chat_room_id', '=', $validated['chat_room_id']]
                ])
            ->join('users', 'users.id', '=', 'chat_room_users.sender_id')
            ->select('messages.message as Message', 'chat_room_users.sender_id as SenderId', 'users.name as SenderName')
            ->get();
        return response()->json(['result'=>'success','data_query'=>$result_query], 200);
    }
    public function get_group_by_id(Request $request){
        $validated = $request->validate([
            'group_id' => 'required|integer',
        ]);
        return response()->json(['result'=>'success','data_query'=>Group::find($validated['group_id'])], 200);
    }
    public function get_user_by_id(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|integer',
        ]);
        return response()->json(['result'=>'success','data_query'=>User::find($validated['user_id'])], 200);
    }
}
