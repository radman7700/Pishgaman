<?php

namespace Pishgaman\Pishgaman\Library\Theme;

use Pishgaman\Pishgaman\Library\Theme\ThemeStrategyInterface;

/**
 * The ThemeManager class utilizes the Strategy pattern to manage themes.
 */
class ThemeManager {
    private $strategy;

    /**
     * Constructor to initialize the ThemeManager with a given strategy.
     *
     * @param ThemeStrategyInterface $strategy The strategy to be used for theme management.
     */
    public function __construct(ThemeStrategyInterface $strategy) {
        $this->strategy = $strategy;
    }

    /**
     * Setter method to change the current strategy used for theme management.
     *
     * @param ThemeStrategyInterface $strategy The new strategy to be used.
     */
    public function setStrategy(ThemeStrategyInterface $strategy) {
        $this->strategy = $strategy;
    }

    /**
     * Returns the name of the theme template based on the specified type using the current strategy.
     * If an error occurs during the process, a default template name is returned.
     *
     * @param string $type The type of theme to retrieve.
     * @return string The name of the theme template.
     */
    public function getTheme(string $type): string {
        try {
            return $this->strategy->getTemplateName($type);
        } catch (\Throwable $th) {
            return 'Template.Default.app';
        }
    }
}
