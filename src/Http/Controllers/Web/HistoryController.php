<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use Pishgaman\Pishgaman\Library\Theme\ThemeManager;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\LoginThemeStrategy;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\OtherThemeStrategy;
use Pishgaman\Pishgaman\Middleware\CheckMenuAccess;
class HistoryController extends Controller
{
    // Valid and safe actions that can be executed
    private $validActions = [
        'historylist',
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

    public function historylist(Request $request)
    {
        if (!$this->isValidAction('historylist')) {
            return abort(404);
        }

        $mix = ['packages/pishgaman/pishgaman/src/resources/vue/History/app.js'];
        $card = 'لیست تاریخچه فعالیت';

        return view('PishgamanView::History.historylist',compact('mix','card'));
    }
}
