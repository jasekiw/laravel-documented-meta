<?php


namespace LaravelDocumentedMeta\AttributeParsing;


use Closure;

/**
 * Class AttributeIterator
 * @package App\Lib\User\Meta\AttributeParsing
 */
class AttributeIterator
{
    /**
     * Parses a Meta Option config. The callack will be called for every option with it's namespace.
     *
     * @param array $attributes Map ["namespace" => [Option::class, "namespace_child" => [Option3::class] ], Option1::class ]
     * An Array that lays out the config that the iterator will parse.
     *
     * @param Closure $namespaceCallBack (string $namespace, Class $attributeClass) => ConstructedAttribute The callback will be called with the
     * following signature for each MetaOption.
     *
     * @return array The Constructed version of the attributes.
     */
    public function parse(array $attributes, Closure $namespaceCallBack) {
        return $this->iterate($attributes, '', $namespaceCallBack);
    }


    /**
     * A recursive fuction to iterate over the config.
     * @param array $attributes
     * @param string $parentNamespace
     * @param Closure $callback (string $namespace, Class<T> $attributeClass) => T
     * @return array
     */
    protected function iterate(array $attributes = [], string $parentNamespace = '', Closure $callback) {
        foreach ($attributes as $nameSpace => $nameSpaceOrAttribute) {
            if(is_array($nameSpaceOrAttribute))
                $attributes[$nameSpace] = $this->iterate($nameSpaceOrAttribute, $parentNamespace == '' ? $nameSpace :  $parentNamespace . "." . $nameSpace, $callback);
            else {
                $object = $callback($parentNamespace, $nameSpaceOrAttribute);
                $attributes[$nameSpace] = $object;
            }
        }
        return $attributes;
    }

}