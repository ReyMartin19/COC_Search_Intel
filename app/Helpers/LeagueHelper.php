<?php

namespace App\Helpers;

class LeagueHelper
{
    public static function determineLeague(int $trophies): array
    {
        return match(true) {
            $trophies >= 5000 => [
                'image' => 'Legend_League.webp',
                'name' => 'Legend League'
            ],
            $trophies >= 4699 => [
                'image' => 'Titan_League.webp',
                'name' => 'Titan I'
            ],
            $trophies >= 4399 => [
                'image' => 'Titan_League.webp',
                'name' => 'Titan II'
            ],
            $trophies >= 4099 => [
                'image' => 'Titan_League.webp',
                'name' => 'Titan III'
            ],
            $trophies >= 3799 => [
                'image' => 'Champion_League.webp',
                'name' => 'Champion I'
            ],
            $trophies >= 3499 => [
                'image' => 'Champion_League.webp',
                'name' => 'Champion II'
            ],
            $trophies >= 3199 => [
                'image' => 'Champion_League.webp',
                'name' => 'Champion III'
            ],
            $trophies >= 2999 => [
                'image' => 'Master_League.webp',
                'name' => 'Master I'
            ],
            $trophies >= 2799 => [
                'image' => 'Master_League.webp',
                'name' => 'Master II'
            ],
            $trophies >= 2599 => [
                'image' => 'Master_League.webp',
                'name' => 'Master III'
            ],
            $trophies >= 2399 => [
                'image' => 'Crystal_League.webp',
                'name' => 'Crystal I'
            ],
            $trophies >= 2199 => [
                'image' => 'Crystal_League.webp',
                'name' => 'Crystal II'
            ],
            $trophies >= 1999 => [
                'image' => 'Crystal_League.webp',
                'name' => 'Crystal III'
            ],
            $trophies >= 1799 => [
                'image' => 'Gold_League.webp',
                'name' => 'Gold I'
            ],
            $trophies >= 1599 => [
                'image' => 'Gold_League.webp',
                'name' => 'Gold II'
            ],
            $trophies >= 1399 => [
                'image' => 'Gold_League.webp',
                'name' => 'Gold III'
            ],
            $trophies >= 1199 => [
                'image' => 'Silver_League.webp',
                'name' => 'Silver I'
            ],
            $trophies >= 999 => [
                'image' => 'Silver_League.webp',
                'name' => 'Silver II'
            ],
            $trophies >= 799 => [
                'image' => 'Silver_League.webp',
                'name' => 'Silver III'
            ],
            $trophies >= 599 => [
                'image' => 'Bronze_League.webp',
                'name' => 'Bronze I'
            ],
            $trophies >= 499 => [
                'image' => 'Bronze_League.webp',
                'name' => 'Bronze II'
            ],
            $trophies >= 400 => [
                'image' => 'Bronze_League.webp',
                'name' => 'Bronze III'
            ],
            default => [
                'image' => 'Unranked_League.webp',
                'name' => 'Unranked'
            ]
        };
    }
}