<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function chat()
    {
        return view('home');
    }

    public function ask(Request $request)
    {
        $question = $request->input('question');

        if (!$question) {
            return response()->json([
                'error' => 'Question tidak boleh kosong'
            ], 400);
        }

        try {
            $endpoint = 'https://cloud.flowiseai.com/api/v1/prediction/24e550f9-bf74-47e3-a582-f246cc1aa866';

            $response = Http::withHeaders([
                'Authorization' => 'Bearer h9G36lxYVJ5MUo-xcmZ26IniYS1euEDUD1LMi-cTUVs',
                'Content-Type' => 'application/json'
            ])
            ->timeout(180)
            ->connectTimeout(30)
            ->post($endpoint, [
                "question" => $question
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Flowise returned error',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            }

            $data = $response->json();

            $answer = $data['text']
                ?? $data['answer']
                ?? $data['output']
                ?? $data['message']
                ?? json_encode($data);

            return response()->json([
                'success' => true,
                'answer' => $answer,
                'raw_response' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Chat error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
