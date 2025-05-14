<?php

namespace Service;

use Entity\Template;

class TemplateManager
{
    /** @var QuoteTextDecorator  */
    private $quoteTextDecorator;

    /** @var UserTextDecorator */
    private $userTextDecorator;

    public function __construct(QuoteTextDecorator $quoteTextDecorator, UserTextDecorator $userTextDecorator)
    {
        $this->quoteTextDecorator = $quoteTextDecorator;
        $this->userTextDecorator = $userTextDecorator;
    }

    public function getTemplateComputed(Template $template, array $data)
    {
        if (!$template) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone $template;
        $replaced->subject = $this->processText($replaced->subject, $data);
        $replaced->content = $this->processText($replaced->content, $data);

        return $replaced;
    }

    /**
     * @param string $text
     * @param array $data
     *
     * @return string
     */
    private function processText($text, array $data)
    {
        $text = $this->quoteTextDecorator->decorate($text, $data);
        $text = $this->userTextDecorator->decorate($text, $data);

        return $text;
    }

}
