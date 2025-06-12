<?php

namespace App\Enums;

enum Status: string
{
    case AVAILABLE = 'available';
    case RENTED = 'rented';
    case MAINTENANCE = 'maintenance';

    public function label(): string {
        return match($this) {
            self::AVAILABLE => 'Boş',
            self::RENTED => 'Məşğul',
            self::MAINTENANCE => 'Təmirdə',
        };
    }
}
