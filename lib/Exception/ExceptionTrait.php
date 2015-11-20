<?php

/*
 * This file is part of the scribe/wonka-bundle.
 *
 * (c) Scribe Inc. <rmf@scr.be>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Exception;

use Scribe\Wonka\Utility\ClassInfo;

/**
 * Class ExceptionTrait.
 */
trait ExceptionTrait
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @return string
     */
    public function __toString()
    {
        $stringSet = [
            'type' => $this->getType(true),
            'msg'  => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
        ];

        return (string) print_r((array) $stringSet, true);
    }

    /**
     * @param null|string $message
     * @param mixed,...   $replaceSet
     *
     * @return string
     */
    public function getFinalMessage($message = null, ...$replaceSet)
    {
        $message = (string) (is_null_or_empty_string($message) ? $this->getDefaultMessage() : $message);

        return (string) (is_iterable_empty($replaceSet) ? $message : sprintf($message, ...$replaceSet));
    }

    /**
     * @param int|null $code
     *
     * @return int
     */
    public function getFinalCode($code = null)
    {
        return (int) ($code ? $code : $this->getDefaultCode());
    }

    /**
     * @param \Exception|ExceptionInterface $exception
     *
     * @return null|\Exception
     */
    public function getFinalPreviousException($exception = null)
    {
        return ($exception instanceof \Exception ? $exception : null);
    }

    /**
     * Get the default exception message.
     *
     * @return string
     */
    abstract public function getDefaultMessage();

    /**
     * Get the default exception code.
     *
     * @return int
     */
    abstract public function getDefaultCode();

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param mixed       $attribute
     * @param null|string $key
     *
     * @return $this
     */
    public function addAttribute($attribute, $key = null)
    {

        if (is_null_or_empty_string($key)) {
            $this->attributes[] = $attribute;
        } else {
            $this->attributes[(string) $key] = $attribute;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return (array) $this->attributes;
    }

    /**
     * @return array
     */
    public function getDebugOutput()
    {
        return (array) [
            'e'      => $this->getType(true),
            'msg'    => $this->getMessage(),
            'code'   => $this->getCode(),
            'attrbs' => $this->getAttributes(),
            'name'   => $this->getFile(),
            'line'   => $this->getLine(),
            'trace'  => $this->getTraceLimited(),
        ];
    }

    /**
     * @internal
     *
     * @return array
     */
    public function getTraceLimited()
    {
        $trace = (array) $this->getTrace();

        array_walk($trace, function (&$v, $i) {
            foreach ($v['args'] as &$arg) {
                if (is_object($arg)) { $arg = get_class($arg); }
            }
        });

        return (array) $trace;
    }

    /**
     * @param false|bool $fullyQualifiedName
     *
     * @return string
     */
    public function getType($fullyQualifiedName = false)
    {
        if (true === $fullyQualifiedName) {
            return (string) get_called_class();
        }

        return (string) ClassInfo::getClassName(get_called_class());
    }

    /**
     * @return string
     */
    abstract public function getMessage();

    /**
     * @return int
     */
    abstract public function getCode();

    /**
     * @return string
     */
    abstract public function getFile();

    /**
     * @return int
     */
    abstract public function getLine();

    /**
     * @return array
     */
    abstract public function getTrace();
}

/* EOF */
