<?php 

namespace Pishgaman\Pishgaman\Repositories;

use Pishgaman\Pishgaman\Database\Models\AccessLevel\AccessLevelMenu;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\Menu;
class MenuRepository
{
    private $menu = [];
    public function getMenus()
    {
        $currentUser = auth()->user();

        $currentHeaderMenu = AccessLevelMenu::where('access_level_id', $currentUser->current_access_level_id)
        ->whereHas('menu', function ($query) {
            $query->where('type', 'like', 'header');
        })
        ->with('menu')
        ->get();

        foreach ($currentHeaderMenu as $header) {
            array_push($this->menu, $header->menu);
            $this->generateMenu($currentUser->current_access_level_id,$header);
        }

        return $this->menu;
    }

    public function generateMenu($current_access_level_id,$header)
    {
        $currentMenus = AccessLevelMenu::where('access_level_id', $current_access_level_id)
        ->whereHas('menu', function ($query) use ($header) {
            $query->where('parent_id', $header->menu_id);
        })
        ->with('menu')
        ->get();  

        foreach ($currentMenus as $value) {
            if($value->menu->type == 'dropdown' && $value->menu != null)
            {               
                $currentChildMenus = AccessLevelMenu::where('access_level_id', $current_access_level_id)
                ->whereHas('menu', function ($query) use ($value) {
                    $query->where('parent_id', $value->menu_id);
                })
                ->with('menu')
                ->get();
                $this->menu[$value->menu->name] = $currentChildMenus; 
            }
            else if($value->menu->type == '' && $value->menu != null)
            {
                array_push($this->menu, $value->menu);
            }            
        }          
    }

}
