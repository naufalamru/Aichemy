<?php

namespace App\Http\Controllers;

use App\Models\QueryHistory;
use App\Models\QueryMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class querysainsController extends Controller
{
    // Menampilkan halaman pertanyaan
    public function query()
    {
        return view('querysains');
    }

    // Fungsi untuk mengirim pertanyaan ke Flowise
    public function ask(Request $request)
    {
        // Validasi input
        $request->validate([
            'question' => 'required|string',
            'history_id' => 'nullable|integer'
        ]);

        $question = $request->question;
        $historyId = $request->history_id;

        // Cari atau buat history baru
        if ($historyId) {
            $history = QueryHistory::where('id', $historyId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$history) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'History tidak ditemukan atau tidak milik user ini'
                ], 403);
            }
        } else {
            $history = QueryHistory::create([
                'user_id' => Auth::id(),
                'title' => substr($question, 0, 50) // Ambil 50 karakter pertama sebagai title
            ]);
        }

        // Simpan pesan user
        QueryMessage::create([
            'history_id' => $history->id,
            'sender' => 'user',
            'content' => $question
        ]);

        try {
            // Tambahkan instruksi bahasa Indonesia ke prompt
            // Format: System instruction + User question
            $questionWithLanguage = "Anda adalah asisten AI yang ahli dalam skincare dan bahan aktif. Selalu jawab dalam Bahasa Indonesia dengan jelas, terstruktur, dan mudah dipahami. Gunakan format markdown untuk membuat jawaban lebih rapi.\n\nPertanyaan: " . $question;

            // Request ke Flowise Cloud (sesuai format API Flowise)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->withOptions([
                'verify' => false,
                'timeout' => 120,
                'connect_timeout' => 30
            ])
            ->post(
                'https://cloud.flowiseai.com/api/v1/prediction/ce27d92c-1a73-4132-9f41-68cd90767399',
                [
                    'question' => $questionWithLanguage
                ]
            );

            // Jika API Flowise error
            if ($response->failed()) {
                $errorMessage = "⚠️ Error: Flowise API error";

                // Simpan error sebagai pesan bot
                QueryMessage::create([
                    'history_id' => $history->id,
                    'sender' => 'bot',
                    'content' => $errorMessage
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Flowise API error',
                    'details' => $response->body(),
                    'answer' => $errorMessage,
                    'history_id' => $history->id
                ], 500);
            }

            // Ambil response dari Flowise
            $data = $response->json();
            $answer = $data['text'] ?? $data['answer'] ?? (is_string($data) ? $data : json_encode($data));

            // Simpan jawaban bot
            QueryMessage::create([
                'history_id' => $history->id,
                'sender' => 'bot',
                'content' => $answer
            ]);

            // Update timestamp history supaya daftar history terurut terbaru
            $history->touch();

            return response()->json([
                'status' => 'success',
                'answer' => $answer,
                'text' => $answer, // untuk kompatibilitas dengan frontend
                'history_id' => $history->id
            ]);

        } catch (\Exception $e) {
            $errorMessage = "⚠️ Error: " . $e->getMessage();

            // Simpan error sebagai pesan bot
            QueryMessage::create([
                'history_id' => $history->id,
                'sender' => 'bot',
                'content' => $errorMessage
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'details' => $e->getMessage(),
                'answer' => $errorMessage,
                'history_id' => $history->id
            ], 500);
        }
    }

    // ============================
    // LOAD ALL USER HISTORY
    // ============================
    public function histories()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json([
                    'error' => 'User tidak terautentikasi',
                    'authenticated' => false
                ], 401);
            }

            $histories = QueryHistory::where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json($histories);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memuat history: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================
    // LOAD MESSAGES BY HISTORY
    // ============================
    public function messages($id)
    {
        $history = QueryHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$history) {
            return response()->json([
                'error' => 'History tidak ditemukan atau tidak milik user ini'
            ], 403);
        }

        $messages = QueryMessage::where('history_id', $id)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }
}
