<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalyzeCodeController extends Controller
{
    public function analyze(Request $request)
    {
        // Validasi input
        $request->validate([
            'code' => 'required|string',
            'question' => 'required|string',
            'reference' => 'nullable|string',
            'language' => 'required|string',
        ]);

        // Ambil API Key dari file .env
        $apiKey = env('GEMINI_API_KEY'); // Pastikan sudah ditambahkan di .env
        if (!$apiKey) {
            return response()->json(['error' => 'Gemini API key not set.'], 500);
        }

        // Persiapkan prompt untuk analisis kode
        $prompt = "Soal: " . $request->question . "\n\n" .
                  "Kode user:\n" . $request->code . "\n\n";
        if ($request->reference) {
            $prompt .= "Kode referensi (jawaban benar):\n" . $request->reference . "\n\n";
        }
        $prompt .= "\nTolong analisis kode user, bandingkan dengan jawaban referensi (jika ada), beri penilaian, dan saran perbaikan jika ada. Jawab dalam bahasa Indonesia dan ringkas. Fokus pada kesesuaian solusi dengan soal, efisiensi, dan best practice.";

        try {
            // Kirim permintaan ke API Gemini
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', [
                'instances' => [
                    [
                        'prompt' => $prompt,
                        'temperature' => 0.5,  // Sesuaikan sesuai kebutuhan
                        'max_output_tokens' => 1000,  // Sesuaikan sesuai kebutuhan
                    ]
                ]
            ]);

            // Jika permintaan berhasil, kembalikan feedback
            if ($response->successful() && isset($response['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json([
                    'feedback' => $response['candidates'][0]['content']['parts'][0]['text']
                ]);
            } else {
                // Catat error jika respons tidak sesuai
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                return response()->json([
                    'error' => 'Gagal mendapatkan saran dari Gemini.',
                    'details' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            // Tangani exception dan catat error
            Log::error('Error during API request: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }
}
