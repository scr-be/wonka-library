<?php

/*
 * This file is part of the Wonka Bundle.
 *
 * (c) Scribe Inc.     <oss@src.run>
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Wonka\Serializer;

/**
 * Class AbstractSerializer.
 */
class AbstractSerializer implements SerializerInterface
{
    /**
     * @var callable|\Closure
     */
    protected $serializationHandler;

    /**
     * @var callable|\Closure
     */
    protected $unSerializationHandler;

    /**
     * @return SerializerInterface
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @param mixed|null    $data
     * @param \Closure|null $visitor
     *
     * @return mixed
     */
    public function serializeData($data = null, \Closure $visitor = null)
    {
        if (is_callable($visitor)) {
            $data = $visitor($data);
        }

        return call_user_func($this->serializationHandler, $data);
    }

    /**
     * @param mixed|null    $data
     * @param \Closure|null $visitor
     *
     * @return mixed
     */
    public function unSerializeData($data = null, \Closure $visitor = null)
    {
        $data = call_user_func($this->unSerializationHandler, $data);

        return is_callable($visitor) ? $visitor($data) : $data;
    }
}

/* EOF */
