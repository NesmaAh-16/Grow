<?php

// app/Http/Controllers/SupportMessageController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SupportMessage;

class SupportMessageController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $adminUserId = User::role(['admin', 'user-admin'])->value('id'); // أول حساب له أحد هالدورين
        if (!$adminUserId) {
            return back()->withErrors(['message' => 'لا يوجد حساب إدارة لاستقبال الرسائل.']);
        }

        SupportMessage::create([
            'created_by_user_id' => auth()->id(),
            'admin_user_id' => $adminUserId,   // توجيه للإدارة
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'status' => 'open',
        ]);
        return back()->with('status', 'تم إرسال الرسالة إلى الإدارة.');
    }
    public function index()
    {
        // لعرض كل الرسائل مثلاً
        $messages = SupportMessage::latest()->get();
        return view('support_message', compact('messages'));
    }


    public function reply(Request $r, SupportMessage $supportMessage)
    {
        $r->validate([
            'response' => 'required|string',
            'status' => 'required|in:answered,closed,open',
        ]);

        $supportMessage->update([
            'response' => $r->response,
            'status' => $r->status,
        ]);

        return back()->with('status', 'تم تحديث الرسالة.');
    }
}
