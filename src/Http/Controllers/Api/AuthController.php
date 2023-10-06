<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pishgaman\Pishgaman\Database\Models\user\User;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $Log;

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function action(Request $request)
    {
        // Check if the 'action' parameter exists in the request
        if ($request->has('action')) {
            $functionName = $request->action;

            // Check if the action is allowed
            if (method_exists($this, $functionName) && $this->isActionAllowed($functionName)) {
                return $this->$functionName($request);
            } else {
                // Return a 404 response if the action is not allowed
                return abort(404);
            }
        } else {
            // Return a 404 response if the 'action' parameter is missing
            return abort(404);
        }
    }

    /**
     * Check if the action is allowed.
     *
     * @param string $action
     * @return bool
     */
    private function isActionAllowed($action)
    {
        $allowedActions = [
            'loginCheck',
            // Add other allowed actions here
        ];

        return in_array($action, $allowedActions);
    }

    /**
     * Check user credentials for login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function loginCheck(Request $request)
    {
        // تعداد تلاش‌های قبلی کاربر برای ورود به سیستم
        $attempts = Session::get('login_attempts', 0);
        if($attempts ?? false)
        {
            Session::put('login_attempts', 0);
        }

        // تعداد مجاز تلاش‌های ناموفق برای ورود
        $maxAttempts = 5;
    
        // زمانی که کاربر باید بلاک شود (5 دقیقه)
        $blockTime = Carbon::now()->addMinutes(5);
    
        // Check if the input is an email or a username
        $column = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Find the user by email or username
        $user = User::where($column, $request->username)->first();
        
        if($user)
        {
            // اگر حساب کاربری بلاک شده است و زمان رهایی از بلاک کمتر یا مساوی حال حاضر است
            if (($user->is_blocked ?? false) && $user->blocked_until > Carbon::now()) {
                $blockedUntil = $user->blocked_until;
                $now = Carbon::now();
                $diffInMinutes = round($now->diffInSeconds($blockedUntil) / 60);         
                return response()->json(['errors' => 'حساب کاربری شما بلاک شده است. لطفاً ' . $blockedUntil . ' بعد مجدداً اقدام به ورود نمایید.'], 422);
            }
            else if(($user->is_blocked ?? false) && $user->blocked_until <= Carbon::now())
            {
                // اگر کاربر بلاک شده بود اینجا می‌توانیم آن را آن‌بلاک کنیم
                if (($user->is_blocked ?? false)) {
                    $user->is_blocked = false;
                    $user->blocked_until = null;
                    $user->save();
                }   
                
                Session::put('login_attempts', 0);
            }

            if ($attempts >= $maxAttempts) {
                // اگر تعداد تلاش‌ها بیشتر مساوی تعداد مجاز تلاش‌ها شد، کاربر باید بلاک شود
                $user->is_blocked = true;
                $user->blocked_until = $blockTime;
                $user->save();
                $blockedUntil = $user->blocked_until;
                $now = Carbon::now();
                $diffInMinutes = round($now->diffInSeconds($blockedUntil) / 60);         
                return response()->json(['errors' => 'حساب کاربری شما بلاک شده است. لطفاً تا ' . $blockedUntil . ' دقیقه مجدداً اقدام به ورود نمایید.'], 422);
            }

            // Check if the user exists and the password is correct
            if ($user && Hash::check($request->password, $user->password)) {
        
                // Attempt to log in the user
                if (Auth::attempt([$column => $request->username, 'password' => $request->password])) {
                    $loggedInUser = auth()->user();
        
                    // Set the user's current access level in the session
                    if ($loggedInUser->current_access_level_id > 0) {
                        session(['myAccessLevel' => $loggedInUser->current_access_level_id]);
                    } else {
                        $accessLevel = UserAccessLevel::where('user_id', $loggedInUser->id)->first();
                        session(['myAccessLevel' => $accessLevel->access_level_id ?? null]);
                        $loggedInUser->current_access_level_id = $accessLevel->access_level_id ?? null;
                        $loggedInUser->save();
                    }
        
                    $token = $user->createToken('token_name')->plainTextToken;
                    $request->session()->put('api_token', $token);

                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                } else {
                    // اگر تلاش ناموفق بود، تعداد تلاش‌ها را یکی زیاد کنیم
                    Session::put('login_attempts', $attempts + 1);
                    return response()->json(['errors' => 'اطلاعات ورود اشتباه است'], 422);
                }
            } else {
                // اگر تلاش ناموفق بود، تعداد تلاش‌ها را یکی زیاد کنیم
                Session::put('login_attempts', $attempts + 1);            
                return response()->json(['errors' => 'اطلاعات ورود اشتباه است'], 422);
            }
        }
        else
        {
            return response()->json(['errors' => 'اطلاعات ورود اشتباه است'], 422);
        }
    }    
}
