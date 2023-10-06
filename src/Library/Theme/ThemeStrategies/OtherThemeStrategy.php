<?php

namespace Pishgaman\Pishgaman\Library\Theme\ThemeStrategies;

use Pishgaman\Pishgaman\Library\Theme\ThemeStrategyInterface;
use Pishgaman\Pishgaman\Database\Models\Theme\Template;

/**
 * The OtherThemeStrategy class implements the ThemeStrategyInterface
 * and provides a strategy for getting the theme template based on the type.
 */
class OtherThemeStrategy implements ThemeStrategyInterface {
    /**
     * Retrieves the name of the theme template based on the specified type.
     * If the type is 'login', it fetches the 'admin' template, otherwise, it fetches the specified type.
     *
     * @param string $type The type of theme to retrieve.
     * @return string The name of the theme template.
     */
    public function getTemplateName(string $type): string {
        $TemplateType = ($type == 'login') ? 'admin' : $type;
        $Template = Template::where([['type', $TemplateType], ['active', 1]])->first();

        if ($TemplateType == 'login') {
            return "Template.$Template->name.login";
        }

        return "Template.$Template->name.app";
    }
}
