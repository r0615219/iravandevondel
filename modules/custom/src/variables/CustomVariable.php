<?php
/**
 * Custom module for Craft CMS 3.x
 *
 * Some cool functions here
 *
 * @link      http://carolineboeykens.be
 * @copyright Copyright (c) 2018 Caroline Boeykens
 */

namespace modules\custom\variables;

use modules\custom\Custom;

use Craft;

/**
 * Custom Variable
 *
 * Craft allows modules to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.custom }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Caroline Boeykens
 * @package   Custom
 * @since     1.0.0
 */
class CustomVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.custom.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.custom.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
