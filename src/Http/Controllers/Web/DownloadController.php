<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pishgaman\Pishgaman\Repositories\downloadRepository;
use Pishgaman\Pishgaman\Database\Models\Download;

class DownloadController extends Controller
{
    public function downloadList()
    {
        $mix = ['Packages/pishgaman/Pishgaman/src/Resources/vue/download/downloadApp.js'];
        return view('PishgamanView::Dashboard.Download',['mix'=>$mix]);
    }

    public function download(Request $request, downloadRepository $downloadRepository)
    {
        $user = Download::findOrFail($request->id);
        $user->read = 1;
        $user->save();

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
