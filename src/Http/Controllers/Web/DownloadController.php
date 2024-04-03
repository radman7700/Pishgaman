<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pishgaman\Pishgaman\Repositories\downloadRepository;

class DownloadController extends Controller
{
    public function download(Request $request, downloadRepository $downloadRepository)
    {
        $options = [
            'conditions' => [
                [
                    'column' => 'id',
                    'operator' => '=',
                    'value' => $request->id,
                ],
            ],
            'get' => true
        ];
        $downloadList = $downloadRepository->Get($options);
        $downloadList = $downloadList->first();
    
        // استفاده از تابع response()->download()
        return response()->download(
            storage_path('app/public/' . $downloadList->file_path),
            $downloadList->file_name,
            [],
            'inline'
        );
    }
}
