<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\User;
use App\Models\Group;

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
        $query_result = ChatRoomUser::join('users', 'chat_room_users.sender_id', '=', 'users.id') // double titik dua
            ->join('chat_rooms', 'chat_room_users.chat_room_id', '=', 'chat_rooms.id')
            ->where([
                ['chat_room_users.sender_id', '=', $validated['user_id']]
                ])
            ->select('chat_room_users.id as cr_user_id', 'chat_rooms.receiver_id as id_penerima', 'chat_rooms.is_group as is_group','users.name as pengirim')
            ->get(); // get ambil record berdasarkan queery kalau get_all ambil semua
            return response()->json(['result'=>'success','data_query'=>$query_result], 200);
    }
    public function get_cr_messages(Request $request){
        $validated = $request->validate([
            'chat_room_id' => 'required|integer',
            'sender_id' => 'required|integer',
        ]);
        $result_query = ChatRoomUser::join('messages', 'messages.chat_room_user_id', '=', 'chat_room_users.id')
            ->where([
                ['chat_room_users.chat_room_id', '=', $validated['chat_room_id']],
                ['chat_room_users.sender_id', '=', $validated['sender_id']]
                ])
            ->select('messages.message as Pesan', 'chat_room_users.sender_id as IdPengirim')
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
