<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MyResetPass;
use App\Notifications\MyVerifyMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'date_of_birth',
        'email',
        'password',
        'timezone',
        'role_id'
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new MyVerifyMail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPass($token));
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    //TODO ИСПРАВИТЬ РАБОТУ С ДАТАМИ!!!
    public function getAppointmentsCount(): int
    {
        $timeZone = Auth::getUser()->timezone;
        date_default_timezone_set($timeZone);
        $current_date = strtotime('now');
        $app = Appointment::where('user_id', $this->id)->where('date', '>', $current_date)->get();
        return count($app);
    }
}
