<?php

namespace App\SocialAuth;

use Illuminate\Database\Eloquent\Model;
use App\User;

/*
 |---------------------------------------------------------
 | SocialAccount
 |---------------------------------------------------------
 | Модел за SocialAccountService
 |
 | Запазва връзката м/у  google id-то и id-то в нашата база
 |
 | работи с mySql
 |
 */
class SocialAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}