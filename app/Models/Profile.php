<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = 
    ['user_id','first_name','last_name','phone_number','birthday','gender',
    'city','country','street_address','language','postal_code','image'];

    public static function ProfileValidate()
{
    $id = Auth::user()->profile->id;
    return [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'phone_number' => [
        'nullable',
        'string',
        'max:15',
        Rule::unique('profiles', 'phone_number')->ignore($id),
        ],
        'birthday' => 'nullable|date',
        'gender' => 'required|in:male,female',
        'street_address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'country' => 'required|string|size:2',
        'language' => 'required|string|size:2',
    ];
}

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
}
