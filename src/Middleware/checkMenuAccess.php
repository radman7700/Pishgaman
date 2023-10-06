<?php

namespace Pishgaman\Pishgaman\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\Menu;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessLevel;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevelMenu;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessMenu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Pishgaman\Pishgaman\Repositories\LogRepository;

class CheckMenuAccess
{
    protected $logRepository;

    //بعدها به صورت تنظیمات اضافه شود
    protected $exceptFor = [
        'PAdminUsersApi_getUsers',
        'PAdminHistory_historylist'
    ];

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $currentRouteName = Route::getCurrentRoute()->getName();

        $message = $currentRouteName;
        if($request->action ?? false)
        {
            $message = $message . '_' . $request->action;
        }

        if ($user) {
            $currentUserAccessLevelId = $user->current_access_level_id;

            //در آپدیت بعدی تغییر خواهد کرد
            $currentRouteName = str_replace('Api', '', $currentRouteName);

            $menu = Menu::where('route', $currentRouteName)->first();

            if ($menu) {
                $menuId = $menu->id;

                $hasUserAccess = UserAccessLevel::where([
                    ['access_level_id', $currentUserAccessLevelId],
                    ['user_id', $user->id]
                ])->exists();

                $hasAccessMenu = AccessLevelMenu::where([
                    ['menu_id', $menuId],
                    ['access_level_id', $currentUserAccessLevelId]
                ])->exists();

                $hasUserAccessMenu = UserAccessMenu::where([
                    ['menu_id', $menuId],
                    ['user_id', $user->id]
                ])->exists();

                if (($hasUserAccess && $hasAccessMenu) || $hasUserAccessMenu) {
                    $isAccessible = true;
                    $executed = true;
                } else {
                    $isAccessible = false;
                    $executed = false;
                    Session::flash('error', 'شما دسترسی لازم برای این منو را ندارید.');
                    return redirect()->route('home');
                }
            } else {
                $isAccessible = false;
                $executed = false;
            }
        } else {
            $isAccessible = false;
            $executed = false;
        }

        $key = array_search($message, $this->exceptFor);
        if ($key === false) {
            // ایجاد رکورد لاگ با استفاده از ریپازیتوری LogRepository
            $LogID = $this->logRepository->createLog($message, $executed, $isAccessible);

            $request->merge(['logId' => $LogID->id]);
        }

        if ($isAccessible) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}
