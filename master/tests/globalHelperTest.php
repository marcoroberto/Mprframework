<?php
use PHPUnit\Framework\TestCase;

final class globalHelperTest extends TestCase
{
    public function testValidateEmail()
    {
        $value = 'marco.roberto@willistowerswatson.com';
        $email = \WTW\Helpers\globalHelper::validateEmail($value);
        $result = $email['valid'];
        $this->assertTrue($result);
    }

}
