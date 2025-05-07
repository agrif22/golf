<?php

use App\Models\GolfParticipant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});

Route::get('/preview/{uuid}', function ($uuid) {
    $participant = GolfParticipant::where('uuid', $uuid)->firstOrFail();

    if (!$participant->document_path || !Storage::disk('public')->exists($participant->document_path)) {
        abort(404, 'Dokumen tidak ditemukan.');
    }

    $path = Storage::disk('public')->path($participant->document_path);

    return Response::make(file_get_contents($path), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
})->name('golf.preview');
