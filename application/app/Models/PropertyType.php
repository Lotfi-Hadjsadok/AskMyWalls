<?php

namespace App\Models;

enum PropertyType: string
{
    case Apartment = 'apartment';
    case Villa = 'villa';
    case Studio = 'studio';
    case Duplex = 'duplex';
    case Commercial = 'commercial';
    case Land = 'land';

    public function label(): string
    {
        return match ($this) {
            self::Apartment => 'Apartment',
            self::Villa => 'Villa',
            self::Studio => 'Studio',
            self::Duplex => 'Duplex',
            self::Commercial => 'Commercial',
            self::Land => 'Land',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Apartment => 'blue',
            self::Villa => 'green',
            self::Studio => 'yellow',
            self::Duplex => 'red',
            self::Commercial => 'purple',
            self::Land => 'gray',
        };
    }
}
