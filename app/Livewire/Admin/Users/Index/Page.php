<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users\Index;

use App\Repositories\Contracts\UserAdminInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;

    protected $userAdminRepository;

    #[Url()]
    public $sort_by = 'first_name';

    #[Url()]
    public $sort_asc = true;

    #[Url()]
    public string $search = '';

    #[Url()]
    public int $per_page = 50;

    public array $perPageOptions = [
        15 => 15,
        50 => 50,
        100 => 100,
        300 => 300,
    ];

    public function boot(UserAdminInterface $userAdminRepository): void
    {
        $this->userAdminRepository = $userAdminRepository;
    }

    public function render(): View
    {
        return view('livewire.admin.users.index.page')->with([
            'users' => $this->getUsers(),
        ]);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    protected function getUsers(): LengthAwarePaginator
    {
        $query = $this->userAdminRepository->query();

        $query = $this->applySearch($query);
        $query = $this->applySorting($query);

        return $query->paginate($this->per_page);
    }

    protected function applySearch(Builder $query): Builder
    {
        if (empty($this->search)) {
            return $query;
        }

        return $query->where(function ($q) {
            $q->where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%");
        });
    }

    protected function applySorting(Builder $query): Builder
    {
        $column = match ($this->sort_by) {
            'name' => 'first_name',
            'email' => 'email',
            'status' => 'active',
            'created_at' => 'created_at',
            default => 'first_name',
        };

        return $query->orderBy($column, $this->sort_asc ? 'asc' : 'desc');
    }

    public function sortBy(string $fieldName): void
    {
        if ($this->sort_by === $fieldName) {
            $this->sort_asc = !$this->sort_asc;
        } else {
            $this->sort_asc = true;
        }

        $this->sort_by = $fieldName;
    }

    public function getColumnSortDirection($name): null|string
    {
        if ($this->sort_by !== $name) {
            return null;
        }

        return $this->sort_asc === true ? 'asc' : 'desc';
    }
}
