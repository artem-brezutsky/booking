<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

/**
 * @property array $permissions
 * @property array $mailings
 * @property int id
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions'       => 'array',
        'mailings'          => 'array',
    ];

    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->permissions ?? [], true);
    }

    public function hasPermission($role): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($role, $this->permissions ?? [], true);
    }

    public function hasMailings($studioID): bool
    {
        return in_array($studioID, $this->mailings ?? [], true);
    }

    /**
     *
     * SELECT * FROM `users` WHERE (JSON_CONTAINS(mailings, '["STUDIO_ID_1"]'))
     * Получаем всех пользователей которые подписаны на "комнату" в которую добавляют событие
     *
     * @param $studioID
     * @return Collection
     */
    public function getMailingSubscribers($studioID): Collection
    {
        return User::query()
            ->where(static function ($query) use ($studioID) {
                $studioID = 'STUDIO_ID_' . $studioID;
                $query->whereRaw(
                    'JSON_CONTAINS(mailings, \'["' . $studioID . '"]\')'
                );

                return $query;
            })
            ->get('email')
            ->pluck('email');
    }
}
