<?php

namespace Service;

use Entity\Quote;
use PHPUnit\Framework\TestCase;
use Repository\DestinationRepository;
use Repository\QuoteRepository;
use Repository\SiteRepository;


class QuoteTextDecoratorTest extends TestCase
{
    private $siteRepository;
    private $quoteRepository;

    private $destinationRepository;

    private $quoteRenderer;
    protected function setUp()
    {
        $this->quoteRepository = $this->createMock(QuoteRepository::class);
        $this->siteRepository = $this->createMock(SiteRepository::class);
        $this->destinationRepository = $this->createMock(DestinationRepository::class);
        $this->quoteRenderer = new QuoteRenderer();
    }
    public function testDecorateWithPlaceholders()
    {
        $quote = new Quote(123, 1, 2, '2023-01-01');
        $site = (object)['url' => 'https://example.com'];
        $destination = (object)['countryName' => 'France'];
        $_quote = $quote;

        $this->quoteRepository->method('getById')->willReturn($_quote);
        $this->siteRepository->method('getById')->willReturn($site);
        $this->destinationRepository->method('getById')->willReturn($destination);

        $decorator = new QuoteTextDecorator(
            $this->quoteRepository,
            $this->siteRepository,
            $this->destinationRepository,
            $this->quoteRenderer
        );

        $text = 'Summary: [quote:summary], HTML: [quote:summary_html], Destination: [quote:destination_name], Link: [quote:destination_link]';

        $result = $decorator->decorate($text, ['quote' => $quote]);

        $this->assertContains('123', $result);
        $this->assertContains('<p>123</p>', $result);
        $this->assertContains('France', $result);
        $this->assertContains('https://example.com/France/quote/123', $result);
    }

    public function testDecorateWithoutQuote()
    {
        $decorator = new QuoteTextDecorator(
            $this->quoteRepository,
            $this->siteRepository,
            $this->destinationRepository,
            $this->quoteRenderer
        );

        $text = 'Hello world';
        $result = $decorator->decorate($text, []);

        $this->assertEquals('Hello world', $result);
    }
}
