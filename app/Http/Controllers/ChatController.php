<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 1. Giao diện trang Admin Quản lý Chat
    public function adminChat()
    {
        // Lấy danh sách khách hàng (những người không phải Admin)
        $users = User::where('vaitro', '!=', 1)->get();
        return view('admin.chat', compact('users'));
    }

    // 2. Lấy lịch sử tin nhắn giữa 2 người
    public function getMessages($userId)
    {
        $myId = Auth::id();
        $messages = Message::with(['sender', 'receiver'])
            ->where(function($q) use ($myId, $userId) {
                $q->where('nguoiguiID', $myId)->where('nguoinhanID', $userId);
            })
            ->orWhere(function($q) use ($myId, $userId) {
                $q->where('nguoiguiID', $userId)->where('nguoinhanID', $myId);
            })
            ->orderBy('ngaytao', 'asc')
            ->get();

        return response()->json($messages);
    }

    // 3. Xử lý Gửi tin nhắn và Phát sóng (Broadcast)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'nguoinhanID' => 'required|exists:nguoidung,id',
            'noidung' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'nguoiguiID' => Auth::id(),
            'nguoinhanID' => $request->nguoinhanID,
            'noidung' => $request->noidung,
            'dadoc' => 0
        ]);

        $message->load('sender');

        // Hét lên Reverb báo có tin nhắn mới
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'success', 'message' => $message]);
    }
    // Hàm 1: Đếm tổng số tin nhắn chưa đọc của người dùng hiện tại
    public function getUnread()
    {
        $count = Message::where('nguoinhanID', Auth::id())->where('dadoc', 0)->count();
        return response()->json(['count' => $count]);
    }

    // Hàm 2: Đánh dấu đã đọc khi mở khung chat
    public function markRead(Request $request)
    {
        $nguoiguiID = $request->nguoiguiID; // ID người gửi (Khách hoặc Admin)
        $nguoinhanID = Auth::id(); // Mình là người nhận

        // Chuyển toàn bộ tin nhắn chưa đọc của người này gửi cho mình thành đã đọc
        Message::where('nguoiguiID', $nguoiguiID)
               ->where('nguoinhanID', $nguoinhanID)
               ->where('dadoc', 0)
               ->update(['dadoc' => 1]);

        return response()->json(['success' => true]);
    }
}