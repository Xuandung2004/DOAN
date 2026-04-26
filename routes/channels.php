<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// THÊM ĐOẠN NÀY VÀO DƯỚI CÙNG
Broadcast::channel('chat.{id}', function ($user, $id) {
    // Chỉ cho phép nghe nếu ID người dùng trùng với ID kênh, HOẶC người đó là Admin (vaitro = 1)
    return (int) $user->id === (int) $id || (int) $user->vaitro === 1;
});