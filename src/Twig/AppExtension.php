<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('stars', [$this, 'generateStars'], ['is_safe' => ['html']]),
        ];
    }

    public function generateStars($rating, $maxStars = 5)
    {
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars >= 0.5) ? true : false;
        $emptyStars = $maxStars - $fullStars - ($halfStar ? 1 : 0);

        $starsHtml = '<span class="stars">';
        $starsHtml .= str_repeat('<i class="fas fa-star"></i>', $fullStars);
        if ($halfStar) {
            $starsHtml .= '<i class="fas fa-star-half-alt"></i>';
        }
        $starsHtml .= str_repeat('<i class="far fa-star"></i>', $emptyStars);
        $starsHtml .= '</span>';

        return $starsHtml;
    }
}

