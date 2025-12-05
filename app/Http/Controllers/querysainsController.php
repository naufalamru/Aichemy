<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class querysainsController extends Controller
{
    public function query()
    {
        return view('querysains'); // halaman dashboard setelah login
    }
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required'
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer h9G36lxYVJ5MUo-xcmZ26IniYS1euEDUD1LMi-cTUVs',
                'Content-Type' => 'application/json'
            ])
            ->withOptions([
                'verify' => false,
                'timeout' => 120,
                'connect_timeout' => 30
            ])
            ->post(
                'https://cloud.flowiseai.com/api/v1/prediction/24e550f9-bf74-47e3-a582-f246cc1aa866',
                [
                    // Flowise Cloud expects EXACTLY this:
                    'question' => $request->question
                ]
            );

            // kalau Flowise balikin error -> kirim balik ke FE
            if ($response->failed()) {
                return response()->json([
                    'flowise_error' => $response->body()
                ], 500);
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
