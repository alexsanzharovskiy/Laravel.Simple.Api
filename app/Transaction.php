<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;


class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'amount',
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
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric'
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function filter(Request $request)
    {
        $search = $this->newQuery();

        //Customer ID filter
        if ($request->has('customer_id')) {
            $search->where('customer_id', (int)$request->input('customer_id'));
        }

        // Min Amount filter
        if ($request->has('amount_min')) {
            $search->where([
                [ 'amount', '>', (int)$request->input('amount_min')]
            ]);
        }

        // Max Amount Filter
        if ($request->has('amount_max')) {
            $search->where([
                ['amount', '<',  (int)$request->input('amount_max')]
            ]);
        }

        // Dates filter
        if ($request->has('date_from') && $request->has('date_to')) {
           $search->whereBetween('created_at', [
               (string)$request->input('date_from').' 00:00:00',
               (string)$request->input('date_to').' 23:59:59',
           ]);
        }

        // Offset Filter
        if($request->has('offset')){
            $search->offset((int)$request->input('offset'));
        }

        // Limit Filter
        if($request->has('limit')){
            $search->limit((int)$request->input('limit'));
        }

        // Get the results and return them.
        return $search->get();
    }
}
