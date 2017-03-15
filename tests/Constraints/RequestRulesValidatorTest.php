<?php

namespace Fesor\RequestObject\Tests\Constraints;

use Fesor\RequestObject\Constraints\RequestRules;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ValidatorBuilder;

class RequestRulesValidatorTest extends TestCase
{
    private $validator;
    private $emptyRequest;

    public function setUp()
    {
        $this->emptyRequest = Request::create('/example', 'POST', [], [], [], [], '');
        $this->validator = (new ValidatorBuilder())->getValidator();
    }

    /**
     * @param RequestRules $rules
     * @dataProvider parameterBagProvider
     */
    public function testValidatorChecksForErrors(RequestRules $rules)
    {
        $errors = $this->validator->validate($this->emptyRequest, $rules);

        self::assertCount(1, $errors);
    }

    public function testValidatorMayValidateMultipleContexts()
    {
        $constraint = new Collection([
            'foo' => new NotBlank(),
        ]);
        $rules = new RequestRules([
            'body' => new NotBlank(),
            'request' => $constraint,
            'query' => $constraint,
        ]);

        $errors = $this->validator->validate($this->emptyRequest, $rules);

        self::assertCount(3, $errors);
    }

    public function parameterBagProvider()
    {
        $constraint = new Collection([
            'foo' => new NotBlank(),
        ]);
        $constraint->allowExtraFields = true;

        return [
            [new RequestRules(['body' => new NotBlank()])],
            [new RequestRules(['request' => $constraint])],
            [new RequestRules(['query' => $constraint])],
            [new RequestRules(['server' => $constraint])],
            [new RequestRules(['headers' => $constraint])],
            [new RequestRules(['cookies' => $constraint])],
            [new RequestRules(['attributes' => $constraint])],
        ];
    }
}