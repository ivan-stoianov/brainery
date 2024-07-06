<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\Email;
use App\Casts\FirstName;
use App\Casts\LastName;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasDefaultGetters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'active',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => UserType::class,
            'active' => 'boolean',
            'first_name' => FirstName::class,
            'last_name' => LastName::class,
            'email' => Email::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getType(): UserType
    {
        return $this->type;
    }

    public function isAdmin(): bool
    {
        return $this->getType() === UserType::ADMIN;
    }

    public function isMember(): bool
    {
        return $this->getType() === UserType::MEMBER;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getName(): string
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function scopeOnlyMember(Builder $query): Builder
    {
        return $query->where('type', '=', UserType::MEMBER);
    }

    public function scopeOnlyAdmin(Builder $query): Builder
    {
        return $query->where('type', '=', UserType::ADMIN);
    }
}
