<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * POST Params: {name, cpn}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function create(Request $request)
    {
        if(!$this->isValidRequest($request->request->all(), Customer::rules())){
            return $this->errorResponse('Cannot validate request for creation new Customer');
        }

        $newCustomer = Customer::create($request->request->all());

        return response()->json([
            'customer_id' => $newCustomer->getAttribute('id'),
        ]);

    }
}
