<?php


namespace LaravelDocumentedMeta\Tests;

/**
 * Class ArrayUtil
 * @package App\Lib\Arrays
 */
class ArrayUtil
{
    /**
     * Computes the difference in two recursive arrays
     * @param   array $aArray1 The first array to compare
     * @param   array $aArray2
     * @return  array The difference array
     * @see http://stackoverflow.com/questions/3876435/recursive-array-diff
     */
    public function arrayRecursiveDiff(array $aArray1, array $aArray2) {
        $aReturn = [];
        foreach ($aArray1 as $key => $value)
        {
            if (array_key_exists($key, $aArray2)) {
                if (is_array($value)) {
                    $aRecursiveDiff = $this->arrayRecursiveDiff($value, $aArray2[$key]);
                    if (count($aRecursiveDiff))
                        $aReturn[$key] = $aRecursiveDiff;
                } else if ($value != $aArray2[$key])
                    $aReturn[$key] = $value;
            } else
                $aReturn[$key] = $value;
        }
        return $aReturn;
    }
}