<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CreateUserAdminData;
use App\Events\UserAdminCreated;
use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\UserAdminServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAdminService implements UserAdminServiceInterface
{
    public function __construct(
        protected readonly UserAdminRepositoryInterface $userAdminRepository
    ) {}

    public function register(CreateUserAdminData $data): Model
    {
        return DB::transaction(function () use ($data) {
            $user = $this->userAdminRepository->register($data);

            UserAdminCreated::dispatch($user->getId());

            return $user;
        });
    }
}
