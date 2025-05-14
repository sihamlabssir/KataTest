<?php

namespace Service;

use Context\ApplicationContext;
use Entity\User;
use PHPUnit\Framework\TestCase;

class UserTextDecoratorTest extends TestCase
{
    private $applicationContext;
    private $userTextDecorator;

    protected function setUp()
    {
        $this->applicationContext = $this->createMock(ApplicationContext::class);
        $this->userTextDecorator = new UserTextDecorator($this->applicationContext);
    }

    public function testDecorateWithContextUser()
    {
        $user = new User(
            1,
            'John',
            'TEST',
            'john.test@gmail.com'
        );

        $this->applicationContext->method('getCurrentUser')->willReturn($user);

        $text = 'Hello [user:first_name]!';

        $decoratedText = $this->userTextDecorator->decorate($text, ['user' => $user]);
        $this->assertEquals('Hello John!', $decoratedText);
    }

    public function testDecorateWithContextNoUser()
    {
        $text = 'Hello [user:first_name]!';
        $this->applicationContext->method('getCurrentUser')->willReturn(null);

        $decoratedText = $this->userTextDecorator->decorate($text, []);
        $this->assertEquals('Hello [user:first_name]!', $decoratedText);
    }

    public function testDecorateWithNoPlaceholder()
    {
        $text = 'Hello World!';

        $decoratedText = $this->userTextDecorator->decorate($text, []);
        $this->assertEquals('Hello World!', $decoratedText);
    }
}