<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SymfonyVersionExtension
 * @package App\Twig
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
class SymfonyVersionExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('symfony_version', [$this, 'getVersion']),
        ];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return \Symfony\Component\HttpKernel\Kernel::VERSION;
    }
}
