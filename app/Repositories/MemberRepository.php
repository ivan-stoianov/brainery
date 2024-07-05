<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\Member;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberRepository implements Member
{
    public function __construct(
        protected readonly User $user
    ) {
    }

    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return $this->user->paginate($perPage);
    }
}
