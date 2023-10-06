<?php

namespace Pishgaman\Pishgaman\Library\Theme\ThemeStrategies;

use Pishgaman\Pishgaman\Library\Theme\ThemeStrategyInterface;
use Pishgaman\Pishgaman\Database\Models\Theme\Template;

/**
 * The LoginThemeStrategy class implements the ThemeStrategyInterface
 * and provides a strategy for getting the login theme template.
 */
class LoginThemeStrategy implements ThemeStrategyInterface {
    /**
     * Retrieves the name of the login theme template.
     *
     * @param string $type The type of theme to retrieve (not used in this strategy).
     * @return string The name of the login theme template.
     */
    public function getTemplateName(string $type): string {
        $Template = Template::where([['type', 'admin'], ['active', 1]])->first();
        return "Template.$Template->name.login";
    }
}
