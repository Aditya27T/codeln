<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RunCodeController extends Controller
{
    public function execute(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'source' => 'required|string',
            'stdin' => 'nullable|string',
        ]);

        $payload = [
            'language' => $request->language,
            'source' => $request->source,
            'stdin' => $request->stdin ?? '',
        ];

        $response = Http::timeout(20)->post('https://emkc.org/api/v2/piston/execute', $payload);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json([
                'error' => 'Execution failed',
                'details' => $response->body()
            ], 500);
        }
    }
}
