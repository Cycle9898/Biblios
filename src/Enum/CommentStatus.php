<?php

namespace App\Enum;

enum CommentStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Moderated = 'moderated';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'En attente',
            self::Published => 'Publié',
            self::Moderated => 'Modéré'
        };
    }

    public static function getValuesAndLabels(): array
    {
        $valuesAndLabels = [];

        foreach (self::cases() as $commentStatus) {
            $valuesAndLabels[$commentStatus->value] = $commentStatus->getLabel();
        }

        return $valuesAndLabels;
    }
}
