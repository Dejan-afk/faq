<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Visitor = 'visitor';
    case Editor = 'editor'; //For future use, if needed

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
