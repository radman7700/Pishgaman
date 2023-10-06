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

class UsersController extends Controller
{
    private $validActions = [
        'getUsers',
        'createdUser',
        'updateUser',
        'softDeleteUser',
        'deleteUser',
        'restoreDeleteUser',
        'changePassword',
        'uploadUserProfile',
        'deleteUserProfile'
    ];

    protected $validMethods = [
        'GET' => ['getUsers'], 
        'POST' => ['createdUser','uploadUserProfile'], 
        'PUT' => ['updateUser','restoreDeleteUser','changePassword'],
        'DELETE' => ['softDeleteUser','deleteUser','deleteUserProfile']
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

    public function getUsers(Request $request)
    {
        // Execute the getUsers method only if it is a valid action.
        if (!$this->isValidAction('getUsers', 'GET')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        $Users = User::orderby('name')->withTrashed();
        if($request->searchQuery)
        {
            $Users = $Users->where('name','like',"%".$request->searchQuery."%");
        }

        if($request->itemsPerPage == 0)
        {
            $countAccessLevel = $Users->count();
            $Users = $Users->paginate($countAccessLevel);
        }
        else
        {
            $Users = $Users->paginate($request->itemsPerPage ?? 10);
        }

        return response()->json($Users);        
    }

    /**
     * Create a new user based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createdUser(Request $request)
    {
        // Validate the request and check its validity.
        if (!$this->isValidAction('createdUser', 'POST')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:255|regex:/^[a-zA-Z0-9_\-#.]+$/',
            'password' => 'required|string|min:8',
        ]);

        if($request->password != $request->confirm_password)
        {
            return response()->json(['errors' => 'isNotValidConfirmPassword'], 422);
        }

        // Get the 'is_active' value from the request
        $isActive = $request->input('is_active', false); 

        // Create a new user
        $user = User::create([
            'name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']), 
            'is_active' => $isActive ?? 0, 
        ]);

        $message = 'شناسه = ' . $user->id;
        $message .= '<br>نام کاربر = ' . $user->name;
        $message .= '<br>نام خانوادگی کاربر = ' . $user->last_name;
        $message .= '<br>رایانامه کاربر = ' . $user->email;
        $message .= '<br>نام کاربری کاربر = ' . $user->username;
        $message .= '<br>وضعیت کاربر = ' . ($user->is_active ? 'فعال' : 'غیر فعال');

        if($request->logId ?? false)
        {
            $this->logRepository->updateLog($message, $request->logId);
        }
        
        // Return a success message upon successful user creation
        return response()->json(['message' => 'New User created successfully'], 200);
    }

    /**
     * Update an existing user based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request)
    {
        // Validate the request and check its validity.
        if (!$this->isValidAction('updateUser', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
        // Check if a valid 'user_id' is provided
        if (($request->user_id ?? 0) == 0) {
            return response()->json(['errors' => 'InvalidUserId'], 422);
        }

        $id = $request->user_id;
        
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // اینجا می‌گوییم که ایمیل می‌تواند تکراری باشد اگر id کاربر مشخص شده باشد
            'username' => 'required|string|unique:users,username,' . $id, // همچنین نام کاربری هم می‌تواند تکراری باشد اگر id کاربر مشخص شده باشد
            'password' => 'nullable|string|min:8', // اینجا رمز عبور را اختیاری می‌کنیم
        ]);

        // Get the 'is_active' value from the request
        $isActive = $request->is_active ? 1 : 0; 
        // Find the user by id
        $user = User::findOrFail($id);

        $message = 'شناسه = ' . $id;
        $message .= '<br>نام کاربر = ' . $user->name;
        $message .= '<br>نام خانوادگی کاربر = ' . $user->last_name;
        $message .= '<br>رایانامه کاربر = ' . $user->email;
        $message .= '<br>نام کاربری کاربر = ' . $user->username;
        $message .= '<br>وضعیت کاربر = ' . ($user->is_active ? 'فعال' : 'غیر فعال');

        // Update the user's data
        $user->update([
            'name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'is_active' => $isActive, 
        ]);

        // Check if a new password is provided and update it if necessary
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($validatedData['password']), 
            ]);
        }

        if($request->logId ?? false)
        {
            $this->logRepository->updateLog($message, $request->logId);
        }

        // Return a success message upon successful user update
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function softDeleteUser(Request $request)
    {
        // Execute the softDeleteUser method only if it is a valid action.
        if (!$this->isValidAction('softDeleteUser', 'DELETE')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate the request data (you can customize validation rules based on your needs)
        $this->validate($request, [
            'userId' => 'required|numeric', // Validation rule for userId
        ]);
    
        // Find the User by ID
        $User = User::find($request->userId);

        $message = 'شناسه = ' . $request->userId;
        $message .= '<br>نام کاربری = ' . $User->username;

        // Check if the User exists
        if (!$User) {
            return response()->json(['errors' => 'User not found'], 422);
        }
    
        // Delete the User
        $User->delete();
    
        if($request->logId ?? false)
        {
            $this->logRepository->updateLog($message, $request->logId);
        }

        // Return a response indicating the success of the operation
        return response()->json(['message' => 'User deleted successfully']);
    }    

    public function deleteUser(Request $request)
    {
        // Execute the deleteUser method only if it is a valid action.
        if (!$this->isValidAction('deleteUser', 'DELETE')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate the request data (you can customize validation rules based on your needs)
        $this->validate($request, [
            'userId' => 'required|numeric', // Validation rule for userId
        ]);
    
        //remove user image profile
        $filePath = public_path('media/images/Users/Profile/'.$request->userId.'.png');
        if (file_exists($filePath)) {
            unlink($filePath);
        }       

        // Find the User by ID
        $User = User::withTrashed()->find($request->userId);
        
        $message = 'شناسه = ' . $request->userId;
        $message .= '<br>نام کاربری = ' . $User->username;

        // Check if the User exists
        if (!$User) {
            return response()->json(['errors' => 'User not found'], 422);
        }
    
        // Delete the User
        $User->forceDelete();
    
        if($request->logId ?? false)
        {
            $this->logRepository->updateLog($message, $request->logId);
        }

        // Return a response indicating the success of the operation
        return response()->json(['message' => 'User deleted successfully']);
    }
    public function restoreDeleteUser(Request $request)
    {
        // Execute the restoreDeleteUser method only if it is a valid action.
        if (!$this->isValidAction('restoreDeleteUser', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }
    
        // Validate the request data (you can customize validation rules based on your needs)
        $this->validate($request, [
            'userId' => 'required|numeric', // Validation rule for userId
        ]);
    
        // Find the User by ID
        $User = User::withTrashed()->find($request->userId);
        
        $message = 'شناسه = ' . $request->userId;
        $message .= '<br>نام کاربری = ' . $User->username;
        
        // Check if the User exists
        if (!$User) {
            return response()->json(['errors' => 'User not found'], 422);
        }
    
        // Delete the User
        $User->restore();
    
        if($request->logId ?? false)
        {
            $this->logRepository->updateLog($message, $request->logId);
        }

        // Return a response indicating the success of the operation
        return response()->json(['message' => 'User deleted successfully']);
    }    

    public function changePassword(Request $request)
    {
        // Execute the changePassword method only if it is a valid action.
        if (!$this->isValidAction('changePassword', 'PUT')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        } 

        $validatedData = $request->validate([
            'userId' => 'required',
            'password' => 'nullable|string|min:8', // اینجا رمز عبور را اختیاری می‌کنیم
        ]);        

        $user = User::findOrFail($request->userId);
        
        $message = 'شناسه = ' . $request->userId;
        $message .= '<br>نام کاربری = ' . $user->username;

        // Update the user's data
        $user->update([
            'password' => bcrypt($validatedData['password']), 
        ]);
    
        if($request->logId ?? false)
        {
            $this->logRepository->updateLog($message, $request->logId);
        }

        // Return a response indicating the success of the operation
        return response()->json(['message' => 'User password change successfully']);                
    }

    public function deleteUserProfile(Request $request)
    {
        // Execute the changePassword method only if it is a valid action.
        if (!$this->isValidAction('deleteUserProfile', 'DELETE')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        } 

        $filePath = public_path('media/images/Users/Profile/'.$request->user_id.'.png');

        if (file_exists($filePath)) {
            unlink($filePath);

            $user = User::findOrFail($request->user_id);
        
            $message = 'شناسه = ' . $request->user_id;
            $message .= '<br>نام کاربری = ' . $user->username;

            if($request->logId ?? false)
            {
                $this->logRepository->updateLog($message, $request->logId);
            }

            return response()->json(['errors' => 'File deleted successfully'], 200);
        } else {
            return response()->json(['errors' => 'FileNotFound'], 422);
        }        
    }

    public function uploadUserProfile(Request $request)
    {
        // Execute the changePassword method only if it is a valid action.
        if (!$this->isValidAction('uploadUserProfile', 'POST')) {
            return response()->json(['errors' => 'requestNotAllowed'], 422);
        }       
        
        $user = User::find($request->userId);
        if (!$user) {
            return response()->json(['errors' => 'UserNotFound'], 422);
        } 

        // اگر تصویر ارسال شده صحیح باشد، آن را ذخیره کنید
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // دریافت تصویر ارسال شده
            $image = $request->file('image');

            // تعیین مسیر ذخیره تصویر (معمولا در پوشه‌ی اپلودها)
            $uploadPath = public_path('media/images/Users/Profile');

            // ایجاد نام مناسب برای تصویر (به صورت یکتا)
            $imageName = $request->userId . '.png';

            // ذخیره تصویر در مسیر مشخص شده با نام جدید
            $image->move($uploadPath, $imageName);

        
            $message = 'شناسه = ' . $request->user_id;
            $message .= '<br>نام کاربری = ' . $user->username;

            if($request->logId ?? false)
            {
                $this->logRepository->updateLog($message, $request->logId);
            }

            // پاسخ به موفقیت آمیز بودن آپلود
            return response()->json(['message' => 'تصویر پروفایل با موفقیت آپلود شد']);
        }

        // در صورت وجود مشکل در آپلود تصویر
        return response()->json(['error' => 'مشکلی در آپلود تصویر پروفایل به وجود آمده است'], 422);       
    }

        
}
