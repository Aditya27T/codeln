<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalyzeCodeController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'question' => 'required|string',
            'reference' => 'nullable|string',
            'language' => 'required|string',
        ]);

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Gemini API key not set.'], 500);
        }

        $prompt = "Soal: " . $request->question . "\n\n" .
                  "Kode user:\n" . $request->code . "\n\n";
        if ($request->reference) {
            $prompt .= "Kode referensi (jawaban benar):\n" . $request->reference . "\n\n";
        }
        $prompt .= "\nTolong analisis kode user, bandingkan dengan jawaban referensi (jika ada), beri penilaian, dan saran perbaikan jika ada. Jawab dalam bahasa Indonesia dan ringkas. Fokus pada kesesuaian solusi dengan soal, efisiensi, dan best practice.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful() && isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'feedback' => $response['candidates'][0]['content']['parts'][0]['text']
            ]);
        } else {
            return response()->json([
                'error' => 'Gagal mendapatkan saran dari Gemini.',
                'details' => $response->body()
            ], 500);
        }
    }
}
