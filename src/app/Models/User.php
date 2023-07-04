<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property mixed $firstname
 * @property mixed $lastname
 * @property array $audiences
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'firstname',
        'lastname',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email',
        'audiences'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'update_at' => 'datetime',
    ];

    /**
     * The attributes that should be appended
     *
     * @var string[]
     */
    protected $appends = [
        'fullname',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return BelongsToMany
     */
    public function audiences(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'audience_user', 'user_id', 'audience_id');
    }

    /**
     * @return BelongsToMany
     */
    public function audienceOf(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'audience_user', 'audience_id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(PrivateChat::class, 'private_chat_user', 'user_id', 'private_chat_id');
    }
}
