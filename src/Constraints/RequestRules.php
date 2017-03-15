<?php

namespace Fesor\RequestObject\Constraints;

use Symfony\Component\Validator\Constraints\Composite;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class RequestRules extends Composite
{
    public $contexts;

    public function __construct($options)
    {
        // no known options set? $options is the fields array
        if (is_array($options)
            && !array_intersect(array_keys($options), array('groups', 'contexts'))) {
            $options = ['contexts' => $options];
        }

        $allowedContexts = ['cookies', 'files', 'query', 'request', 'headers', 'server', 'attributes', 'body'];
        if (!empty(array_diff(array_keys($options['contexts']), $allowedContexts))) {
            throw new \Exception('Unknown context');
        }

        parent::__construct($options);
    }

    protected function initializeNestedConstraints()
    {
        parent::initializeNestedConstraints();

        if (!is_array($this->contexts)) {
            throw new ConstraintDefinitionException(sprintf('The option "contexts" is expected to be an array in constraint %s', __CLASS__));
        }
    }


    protected function getCompositeOption()
    {
        return 'contexts';
    }
}
