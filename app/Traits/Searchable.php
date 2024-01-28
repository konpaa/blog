<?php

namespace App\Traits;

trait Searchable
{
    use \Laravel\Scout\Searchable;

    public function scopeScoutSearch($query, $text = '')
    {
        if (! empty($text)) {
            $query->whereIn('id', self::search($text)->get()->pluck('id'));
        }
    }
}
