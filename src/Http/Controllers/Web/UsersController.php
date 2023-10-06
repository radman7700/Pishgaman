<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;

class UsersController extends Controller
{
    // Valid and safe actions that can be executed
    private $validActions = [
        'Users',
        // 'other_action',  // Add other safe actions here
    ];

    protected $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(CheckMenuAccess::class);
        $this->user = auth()->user();
    }

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
        }

        return abort(404);
    }

    /**
     * Validate the requested action name.
     */
    private function isValidAction($functionName)
    {
        return in_array($functionName, $this->validActions);
    }

    /**
     * Test method with added security measures.
     */
    public function Users(Request $request)
    {
        // Execute the test method only if it is a valid action.
        if (!$this->isValidAction('Users')) {
            return abort(404);
        }
        
        $mix = ['packages/pishgaman/pishgaman/src/resources/vue/Users/app.js'];
        $card = 'لیست کاربران سایت';

        return view('PishgamanView::Users.Users',['mix' => $mix,'card' => $card]);
    }
}
