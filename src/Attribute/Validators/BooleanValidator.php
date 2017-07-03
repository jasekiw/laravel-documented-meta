<?php

namespace LaravelDocumentedMeta\Attribute\Validators;

class BooleanValidator
{
    public function validate($attribute, $value, $parameters, $validator) {
        return
            strtolower($value) === 'true' ||
            strtolower($value) === 'false' ||
            $value === true ||
            $value === false ||
            $value === 1 ||
            $value === 0 ||
            $value === '1' ||
            $value === '0';
    }
}