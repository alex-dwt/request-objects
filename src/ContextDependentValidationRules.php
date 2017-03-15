<?php

namespace Fesor\RequestObject;

use Symfony\Component\HttpFoundation\Request;

interface ContextDependentValidationRules extends ValidationRules
{
    /**
     * Returns validation groups to be used in validation
     *
     * In some cases you may want to use context-depending validation.
     * symfony/validator provides groups to make it possible. So this
     * method could be used to select correct groups basing on
     * request payload.
     *
     * @param Request $request
     * @return null|array of validation groups
     */
    public function validationGroup(Request $request);
}