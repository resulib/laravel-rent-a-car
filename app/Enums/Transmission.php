<?php

namespace App\Enums;

enum Transmission :string
{

    case AUTOMATIC ='automatic';
    case MANUAL ='manual';

    public function label(): string {
        return match($this) {
            self::AUTOMATIC => 'Avtomat',
            self::MANUAL => 'Mexanika',
        };
    }
}
