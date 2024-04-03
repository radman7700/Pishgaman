<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Pishgaman\CyberspaceMonitoring\Database\models\TelegramMessage;
class HomeController extends Controller
{
    // Valid and safe actions that can be executed
    private $validActions = [
        'home',
        'logout',
        'profile'
        // 'other_action',  // Add other safe actions here
    ];

    protected $validMethods = [
        'GET' => ['home','logout','profile'], 
        'POST' => [], 
        'PUT' => [],
        'DELETE' => []
    ];

    /**
     * Controller function to handle actions.
     */
    public function action(Request $request)
    {
        if ($request->has('action')) {
            $functionName = $request->action;
            $method = $request->method();
            if ($this->isValidAction($functionName, $method)) {
                return $this->$functionName($request);
            }
    
            return abort(404);
        } else {
            return $this->home($request);
        }

        return abort(404);
    }


    /**
     * Validate the requested action name.
     */
    private function isValidAction($functionName, $method)
    {
        return in_array($functionName, $this->validActions) && in_array($functionName, $this->validMethods[$method]);
    }

    /**
     * Handle the "home" action.
     */
    public function home(Request $request)
    {
        if (!$this->isValidAction('home', 'GET')) {
            return abort(404);
        }

        $mix = ['packages/pishgaman/WorkReport/src/resources/vue/HomeApp.js'];

        return view('PishgamanView::Dashboard.Home',['mix'=>$mix ]);
    }

    public function logout(Request $request)
    {
        if (!$this->isValidAction('logout', 'GET')) {
            return abort(404);
        } 

        auth()->logout();
        return redirect('/');
    }

    public function profile(Request $request)
    {
        if (!$this->isValidAction('profile', 'GET')) {
            return abort(404);
        } 

        $mix = ['packages/pishgaman/pishgaman/src/resources/vue/Users/template/ChangeTemplate/profile.js'];

        return view('PishgamanView::Users.Profile',['mix'=>$mix]);
    }    
}
