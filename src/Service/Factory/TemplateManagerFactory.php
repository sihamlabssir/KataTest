<?php

namespace Service\Factory;

use Context\ApplicationContext;
use Repository\DestinationRepository;
use Repository\QuoteRepository;
use Repository\SiteRepository;
use Service\QuoteRenderer;
use Service\QuoteTextDecorator;
use Service\TemplateManager;
use Service\UserTextDecorator;

class TemplateManagerFactory
{
    public static function getInstance(): TemplateManager
    {
        $quoteRepository = new QuoteRepository();
        $siteRepository = new SiteRepository();
        $destinationRepository = new DestinationRepository();
        $quoteRenderer = new QuoteRenderer();

        $quoteDecorator = new QuoteTextDecorator(
            $quoteRepository,
            $siteRepository,
            $destinationRepository,
            $quoteRenderer
        );

        $userDecorator = new UserTextDecorator(ApplicationContext::getInstance());
        return  new TemplateManager($quoteDecorator, $userDecorator);
    }
}