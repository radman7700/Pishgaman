<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Api;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Database\Models\Log\Log;

class HistoryController extends Controller
{
    private $validActions = [
        'getHistoies',
    ];

    protected $validMethods = [
        'GET' => ['getHistoies'], // Added 'createAccessLevel' as a valid method-action pair
        'POST' => [], // Added 'createAccessLevel' as a valid action for POST method
        'PUT' => [],
        'DELETE' => []
    ];

    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function action(Request $request)
    {
        if ($request->has('action')) {
            $functionName = $request->action;
            $method = $request->method();
            // Log::error('method: ' . $method);
            // Log::error('functionName: ' . $functionName);

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

    public function getHistoies(Request $request)
    {
        // Execute the getAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('getHistoies', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $Logs = Log::with('user')->orderby('created_at','desc');
        if($request->searchQuery)
        {
            // $Logs = $Logs->where('name','like',"%".$request->searchQuery."%");
        }
        if($request->itemsPerPage == (-1))
        {
            $Logs = $Logs->get();
        }
        else if($request->itemsPerPage == 0)
        {
            $countLogs = $Logs->count();
            $Logs = $Logs->paginate($countLogs);
        }
        else
        {
            $Logs = $Logs->paginate($request->itemsPerPage ?? 10);
        }

        return response()->json($Logs);        
    }      
}
