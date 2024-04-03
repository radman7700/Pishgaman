<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Api;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevel;
use Illuminate\Support\Facades\Log;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevelMenu;
use Pishgaman\Pishgaman\Database\Models\User\User;
use Pishgaman\Pishgaman\Repositories\LogRepository;
use Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $validActions = [
        'getCurrentUser',
        'upatePassword'
    ];

    protected $validMethods = [
        'GET' => ['getCurrentUser'], 
        'POST' => [], 
        'PUT' => ['upatePassword'],
        'DELETE' => []
    ];

    protected $user;
    protected $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
        $this->middleware(CheckMenuAccess::class);
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

    public function getCurrentUser()
    {
        if (!$this->isValidAction('getCurrentUser', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $CurrentUser = auth()->user();

        return response()->json(['CurrentUser'=>$CurrentUser]);        
    }
        
    public function upatePassword($request)
    {

        if (!$this->isValidAction('upatePassword', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $CurrentUser = auth()->user();

        $validatedData = $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);  

        $validCredentials = Hash::check($validatedData['current_password'] , $CurrentUser->password);
        if(!$validCredentials)
        {
            $message = 'رمز عبور فعلی صحیح نمی‌باشد';            
            return response()->json(['errors' => $message], 422);
        }

        $validCredentials = Hash::check($validatedData['password'] , $CurrentUser->password);
        if(!$validCredentials)
        {
            $CurrentUser->update([
                'password' => bcrypt($validatedData['password']), 
            ]);
            return response()->json(['message'=>'کلمه عبور شما با موفقیت به روز شد']);
        }else{
            $message = 'رمز عبور جدید نباید با رمز فعلی یکسان باشد';
            
            return response()->json(['errors' => $message], 422);
        }
    }      
}
