<?php

namespace Fesor\RequestObject;

use Symfony\Component\Validator\Constraint;

interface ValidationRules
{
    /**
     * Returns constrains for request
     *
     * In other case any symfony/validator compatible constraints could be
     * returned. This constraints will be applied to request payload.
     *
     * If method return null then it will mean that request payload
     * does not have any constraints.
     *
     * @return Constraint|Constraint[]|null
     */
    public function rules();
}