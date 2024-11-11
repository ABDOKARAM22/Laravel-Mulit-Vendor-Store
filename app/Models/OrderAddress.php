<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','type','email','first_name','last_name','phone_number',
        'country','city','state','street_address','postal_code'
    ];

    public $timestamps = false;

    public function getNameAttribute(){
        return $this->first_name . $this->last_name;
    }

    public function getCountryNameAttribute(){
        return Countries::getName($this->country);
    }


}
