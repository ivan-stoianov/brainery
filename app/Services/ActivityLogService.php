<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Activity;
use App\Services\Contracts\ActivityLogServiceInterface;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function record(string $description, string|BackedEnum $event, Model $subject = null, Model $causer = null): void
    {
        $query = activity();

        if (is_string($event)) {
            $query->event($event);
        }

        if ($event instanceof BackedEnum) {
            $query->event($event->value);
        }

        if ($subject) {
            $query = $query->performedOn($subject);
        }

        if ($causer) {
            $query = $query->causedBy($causer);
        }

        $query->log($description);
    }
}
