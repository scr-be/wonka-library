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

namespace Scribe\Wonka\Exception;

use Scribe\Wonka\Utility\ClassInfo;

/**
 * Class ExceptionTrait.
 */
trait ExceptionTrait
{
    /**
     * @var mixed[]
     */
    protected $attributes;

    /**
     * @param string|null            $message    Message string (see {@see:$parameters} to send values that
     *                                           will be passed to sprintf.
     * @param \Throwable|mixed[],... $parameters Additional parameters are fed to {@see sprintf} as
     *                                           replacements for the message provided. Additionally,
     *                                           a previous exception can be passed as the last parameter
     *                                           and it will be pop'd off the replacements and assigned.
     */
    final public function __construct($message = null, ...$parameters)
    {
        list($previous, $replacements) = $this->parseParameters($parameters);

        parent::__construct(
            $this->getFinalMessage((string) $message, ...$replacements),
            $this->getFinalCode(ExceptionInterface::CODE_GENERIC),
            $this->getFinalPrevious($previous)
        );

        $this->setAttributes([]);
    }

    /**
     * @param string|null $message
     * @param mixed,...   $replacements
     *
     * @return static
     */
    public static function create($message = null, ...$replacements)
    {
        return new static($message, ...$replacements);
    }

    /**
     * @param mixed,... ...$parameters
     *
     * @return $this
     */
    public function with(...$parameters)
    {
        list($previous, $replacements) = $this->parseParameters($parameters);

        if (!isNullOrEmpty($previous)) {
            $this->setPrevious($previous);
        }

        if (!isCountableEmpty($replacements)) {
            $this->setMessage($this->getMessage(), ...$replacements);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $stringSet = [
            'type' => $this->getType(true),
            'msg' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
        ];

        return (string) print_r((array) $stringSet, true);
    }

    /**
     * @param ExceptionInterface[]|mixed[] $parameters
     *
     * @return ExceptionInterface[]|array[]
     */
    protected function parseParameters(array $parameters = [])
    {
        $previous = null;
        $replaces = array_filter($parameters, function ($v) use (&$previous) {
            if ($v instanceof \Throwable || $v instanceof \Exception) {
                $previous = $v;

                return false;
            }

            return true;
        });

        return [ $previous, $replaces ];
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
     * @return \Exception|null
     */
    abstract public function getPrevious();

    /**
     * @return array
     */
    abstract public function getTrace();

    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return ExceptionInterface::MSG_GENERIC;
    }

    /**
     * @return int
     */
    public function getDefaultCode()
    {
        return ExceptionInterface::CODE_GENERIC;
    }

    /**
     * @param string    $message
     * @param mixed,... $replacements
     *
     * @return $this
     */
    public function setMessage($message, ...$replacements)
    {
        $this->message = $this->getFinalMessage($message, ...$replacements);

        return $this;
    }

    /**
     * @param int $code
     *
     * @return $this
     */
    public function setCode($code = null)
    {
        $this->code = $this->getFinalCode($code);

        return $this;
    }

    /**
     * @param string|\SplFileInfo $file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $this->getFinalFile($file);

        return $this;
    }

    /**
     * @param int $line
     *
     * @return $this
     */
    public function setLine($line)
    {
        $this->line = $this->getFinalLine($line);

        return $this;
    }

    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    public function setPrevious(\Exception $exception)
    {
        $this->__construct($this->getMessage(), $exception);

        return $this;
    }

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
     * @return mixed[]
     */
    public function getAttributes()
    {
        return (array) $this->attributes;
    }

    /**
     * @param mixed           $attribute
     * @param null|string|int $index
     *
     * @return $this
     */
    public function addAttribute($attribute, $index = null)
    {
        if (isNullOrEmpty($index)) {
            $this->attributes[] = $attribute;

            return $this;
        }

        $this->attributes[$index] = $attribute;

        return $this;
    }

    /**
     * @param string $index
     *
     * @return null|mixed
     */
    public function getAttribute($index)
    {
        if (isNullOrEmpty($index) || !$this->hasAttribute($index)) {
            return;
        }

        return $this->attributes[$index];
    }

    /**
     * @param string $index
     *
     * @return bool
     */
    public function hasAttribute($index)
    {
        return (bool) (isNullOrEmpty($index) || isset($this->attributes[$index]));
    }

    /**
     * @return array
     */
    public function getDebugOutput()
    {
        return (array) [
            'e' => $this->getType(true),
            'msg' => $this->getMessage(),
            'code' => $this->getCode(),
            'attrbs' => $this->getAttributes(),
            'name' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTraceLimited(),
        ];
    }

    /**
     * @return array
     */
    public function getTraceLimited()
    {
        $trace = (array) $this->getTrace();

        array_walk($trace, function (&$v, $i) {
            foreach ($v['args'] as &$arg) {
                if (is_object($arg)) {
                    $arg = get_class($arg);
                }
            }
        });

        return (array) $trace;
    }

    /**
     * @param false|bool $fQCN
     *
     * @return string
     */
    public function getType($fqcn = false)
    {
        $called = get_called_class();

        return $fqcn === true ? $called : ClassInfo::getClassName($called);
    }

    /**
     * @param null|string $message
     * @param mixed,...   $replacements
     *
     * @internal
     *
     * @return string
     */
    protected function getFinalMessage($message = null, ...$replacements)
    {
        if (isNullOrEmpty($message)) {
            $message = $this->getDefaultMessage();
        }

        return isCountableEmpty($replacements) ? $message : @sprintf($message, ...$replacements);
    }

    /**
     * @param int|null $code
     *
     * @internal
     *
     * @return int
     */
    protected function getFinalCode($code = null)
    {
        return (int) ($code ? $code : $this->getDefaultCode());
    }

    /**
     * @param string|\SplFileInfo $file
     *
     * @internal
     *
     * @return string|null
     */
    protected function getFinalFile($file)
    {
        if ($file instanceof \SplFileInfo) {
            return $file->getPathname();
        }

        return notNullOrEmpty($file) ? $file : null;
    }

    /**
     * @param int $line
     *
     * @default
     *
     * @return int|null
     */
    protected function getFinalLine($line)
    {
        return is_int($line) ? $line : null;
    }

    /**
     * @param null|\Exception|\Throwable $e
     *
     * @internal
     *
     * @return null|\Exception|\Throwable
     */
    protected function getFinalPrevious($e = null)
    {
        return ($e instanceof \Throwable || $e instanceof \Exception) ? $e : null;
    }
}

/* EOF */
