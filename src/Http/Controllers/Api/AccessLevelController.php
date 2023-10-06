<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Api;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevel;
use Illuminate\Support\Facades\Log;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevelMenu;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\Menu;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessLevel;
use Pishgaman\Pishgaman\Repositories\LogRepository;
use Validator;

class AccessLevelController extends Controller
{
    private $validActions = [
        'getAccessLevel',
        'createAccessLevel',
        'updateAccessLevel',
        'deleteAccessLevel',
        'getAccessLevelMenus',
        'updateAccessLevelMenu',
        'getUserAccessLevel',
        'setOrRemoveAccessLevelUser'
    ];

    protected $validMethods = [
        'GET' => ['getAccessLevel', 'createAccessLevel','getAccessLevelMenus','getUserAccessLevel'], // Added 'createAccessLevel' as a valid method-action pair
        'POST' => ['createAccessLevel'], // Added 'createAccessLevel' as a valid action for POST method
        'PUT' => ['updateAccessLevel','updateAccessLevelMenu','setOrRemoveAccessLevelUser'],
        'DELETE' => ['deleteAccessLevel']
    ];

    protected $user;
    protected $logRepository;

    public function __construct(logRepository $logRepository)
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

    public function updateAccessLevelMenu(Request $request)
    {
        // Check if the action is valid and allowed.
        if (!$this->isValidAction('updateAccessLevelMenu', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate and sanitize the input data if needed.
        $validator = Validator::make($request->all(), [
            'menuId' => 'required',
            'accessLevelId' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $menuId = $request->input('menuId', 0);
        $accessLevelId = $request->input('accessLevelId', 0);
    
        // Check if the entry already exists.
        $existingEntry = AccessLevelMenu::where([
            ['menu_id', $menuId],
            ['access_level_id', $accessLevelId]
        ])->count();
    
        if ($existingEntry > 0) {
            // If the entry exists, delete it.
            AccessLevelMenu::where([
                ['menu_id', $menuId],
                ['access_level_id', $accessLevelId]
            ])->delete();
            if($request->logId ?? false)
            {
                $message = 'دسترسی به منو پاک شد';
                $message .= '<br>شناسه منو: ' . $menuId;
                $message .= '<br>شناسه سطح دسترسی: ' . $accessLevelId;
                $this->logRepository->updateLog($message, $request->logId);
            }            
        } else {
            // If the entry does not exist, create it.
            AccessLevelMenu::create([
                'menu_id' => $menuId,
                'access_level_id' => $accessLevelId
            ]);
            if($request->logId ?? false)
            {
                $message = 'دسترسی به منو اضافه شد';
                $message .= '<br>شناسه منو: ' . $menuId;
                $message .= '<br>شناسه سطح دسترسی: ' . $accessLevelId;
                $this->logRepository->updateLog($message, $request->logId);            
            }
        }
    
        return response()->json('Success text', 200);   
    }

    public function getUserAccessLevel(Request $request)
    {
        // Execute the getAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('getUserAccessLevel', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
        
        $UserAccessLevel = UserAccessLevel::where('user_id',$request->userId ?? 0)->get('access_level_id');
        return response()->json(['UserAccessLevel'=>$UserAccessLevel],200); 
    }
    
    public function setOrRemoveAccessLevelUser(Request $request)
    {
        // Execute the getAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('setOrRemoveAccessLevelUser', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
        
        $UserAccessLevel = UserAccessLevel::where([['user_id',$request->user_id ?? 0],['access_level_id',$request->accessLevelId]])->first();

        if($UserAccessLevel)
        {
            $UserAccessLevel->delete();

            if($request->logId ?? false)
            {
                $message = 'سطح دسترسی کاربر حذف شد';
                $message .= '<br>شناسه کاربر: ' . $request->user_id ?? 'خطا در دریافت';
                $message .= '<br>شناسه سطح دسترسی: ' . $request->accessLevelId;
                $this->logRepository->updateLog($message, $request->logId);            
            }            
        }
        else
        {
            $UserAccessLevel = new UserAccessLevel();
            $UserAccessLevel->user_id = $request->user_id ?? 0;
            $UserAccessLevel->access_level_id  = $request->accessLevelId ?? 0;
            $UserAccessLevel->save();

            if($request->logId ?? false)
            {
                $message = 'سطح دسترسی کاربر اضافه شد';
                $message .= '<br>شناسه کاربر: ' . $request->user_id ?? 'خطا در دریافت';
                $message .= '<br>شناسه سطح دسترسی: ' . $request->accessLevelId;
                $this->logRepository->updateLog($message, $request->logId);            
            }             
        }

        return response()->json(['UserAccessLevel'=>$UserAccessLevel],200); 
    }
    public function getAccessLevelMenus(Request $request)
    {
        // Execute the getAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('getAccessLevelMenus', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
        
        $AccessLevelMenu = AccessLevelMenu::where('access_level_id',$request->accessLevelId ?? 0)->get('menu_id');
        $menu = Menu::get();
        return response()->json(['menu'=>$menu,'AccessLevelMenu'=>$AccessLevelMenu],200); 
    }

    public function getAccessLevel(Request $request)
    {
        // Execute the getAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('getAccessLevel', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $accessLevels = AccessLevel::orderby('name');
        if($request->searchQuery)
        {
            $accessLevels = $accessLevels->where('name','like',"%".$request->searchQuery."%");
        }
        if($request->itemsPerPage == (-1))
        {
            $accessLevels = $accessLevels->get();
        }
        else if($request->itemsPerPage == 0)
        {
            $countAccessLevel = $accessLevels->count();
            $accessLevels = $accessLevels->paginate($countAccessLevel);
        }
        else
        {
            $accessLevels = $accessLevels->paginate($request->itemsPerPage ?? 10);
        }

        return response()->json($accessLevels);        
    }

    public function createAccessLevel(Request $request)
    {
        // Execute the createAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('createAccessLevel', 'POST')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $this->validate($request, [
            'accessLevelName' => 'required|string|max:255|unique:access_levels,name',
        ]);

        $newAccessLevel = AccessLevel::create([
            'name' => $request->accessLevelName,
        ]);

        if($request->logId ?? false)
        {
            $message = 'سطح دسترسی جدید ایجاد شد';
            $message .= '<br>شناسه سطح دسترسی: ' . $newAccessLevel->id;
            $this->logRepository->updateLog($message, $request->logId);            
        } 

        return response()->json(['message' => 'Access level created successfully', 'data' => $newAccessLevel], 201);
    }

    public function updateAccessLevel(Request $request)
    {
        // Execute the updateAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('updateAccessLevel', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate the request data (you can customize validation rules based on your needs)
        $this->validate($request, [
            'accessLevelId' => 'required|numeric', // Validation rule for accessLevelId
            'accessLevelName' => 'required|string|max:255',
            // Add more validation rules if needed
        ]);
    
        // Find the access level by ID
        $accessLevel = AccessLevel::find($request->accessLevelId);

        if($request->logId ?? false)
        {
            $message = 'سطح دسترسی جدید ایجاد شد';
            $message .= '<br>شناسه سطح دسترسی: ' . $request->accessLevelId;
            $message .= '<br>نام سطح دسترسی: ' . $accessLevel->name . '->' . $request->accessLevelName;
            $this->logRepository->updateLog($message, $request->logId);            
        } 

        // Check if the access level exists
        if (!$accessLevel) {
            return response()->json(['errors' => 'Access level not found'], 404);
        }
    
        // Update the access level using the validated data
        $accessLevel->name = $request->accessLevelName;
        $accessLevel->save();


        // Return a response indicating the success of the operation
        return response()->json(['message' => 'Access level updated successfully', 'data' => $accessLevel]);
    }
    
    public function deleteAccessLevel(Request $request)
    {
        // Execute the deleteAccessLevel method only if it is a valid action.
        if (!$this->isValidAction('deleteAccessLevel', 'DELETE')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate the request data (you can customize validation rules based on your needs)
        $this->validate($request, [
            'accessLevelId' => 'required|numeric', // Validation rule for accessLevelId
        ]);
    
        // Find the access level by ID
        $accessLevel = AccessLevel::find($request->accessLevelId);
    
        // Check if the access level exists
        if (!$accessLevel) {
            return response()->json(['errors' => 'Access level not found'], 404);
        }
    
        // Delete the access level
        $accessLevel->delete();
        if($request->logId ?? false)
        {
            $message = 'سطح دسترسی حذف شد';
            $message .= '<br>شناسه سطح دسترسی: ' . $request->accessLevelId;
            $this->logRepository->updateLog($message, $request->logId);            
        } 
        // Return a response indicating the success of the operation
        return response()->json(['message' => 'Access level deleted successfully']);
    }        
}
