<?php

namespace App\Models;

enum PropertyStatus: string
{
    case ForSale = 'for_sale';
    case ForRent = 'for_rent';

    public function label(): string
    {
        return match ($this) {
            self::ForSale => 'For Sale',
            self::ForRent => 'For Rent',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ForSale => 'green',
            self::ForRent => 'blue',
        };
    }
}
