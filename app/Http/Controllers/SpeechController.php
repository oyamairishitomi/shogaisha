<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpeechController extends Controller
{
    public function transcribe(Request $request) {
        $file = $request->file('audio');
        // フロントから送られたオーディオを取得

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->attach(
            'file', file_get_contents($file->getRealPath()), 'audio.webm'
        )->post('https://api.openai.com/v1/audio/transcriptions', [
            'model' => 'whisper-1',
            'language' => 'ja',
        ]);

        return response()->json(['text' => $response->json('text')]);
        // return response()->json($response->json());

    }
}
