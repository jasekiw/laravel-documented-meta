<?php


namespace LaravelDocumentedMeta\AttributeParsing;


use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Config
 * @package App\Lib\User\Meta\AttributeParsing
 */
class Config implements Arrayable
{
    /**
     * @var array
     */
    protected $configArray;

    /**
     * Config constructor.
     * @param $configArray
     */
    public function __construct(array $configArray)
    {
        $this->configArray = $configArray;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (new AttributeIterator())->parse($this->configArray, function ($namespace, $object) {
            /** @var Arrayable $object*/
            return $object->toArray();
        });

    }
}