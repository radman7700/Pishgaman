<?php

namespace Pishgaman\Pishgaman\Library\Theme;

/**
 * The ThemeStrategyInterface defines the contract for theme strategy classes.
 */
interface ThemeStrategyInterface {
    /**
     * Retrieves the name of the theme template based on the specified type.
     *
     * @param string $type The type of theme to retrieve.
     * @return string The name of the theme template.
     */
    public function getTemplateName(string $type): string;
}
