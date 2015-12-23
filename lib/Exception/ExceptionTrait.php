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
use Scribe\Wonka\Utility\Error\DeprecationErrorHandler;

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
     * @param string|null $message      Message string (see later {@see:$replacements} parameter replacement support)
     * @param int|null    $code         The error code. Default is {@see ExceptionInterface::CODE_GENERIC}
     * @param \Exception  $previous     The previous exception, if applicable
     * @param mixed,...   $replacements Additional parameters are fed to {@see sprintf} against the message string
     */
    public function __construct($message = null, $code = null, \Exception $previous = null, ...$replacements)
    {
        parent::__construct(
            $this->getFinalMessage((string) $message, ...$replacements),
            $this->getFinalCode((int) $code),
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
        return new static($message, null, null, ...$replacements);
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
    abstract public function getDefaultMessage();

    /**
     * @return int
     */
    abstract public function getDefaultCode();

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
        $this->__construct($this->getMessage(), $this->getCode(), $this->getFinalPrevious($exception));

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
    public function getType($fQCN = false)
    {
        $called = get_called_class();

        return $fQCN ? $called : ClassInfo::getClassName($called);
    }

    /**
     * @param null|string $message
     * @param mixed,...   $replacements
     *
     * @internal
     *
     * @return string
     */
    public function getFinalMessage($message = null, ...$replacements)
    {
        if (isNullOrEmpty($message)) {
            return;
        }

        if (count($replacements) === 0) {
            return $message;
        }

        return sprintf($message, ...$replacements);
    }

    /**
     * @param int|null $code
     *
     * @internal
     *
     * @return int
     */
    public function getFinalCode($code = null)
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
     * @param \Exception $exception
     *
     * @internal
     *
     * @return null|\Exception
     */
    public function getFinalPrevious(\Exception $exception = null)
    {
        return $exception;
    }

    /**
     * @param mixed $exception
     *
     * @internal
     *
     * @return null|\Exception
     */
    public function getFinalPreviousException($exception = null)
    {
        DeprecationErrorHandler::trigger(__METHOD__, __LINE__, 'Use getFinalPrevious instead.', '2015-12-14 10:00 -0400', '0.3');

        return $this->getFinalPrevious($exception);
    }
}

/* EOF */
