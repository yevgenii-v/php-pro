<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileDownloadController extends Controller
{
    public function index(string $file): BinaryFileResponse
    {
        return response()->download(storage_path('logs/') . $file);
    }
}
