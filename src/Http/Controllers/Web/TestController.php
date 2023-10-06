<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Library\Theme\ThemeManager;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\LoginThemeStrategy;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\OtherThemeStrategy;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;
class TestController extends Controller
{
    // Valid and safe actions that can be executed
    private $validActions = [
        'test',
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
    public function test(Request $request)
    {
        // Execute the test method only if it is a valid action.
        if (!$this->isValidAction('test')) {
            return abort(404);
        }

        $currentUser = $this->user;

        // Validate inputs.
        $loginStrategy = new LoginThemeStrategy();
        $otherStrategy = new OtherThemeStrategy();
        $themeManager = new ThemeManager($otherStrategy);
        $theme = $themeManager->getTheme('Admin');
        return view('PishgamanView::test.test',compact('currentUser'));


    }
}
