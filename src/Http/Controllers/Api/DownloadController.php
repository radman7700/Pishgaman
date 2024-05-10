<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Api;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevel;
use Illuminate\Support\Facades\Log;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevelMenu;
use Pishgaman\Pishgaman\Database\Models\User\User;
use Pishgaman\Pishgaman\Repositories\LogRepository;
use Pishgaman\Pishgaman\Repositories\downloadRepository;
use Validator;

class DownloadController extends Controller
{
    private $validActions = [
        'getList',
    ];

    protected $validMethods = [
        'GET' => ['getList'], 
        'POST' => [], 
        'PUT' => [],
        'DELETE' => []
    ];

    protected $user;
    protected $logRepository;
    protected $downloadRepository;

    public function __construct(LogRepository $logRepository,downloadRepository $downloadRepository)
    {
        $this->logRepository = $logRepository;
        $this->downloadRepository = $downloadRepository;
        $this->user = auth()->user();
    }

    public function action(Request $request)
    {
        if ($request->has('action')) {
            $functionName = $request->action;
            $method = $request->method();
            if ($this->isValidAction($functionName, $method)) {
                return $this->$functionName($request);
            } else {
                return response()->json(['errors' => 'requestNotAllowed'], 422);
            }
        }

        return abort(404);
    }

    private function isValidAction($functionName, $method)
    {
        return in_array($functionName, $this->validActions) && in_array($functionName, $this->validMethods[$method]);
    }

    public function getList(Request $request)
    {
        if (!$this->isValidAction('getList', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $options = [
            'sortings' => [
                ['column' => 'created_at', 'order' => 'desc'],
            ],
            'get' => false,
            'take'=>4
        ];
        $downloadList = $this->downloadRepository->Get($options);
        return response()->json(['downloadList'=>$downloadList]);        
    }
        
}
