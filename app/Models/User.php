<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $guarded = [];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function orders()
    {
        return $this->hasMany(
            Order::class,
            $this->user_id
        )->orderBy('id', 'desc');
    }

    public function referral()
    {
        return User::find($this->ref_user_id);
    }


    public function wallet_balance()
    {
        return round($this->account_balance, 2);
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            
            $query->where(function ($query) use ($search) {
                $query
                    ->where('fullname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('gender', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%');
            });
        
        });
    }
}
