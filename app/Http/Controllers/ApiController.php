<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function searchText(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:10|max:300',
            'abstract' => 'required|string|min:10|max:6000',
            'top_n' => 'required|integer|min:1|max:4712',
        ]);

        return view(
            'app',
            [
                'result' => Http::get(env("SCIENTIA_API_URL") . '/find_similar?' . http_build_query($request->only('title', 'abstract', 'top_n')))->json(),
                'checked' => 'text'
            ],
        );
    }

    public function searchPdf(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'top_n' => 'required|integer'
        ]);

        $fileContent = file_get_contents($request->file('file')->getRealPath());

        return view(
            'app',
            [
                'result' => Http::attach(
                    'file',
                    $fileContent,
                    'file'
                )->post(env("SCIENTIA_API_URL") . '/find_similar_pdf', [
                    'top_n' => $request->input('top_n')
                ])->json(),
                'checked' => 'pdf',
                'base64File' => base64_encode($fileContent),
            ],
        );
    }
}
