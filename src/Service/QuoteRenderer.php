<?php

namespace Service;

use Entity\Quote;

class QuoteRenderer
{
    /**
     * @return string
     */
    public function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->id . '</p>';
    }


    /**
     * @return string
     */
    public function renderText(Quote $quote)
    {
        return (string) $quote->id;
    }
}
