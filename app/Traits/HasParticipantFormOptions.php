<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Federation;

trait HasParticipantFormOptions
{
    private function getParticipantFormOptions(): array
    {
        return [
            'federations' => Federation::all(),
            'categories' => Category::all(),
        ];
    }
}