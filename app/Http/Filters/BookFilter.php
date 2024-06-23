<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class BookFilter extends AbstractFilter
{
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::SEARCH => [$this, 'search']
        ];
    }

    public function search(Builder $builder, $value)
    {
        $loweredValue = strtolower($value);

        $builder->where(function ($query) use ($loweredValue) {
            $query->orWhereRaw('LOWER(title) like ?', ["%${loweredValue}%"])
                ->orWhereRaw('LOWER(author) like ?', ["%${loweredValue}%"])
                ->orWhereRaw('LOWER(publisher) like ?', ["%${loweredValue}%"]);
        });
    }
}
