<?php

namespace App\Livewire\Admin\User\ActivityLog;

use App\Repositories\Contracts\UserAdminRepositoryInterface;
use App\Services\Contracts\ActivityLogServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Page extends Component
{
    protected ActivityLogServiceInterface $activityLogService;
    protected UserAdminRepositoryInterface $userAdminRepository;

    #[Locked]
    public int $userId;

    public function boot():void
    {
        $this->activityLogService = app()->make(ActivityLogServiceInterface::class);
        $this->userAdminRepository = app()->make(UserAdminRepositoryInterface::class);
    }

    public function render(): View
    {
        return view('livewire.admin.user.activity-log.page')->with(
            [
            'items' => $this->getItems(),
            ]
        );
    }

    protected function getItems(): LengthAwarePaginator
    {
        $user = $this->userAdminRepository->findById($this->userId);

        return $this->activityLogService->getPaginatedByCauser($user);
    }
}
