<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Halaman chat
    public function chat()
    {
        return view('home');
    }

    // ============================
    // 1️⃣ SEND MESSAGE (with context)
    // ============================
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history_id' => 'nullable|integer'
        ]);

        $question = $request->message;
        $historyId = $request->history_id;

        // Cari atau buat history baru
        if ($historyId) {
            $history = ChatHistory::where('id', $historyId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$history) {
                return response()->json([
                    "success" => false,
                    "error" => "History tidak ditemukan atau tidak milik user ini"
                ], 403);
            }
        } else {
            $history = ChatHistory::create([
                'user_id' => Auth::id(),
                'session_id' => null,
                'title' => substr($question, 0, 50)
            ]);
        }

        // Simpan pesan user
        ChatMessage::create([
            'history_id' => $history->id,
            'sender' => 'user',
            'content' => $question
        ]);

        // 🔥 KUMPULKAN KONTEXT UNTUK FLOWISE
        $allMessages = ChatMessage::where('history_id', $history->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $contextText = "";

        foreach ($allMessages as $msg) {
            $role = $msg->sender === 'user' ? "User" : "Bot";
            $contextText .= "$role: " . $msg->content . "\n";
        }

        // Kirim ke Flowise
        try {
            $endpoint = 'https://cloud.flowiseai.com/api/v1/prediction/2b345575-c5fb-452a-8035-481b2ceef55a';

            $res = Http::post($endpoint, [
                "question" => $contextText
            ]);

            $data = $res->json();
            $reply = $data['text'] ?? '[no response]';
        } catch (\Exception $e) {
            $reply = "⚠️ Error: " . $e->getMessage();
        }

        // Simpan jawaban bot
        ChatMessage::create([
            'history_id' => $history->id,
            'sender' => 'bot',
            'content' => $reply
        ]);

        $history->touch();

        return response()->json([
            "success" => true,
            "reply" => $reply,
            "history_id" => $history->id,
            "message" => "Pesan berhasil dikirim"
        ]);
    }

    // ============================
    // 2️⃣ LOAD ALL USER HISTORY
    // ============================
    public function histories()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json([
                    'error' => 'User tidak terautentikasi',
                ], 401);
            }

            $histories = ChatHistory::where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json($histories);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================
    // 3️⃣ LOAD MESSAGES BY HISTORY
    // ============================
    public function messages($id)
    {
        $history = ChatHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$history) {
            return response()->json([
                "error" => "History tidak ditemukan atau tidak milik user ini"
            ], 403);
        }

        $messages = ChatMessage::where('history_id', $id)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    // ============================
    // 4️⃣ Alias ask() → send()
    // ============================
    public function ask(Request $request)
    {
        return $this->send($request);
    }
}
