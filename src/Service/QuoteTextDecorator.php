<?php

namespace Service;

use Repository\DestinationRepository;
use Repository\QuoteRepository;
use Repository\SiteRepository;

class QuoteTextDecorator implements TextDecoratorInterface
{
    /** @var QuoteRepository  */
    private $quoteRepository;

    /** @var SiteRepository  */
    private $siteRepository;

    /** @var DestinationRepository  */
    private $destinationRepository;

    /** @var QuoteRenderer  */
    private $quoteRenderer;

    public function __construct(
        QuoteRepository $quoteRepository,
        SiteRepository $siteRepository,
        DestinationRepository $destinationRepository,
        QuoteRenderer  $quoteRenderer) {
        $this->quoteRepository = $quoteRepository;
        $this->siteRepository = $siteRepository;
        $this->destinationRepository = $destinationRepository;
        $this->quoteRenderer = $quoteRenderer;
    }

    /**
     * @param string $text
     * @param array $context
     *
     * @return string
     */
    public function decorate($text, $context)
    {
        if (!isset($context['quote'])) {
            return $text;
        }

        $quote = $context['quote'];
        $quoteEntity = $this->quoteRepository->getById($quote->id);
        $destination = $this->destinationRepository->getById($quote->destinationId);

        $text = $this->replaceText($text, '[quote:summary_html]', $this->quoteRenderer->renderHtml($quoteEntity));
        $text = $this->replaceText($text, '[quote:summary]', $this->quoteRenderer->renderText($quoteEntity));
        $text = $this->replaceText($text, '[quote:destination_name]', $destination->countryName);

        if (strpos($text, '[quote:destination_link]') !== false) {
            $site = $this->siteRepository->getById($quote->siteId);
            $link = isset($destination) ?
                $site->url . '/' . $destination->countryName . '/quote/' . $quoteEntity->id
                : ''
            ;
            $text = $this->replaceText($text, '[quote:destination_link]', $link);
        }

        return $text;
    }

    private function replaceText($textToReplace, $needle, $value)
    {
        if (strpos($textToReplace, $needle) !== false) {
           return  str_replace($needle, $value, $textToReplace);
        }

        return $textToReplace;
    }
}