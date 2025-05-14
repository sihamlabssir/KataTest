<?php

namespace Service;

use PHPUnit\Framework\TestCase;
use Entity\Template;

class TemplateManagerTest extends TestCase
{
    public function testGetTemplateComputedReplacesTextCorrectly()
    {
        $template = new Template(
            1,
            'Subject with [quote:destination_name]',
            'Hello [user:first_name], welcome to [quote:destination_name]'
        );

        $data = ['quote' => 'dummyQuote', 'user' => 'dummyUser'];

        $quoteDecorator = $this->createMock(QuoteTextDecorator::class);
        $userDecorator = $this->createMock(UserTextDecorator::class);

        $quoteDecorator->method('decorate')->willReturnCallback(function ($text) {
            return str_replace('[quote:destination_name]', 'IDF', $text);
        });

        $userDecorator->method('decorate')->willReturnCallback(function ($text) {
            return str_replace('[user:first_name]', 'John', $text);
        });

        $manager = new TemplateManager($quoteDecorator, $userDecorator);
        $result = $manager->getTemplateComputed($template, $data);

        $this->assertEquals('Subject with IDF', $result->subject);
        $this->assertEquals('Hello John, welcome to IDF', $result->content);
    }
}
