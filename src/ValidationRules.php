<?php

namespace Fesor\RequestObject;

use Symfony\Component\Validator\Constraint;

interface ValidationRules
{
    /**
     * Returns constrains for request payload
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

    /**
     * Returns validation groups to be used in validation
     *
     * In some cases you may want to use context-depending validation.
     * symfony/validator provides groups to make it possible. So this
     * method could be used to select correct groups basing on
     * request payload.
     *
     * @param array $payload
     * @return null|array of validation groups
     */
    public function validationGroup(array $payload);
}