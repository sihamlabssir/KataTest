<?php

namespace Service;


use Context\ApplicationContext;
use Entity\User;

class UserTextDecorator implements TextDecoratorInterface
{
    /** @var ApplicationContext */
    private $applicationContext;
    public function __construct(ApplicationContext $applicationContext)
    {
        $this->applicationContext = $applicationContext;
    }

    /**
     * @param string $text
     * @param array $context
     *
     * @return string
     */
    public function decorate($text, $context)
    {
        $user = isset($context['user']) ? $context['user'] : $this->applicationContext->getCurrentUser();

        if (!$user instanceof User) {
            return $text;
        }

        if (strpos($text, '[user:first_name]') !== false) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
        }

        return $text;
    }
}