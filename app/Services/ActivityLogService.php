<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\ActivityLogServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Activity;

class ActivityLogService implements ActivityLogServiceInterface
{
    public function __construct(
        protected readonly Activity $activity
    ) {
    }

    public function getPaginatedByCauser(Model $causer): LengthAwarePaginator
    {
        return $this->activity->causedBy($causer)->latest()->paginate();
    }

    public function record(string $description, string $event, Model $subject = null, Model $causer = null): void
    {
        $query = activity()->event($event);

        if ($subject) {
            $query = $query->performedOn($subject);
        }

        if ($causer) {
            $query = $query->causedBy($causer);
        }

        $query->log($description);
    }
}
