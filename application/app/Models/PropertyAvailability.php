<?php

namespace App\Models;

enum PropertyAvailability: string
{
    case Available = 'available';
    case Rented = 'rented';
    case Sold = 'sold';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Rented => 'Rented',
            self::Sold => 'Sold',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Available => 'green',
            self::Rented => 'blue',
            self::Sold => 'red',
        };
    }
}
