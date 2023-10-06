<?php 

namespace Pishgaman\Pishgaman\Middleware;

use Closure;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevel;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessLevel;
use Pishgaman\Pishgaman\Repositories\MenuRepository;
class PrepareUserData
{
    public function handle($request, Closure $next)
    {
        $currentUser = auth()->user();

        if ($currentUser) {

            $UserAccessLevel = UserAccessLevel::where([
                ['user_id', $currentUser->id],
                ['access_level_id', '<>', $currentUser->current_access_level_id]
            ])->with('AccessLevel')->get();

            $currentAccessLevel = AccessLevel::where('id',$currentUser->current_access_level_id)->first();
            // اضافه کردن داده‌های منطقی به ویو
            view()->share('currentUser', $currentUser);
            view()->share('currentAccessLevel', $currentAccessLevel);
            view()->share('accessLevels', $UserAccessLevel);

            $menuRepository = new MenuRepository();
            $menus = $menuRepository->getMenus();
            view()->share('sidebar', $menus);

        }


        return $next($request);
    }
}
