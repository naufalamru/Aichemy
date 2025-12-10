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
    // Halaman chat (home.blade)
    public function chat()
    {
        return view('home');
    }

    // ============================
    // 1️⃣ SEND MESSAGE
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
                'title' => substr($question, 0, 50) // Ambil 50 karakter pertama sebagai title
            ]);
        }

        // Simpan pesan user
        ChatMessage::create([
            'history_id' => $history->id,
            'sender' => 'user',
            'content' => $question
        ]);

        // Kirim ke Flowise
        try {
            $endpoint = 'https://cloud.flowiseai.com/api/v1/prediction/13c1bdeb-3438-4ad4-9ec3-f1878bcdc7e0';

            $res = Http::post($endpoint, [
                "question" => $question
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

        // Update timestamp history supaya daftar history terurut terbaru
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
            $user = Auth::user();
            
            // Log untuk debugging (bisa dihapus setelah fix)
            Log::info('Histories request', [
                'user_id' => $userId,
                'user' => $user ? $user->name : 'null',
                'authenticated' => Auth::check()
            ]);
            
            if (!$userId) {
                return response()->json([
                    'error' => 'User tidak terautentikasi',
                    'authenticated' => false
                ], 401);
            }

            $histories = ChatHistory::where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json($histories);
        } catch (\Exception $e) {
            Log::error('Error loading histories', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Terjadi kesalahan saat memuat history: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================
    // 3️⃣ LOAD MESSAGES BY HISTORY
    // ============================
    public function messages($id)
    {
        // Validasi bahwa history milik user yang login
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
    // 4️⃣ ASK CHATBOT (alias untuk send)
    // ============================
    public function ask(Request $request)
    {
        // Ini adalah alias dari send() untuk endpoint /chatbot/ask
        return $this->send($request);
    }
}
