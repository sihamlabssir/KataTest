<?php

namespace Service;

interface TextDecoratorInterface
{
    /**
     * @param string $text
     * @param array $context
     *
     * @return string
     */
    public function decorate($text, $context);
}