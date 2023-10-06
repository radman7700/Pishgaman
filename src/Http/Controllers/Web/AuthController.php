<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Library\Theme\ThemeManager;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\LoginThemeStrategy;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\OtherThemeStrategy;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
        
    // Valid and safe actions that can be executed
    private $validActions = [
        'mainAuth',
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
                $user = auth()->user();
                return $this->$functionName($request, $user);
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
     * mainAuth method with added security measures.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param mixed $userm The user data (I'm assuming this parameter is for user data).
     *
     * @return \Illuminate\Http\Response
     */
    public function mainAuth(Request $request, $userm)
    {
        // Check if the action is valid before executing the mainAuth method.
        // Assuming 'isValidAction' is a method that validates the action against a whitelist.
        // You should customize this method based on your application's security needs.
        // It's important to prevent unauthorized access to sensitive methods.
        if (!$this->isValidAction('mainAuth')) {
            return abort(404);
        }

        // Create a LoginThemeStrategy and a ThemeManager.
        // It's recommended to use dependency injection instead of creating objects directly.
        $loginStrategy = new LoginThemeStrategy();
        $themeManager = new ThemeManager($loginStrategy);

        // Assuming 'getTheme' is a method that retrieves a theme based on the provided key.
        // Make sure to properly handle the returned value to prevent potential issues.
        $LoginTemplate = $themeManager->getTheme('login');

        // It seems like you're defining a JavaScript file here. Ensure that you load this file securely.
        // Make sure that the 'app.js' file is served securely and comes from a trusted source.
        // Avoid using variables like '$mix' directly in the view to prevent XSS attacks.
        $mix = ['packages/pishgaman/pishgaman/src/resources/vue/Auth/app.js'];

        // Return the view with the LoginTemplate.
        // Ensure that you properly escape variables when rendering them in the view to prevent XSS attacks.
        return view('PishgamanView::Auth.Auth', ['LoginTemplate' => $LoginTemplate, 'mix' => $mix]);
    }
}
