<?php

namespace LaravelDocumentedMeta\Attribute\Validators;

class FloatValidator
{
    public function validate($attribute, $value, $parameters, $validator) {
        return
            is_float($value) ||
            is_numeric($value);
    }
}