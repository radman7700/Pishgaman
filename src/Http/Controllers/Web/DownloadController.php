<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pishgaman\Pishgaman\Repositories\downloadRepository;

class DownloadController extends Controller
{
    public function download(Request $request,downloadRepository $downloadRepository)
    {
        return Storage::download('app\public\download\5\telegram_users_231204110154.csv');

        switch ($request->type) {
            case 'telegram_users':
            {
                $options = [
                    'conditions' => [
                        [
                            'column' => 'id',
                            'operator' => '=',
                            'value' => $request->id,
                        ],
                    ],
                    'get'=>true
                ];
                $downloadList = $downloadRepository->Get($options);
                $downloadList = $downloadList->first();
                return Storage::download('app/'.$downloadList->file_path);
                break;
            }

        }
    }
}
