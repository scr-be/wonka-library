<?php

/*
 * This file is part of the `src-run/wonka-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 * (c) Scribe Inc      <scr@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Wonka\Utility\System\Execute;

use SR\Wonka\Exception\RuntimeException;

/**
 * Class Command.
 */
class Command extends AbstractCommand
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @param string $command
     *
     * @return $this
     */
    public function setCommand($command)
    {
        $this->command = (string) $command;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommand()
    {
        return (string) $this->command;
    }

    /**
     * @return $this
     */
    public function run()
    {
        @exec($this->sanitizeAndGetCommand(), $output, $return);

        $this
            ->sanitizeAndSetOutput($output)
            ->sanitizeAndSetReturn($return);

        return $this;
    }

    /**
     * @return string
     */
    protected function sanitizeAndGetCommand()
    {
        if ($this->command === null) {
            throw new RuntimeException('Cannot run an empty command in "%s".', __METHOD__);
        }

        return sprintf('%s -c \'%s\' %s', (string) $this->shell, (string) $this->command,
            ($this->stdErrToNull === true ? '2> /dev/null' : '2>&1'));
    }
}

/* EOF */
