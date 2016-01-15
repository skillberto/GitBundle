<?php

namespace Skillberto\GitBundle\Tests\Validation;

use Skillberto\GitBundle\Validation\TagValidator;
use Skillberto\GitBundle\Validation\ValidatorInterface;

class TagValidatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var ValidatorInterface */
    protected $validator;

    protected function setUp()
    {
        $this->validator = new TagValidator();
    }

    public function testValidData()
    {
        $this->assertTrue($this->validator->isValid('1.0'));
        $this->assertTrue($this->validator->isValid('1.0.1'));
        $this->assertTrue($this->validator->isValid('123.312.112'));

        $this->assertTrue($this->validator->isValid('v1.0'));
        $this->assertTrue($this->validator->isValid('v1.0.1'));
        $this->assertTrue($this->validator->isValid('v123.12.123'));
    }

    public function testInvalidData()
    {
        $this->assertFalse($this->validator->isValid(''));
        $this->assertFalse($this->validator->isValid('1.'));
        $this->assertFalse($this->validator->isValid('1,2'));
        $this->assertFalse($this->validator->isValid('1.c'));
        $this->assertFalse($this->validator->isValid('1.2.'));
        $this->assertFalse($this->validator->isValid('1.2.c'));
        $this->assertFalse($this->validator->isValid('1.2.4.'));
        $this->assertFalse($this->validator->isValid('1.2.3.4'));
        $this->assertFalse($this->validator->isValid('va1.2.3'));
        $this->assertFalse($this->validator->isValid('av1.2.3'));
        $this->assertFalse($this->validator->isValid('ava1.2.3'));
    }
}