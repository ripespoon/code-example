<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
use App\Models\PasswordReset;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'gender',
        'password',
        'api_token',
        'date_of_birth',
        'street_address',
        'city',
        'postcode',
        'has_rated_app',
        'deleted_at',
        'deleted_by'
    ];

    /**
     * The attributes that are appended to each response.
     *
     * @var array
     */
    protected $appends = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->api_token = self::generateUniqueApiToken();
            $user->save();
        });
    }

    /**
     * Generate a unique API token via the booted method.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return String $token
     */
    private static function generateUniqueApiToken()
    {
        $token = Str::limit(Str::random(150) . sha1(Carbon::now()->getTimestamp()), 190);

        return $token;
    }

    /**
     * Generate a unique password reset token with a 30 day expiry.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return App\Models\PasswordReset $passwordReset
     */
    private function generateResetPasswordToken()
    {
        $passwordReset = PasswordReset::create([
            'user_id' => $this->id,
            'token' => Str::random(150) . $this->id . time(),
            'expires' => Carbon::now()->addDays(30)->format('Y-m-d H:i:s')
        ]);

        return $passwordReset;
    }

    /**
     * Send reset password email.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return Void
     */
    public function sendResetPasswordEmail()
    {
        $passwordReset = $this->generateResetPasswordToken();

        SendEmailJob::dispatch($this, 'forgot-password', 'Reset Your Password', ['props' => $passwordReset])->onQueue('account-notifications');
    }

    /**
     * Send welcome email to the user.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param none
     *
     * @return Void
     */
    public function sendWelcomeEmail()
    {
        SendEmailJob::dispatch($this, 'confirm-email', 'Confirm Your Email', [])->onQueue('account-notifications');
    }

    /**
     * Update a users Date of Birth from the request.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param none
     *
     * @return Void
     */
    public function setDateOfBirth()
    {
        $dateOfBirth = request('dob_year') . '-' . request('dob_month') . '-' . request('dob_day');

        $this->date_of_birth = $dateOfBirth;
        $this->save();
    }

    /**
     * Return a users full name.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return String
     */
    public function getNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Scope a query to only include member accounts.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyMembers($query)
    {
        return $query->where('role_id', 4);
    }

    /**
     * Scope a query to only include trainer accounts.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyTrainers($query)
    {
        return $query->where('role_id', 3);
    }

    /**
     * Scope a query to only include admin accounts.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyAdmins($query)
    {
        return $query->whereIn('role_id', [1,2]);
    }

    /**
     * Some user accounts may have a trainer relationship.
     *
     */
    public function trainer()
    {
        return $this->hasOne('App\Models\Trainer');
    }
}
