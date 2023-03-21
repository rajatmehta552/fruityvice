<?php

namespace App\Twig;

use App\Entity\OrderItem;
use App\Services\Utils;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('base64_encode', [$this, 'base64Encode']),
            new TwigFilter('base64_decode', [$this, 'base64Decode']),
            new TwigFilter('next_business_day', [$this, 'getNextBusinessDayDate']),
        ];
    }

    public function getNextBusinessDayDate(\DateTime $dateTime)
    {
        return Utils::getNextBusinessDay($dateTime);
    }

    public function base64Encode($content)
    {
        return base64_encode($content);
    }

    public function base64Decode($content)
    {
        return base64_decode($content);
    }
}