<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(20);
        return view('admin.inbox.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $message->update(['is_read' => true]);
        return view('admin.inbox.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.inbox.index')->with('success', 'Mesaj silindi.');
    }
}
