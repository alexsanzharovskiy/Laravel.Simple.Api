<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cnp',
    ];

    /**
     * Creation new customer rules
     *
     * @return array
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|min:5',
            'cnp' => 'required|string|min:5'
        ];
    }
}
