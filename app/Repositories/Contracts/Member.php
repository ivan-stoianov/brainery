<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface Member
{
    public function getPaginated(int $perPage = 25): LengthAwarePaginator;
}
