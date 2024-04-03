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

    /**
     * Controller function to handle actions.
     */
    public function action(Request $request)
    {
        if ($request->has('action')) {
            $functionName = $request->action;
            if ($this->isValidAction($functionName)) {
                return $this->$functionName($request);
            }

            return abort(404);
        } else {
            return $this->home($request);
        }
    }

    /**
     * Validate the requested action name.
     */
    private function isValidAction($functionName)
    {
        return in_array($functionName, $this->validActions);
    }

    /**
     * Handle the "home" action.
     */
    public function home(Request $request)
    {
        // Execute the "home" method only if it is a valid action.
        if (!$this->isValidAction('home')) {
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
