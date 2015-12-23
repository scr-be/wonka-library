<?php

/*
 * This file is part of the Wonka Library.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace {

    /**
     * @param string      $application
     * @param string|null $framework
     *
     * @return bool
     */
    function extensionEnableNewRelic($application, $framework = null)
    {
        if (!extension_loaded('newrelic') || !function_exists('newrelic_set_appname')) {
            return false;
        }

        newrelic_set_appname($application);

        if (notNullOrEmpty($framework)) {
            ini_set('newrelic.framework', $framework);
        }

        return true;
    }
}

/* EOF */
