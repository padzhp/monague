<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'unhashed','country_id','subscribed','status','role','username','photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $connection = "mysql";  


    public function customer()
    {
        return $this->hasOne('App\Customer','user_id');
    }

    public function getCustomerInfo($user){
        $customer = new \stdClass();

        $customer = $user->customer;
        $customer->name = $user->name;
        $customer->email = $user->email;
        $customer->password = $user->unhashed;
        $customer->status = $user->status;

        return $customer;
    }

    public function country()
    {
        return $this->hasOne('App\Country','country');
    }


}
