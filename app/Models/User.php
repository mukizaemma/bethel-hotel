<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_id',
        'company_name',
        'field_of_work',
        'career',
        'birth_date',
        'job_interest',
        'cv',
        'passport',
        'role_id',
        'country_origin_id',
        'country_work_id',
        'plan_id',
        'email_verified_at',
        'email_verified_by',
        'verification_token',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function blogs(){
        return $this->hasMany(Blog::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function isSuperAdmin(){
        return $this->role_id == 1 || ($this->role && $this->role->slug === 'super-admin');
    }

    public function isContentManager(){
        return $this->role_id == 2 || ($this->role && $this->role->slug === 'admin');
    }

    public function isAccountant(){
        return false;
    }

    public function isAdmin(){
        // Admin is now considered as Content Manager (role_id = 2) or Super Admin
        return $this->isSuperAdmin() || $this->isContentManager();
    }

    public function isFrontOffice(){
        return false;
    }

    public function isGuest(){
        return $this->role && $this->role->slug === 'guest';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Whether this booking belongs to the account (linked user_id or legacy email match).
     */
    public function ownsBooking(Booking $booking): bool
    {
        if ($booking->user_id && (int) $booking->user_id === (int) $this->id) {
            return true;
        }
        if (!$booking->user_id && $booking->email && strcasecmp((string) $booking->email, (string) $this->email) === 0) {
            return true;
        }

        return false;
    }

    public function accountBookingsQuery()
    {
        return Booking::query()
            ->where(function ($q) {
                $q->where('user_id', $this->id)
                    ->orWhere(function ($q2) {
                        $q2->whereNull('user_id')->where('email', $this->email);
                    });
            })
            ->orderByDesc('created_at');
    }

    public function hasRoleId($roleId){
        return $this->role_id == $roleId;
    }

    public function emailVerifiedBy(){
        return $this->belongsTo(User::class, 'email_verified_by');
    }

    public function verifiedUsers(){
        return $this->hasMany(User::class, 'email_verified_by');
    }
    
}
