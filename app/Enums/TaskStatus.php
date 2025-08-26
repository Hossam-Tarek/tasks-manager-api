<?php

namespace App\Enums;

enum TaskStatus: int
{
    case Pending = 0;
    case InProgress = 1;
    case Done = 2;

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::Done => 'Done',
        };
    }
}
