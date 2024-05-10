<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;

class messagesController extends Controller
{
    // Valid and safe actions that can be executed
    private $validActions = [
        'departments',
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
     * Validate the requested action name.
     */
    private function isValidAction($functionName)
    {
        return in_array($functionName, $this->validActions);
    }

    /**
     * Test method with added security measures.
     */
    public function Messages(Request $request)
    {
        // Execute the test method only if it is a valid action.
        if (!$this->isValidAction('Messages')) {
            return abort(404);
        }
        
        $mix = ['packages/pishgaman/pishgaman/src/resources/vue/Messages/app.js'];

        return view('PishgamanView::Messages.Messages',['mix' => $mix]);
    }
}
