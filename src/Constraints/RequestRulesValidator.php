<?php

namespace Fesor\RequestObject\Constraints;

use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RequestRulesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof RequestRules) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Context');
        }

        if (!$value instanceof Request) {
            // todo: throw exception
            return;
        }

        $context = $this->context;

        foreach ($constraint->contexts as $property => $rules) {
            if ($property === 'body') {
                $contextValue = $value->getContent();
            } else {
                $contextValue = $value->$property->all();
            }

            $context
                ->getValidator()
                ->inContext($context)
                ->atPath($property)
                ->validate($contextValue, $rules);
        }
    }
}