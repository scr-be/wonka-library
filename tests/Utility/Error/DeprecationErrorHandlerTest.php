<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Tests\Utility\Error;

use Scribe\Wonka\Utility\Error\DeprecationErrorHandler;
use Scribe\Wonka\Utility\UnitTest\WonkaTestCase;

/**
 * Class DeprecationErrorHandlerTest.
 */
class DeprecationErrorHandlerTest extends WonkaTestCase
{
    public function testTriggerDeprecationErrorWithDatetime()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated on "Sat, 10 Oct 2015 [0-9]{2}:00:00 \+0400" and will be removed on "Mon, 10 Oct 2016 [0-9]{2}:00:00 \+0400"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', new \DateTime('2015-10-10 04:00 +0400'), new \DateTime('2016-10-10 04:00 +0400'));
    }

    public function testTriggerDeprecationErrorWithStringDates()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated on "Sat, 10 Oct 2015 [0-9]{2}:00:00 [+-][0-9]{4}" and will be removed on "Mon, 10 Oct 2016 [0-9]{2}:00:00 [+-][0-9]{4}"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', '2015-10-10 04:00', '2016-10-10 04:00');
    }

    public function testTriggerDeprecationErrorWithStringDatesWithTimezone()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated on "Sat, 10 Oct 2015 [0-9]{2}:00:00 \-0300" and will be removed on "Mon, 10 Oct 2016 [0-9]{2}:00:00 \+0300"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', '2015-10-10 05:00:00 -0300', '2016-10-10 11:00:00 +0300');
    }

    public function testTriggerDeprecationErrorWithStringDatesWithInvalidTimezone()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated on "Sat, 10 Oct 2015 [0-9]{2}:00:00 [+-][0-9]{4}" and will be removed on "Mon, 10 Oct 2016 [0-9]{2}:00:00 [+-][0-9]{4}"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', '2015-10-10 04:00', '2016-10-10 04:00');
    }

    public function testTriggerDeprecationErrorWithStringDatesWithInvalidTimezone2()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated on "Sat, 10 Oct 2015 [0-9]{2}:00:00 [+-][0-9]{4}" and will be removed on "Mon, 10 Oct 2016 [0-9]{2}:00:00 [+-][0-9]{4}"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', '2015-10-10 04:00:00 +0000', '2016-10-10 04:00:00 +0000');
    }

    public function testTriggerDeprecationErrorWithStringVersions()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated in version "v2" and will be removed in version "v3"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', 'v2', 'v3');
    }

    public function testTriggerDeprecationErrorWithStringVersionAndDatetimeMixed()
    {
        $this->setExpectedExceptionRegExp('\PHPUnit_Framework_Error',
            '{.+A deprecation message\. This feature was deprecated on "Sat, 10 Oct 2015 [0-9]{2}:00:00 [+-][0-9]{4}" and will be removed in version "v3"\..+}');
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'A deprecation message.', new \DateTime('2015-10-10 04:00 +0400'), 'v3');
    }

}

/* EOF */