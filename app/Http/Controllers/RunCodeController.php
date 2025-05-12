<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RunCodeController extends Controller
{
    public function execute(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'source' => 'required|string',
            'stdin' => 'nullable|string',
        ]);

        // Map bahasa input ke format yang dikenali oleh API Piston
        $language = $this->mapLanguage($request->language);
        
        // Buat payload yang benar untuk API Piston
        $payload = [
            'language' => $language,
            'version' => $this->getLanguageVersion($language),
            'files' => [
                [
                    'name' => 'main.' . $this->getFileExtension($language),
                    'content' => $request->source
                ]
            ],
            'stdin' => $request->stdin ?? '',
            'args' => []
        ];
        
        // Log untuk debug
        Log::info('Mengirim request ke Piston API', ['payload' => $payload]);

        try {
            // Kirim request ke API Piston
            $response = Http::timeout(20)
                ->post('https://emkc.org/api/v2/piston/execute', $payload);
            
            Log::info('Response dari Piston API', ['response' => $response->json()]);
            
            if ($response->successful()) {
                $result = $response->json();
                
                // Format respons untuk klien
                return response()->json([
                    'stdout' => $result['run']['stdout'] ?? '',
                    'stderr' => $result['run']['stderr'] ?? '',
                    'code' => $result['run']['code'] ?? null,
                    'output' => $result['run']['output'] ?? $result['run']['stdout'] ?? '',
                    'error' => $result['message'] ?? ''
                ]);
            } else {
                // Log error
                Log::error('Piston API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json([
                    'error' => 'Eksekusi kode gagal',
                    'details' => $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Log exception
            Log::error('Exception saat menghubungi Piston API', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Memetakan nama bahasa input ke format yang didukung API
     */
    private function mapLanguage($language)
    {
        $languageMap = [
            'cpp' => 'c++',
            'c' => 'c',
            'python3' => 'python',
            'python' => 'python',
            'javascript' => 'javascript',
            'js' => 'javascript',
            'java' => 'java',
            'php' => 'php',
            'go' => 'go',
            'golang' => 'go',
            'ruby' => 'ruby',
            'rb' => 'ruby',
            'rust' => 'rust',
            'rs' => 'rust',
            'csharp' => 'csharp',
            'c#' => 'csharp',
            'cs' => 'csharp',
            'typescript' => 'typescript',
            'ts' => 'typescript'
        ];
        
        return $languageMap[$language] ?? $language;
    }
    
    /**
     * Mendapatkan ekstensi file berdasarkan bahasa pemrograman
     */
    private function getFileExtension($language)
    {
        $extensions = [
            'c++' => 'cpp',
            'c' => 'c',
            'python' => 'py',
            'javascript' => 'js',
            'java' => 'java',
            'php' => 'php',
            'go' => 'go',
            'ruby' => 'rb',
            'rust' => 'rs',
            'csharp' => 'cs',
            'typescript' => 'ts'
        ];
        
        return $extensions[$language] ?? $language;
    }
    
    /**
     * Mendapatkan versi bahasa yang tepat untuk API Piston
     * berdasarkan daftar runtime yang tersedia
     */
    private function getLanguageVersion($language)
    {
        // Versi yang didukung oleh Piston API (dari daftar runtimes)
        $versions = [
            'c++' => '10.2.0',
            'c' => '10.2.0',
            'python' => '3.10.0',
            'javascript' => '18.15.0', // Menggunakan Node.js runtime
            'java' => '15.0.2',
            'php' => '8.2.3',
            'go' => '1.16.2',
            'ruby' => '3.0.1',
            'rust' => '1.68.2',
            'csharp' => '6.12.0', // Menggunakan Mono runtime
            'typescript' => '5.0.3'
        ];
        
        return $versions[$language] ?? '0';
    }
}