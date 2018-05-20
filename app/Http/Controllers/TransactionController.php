<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function create(Request $request)
    {
        if (!$this->isValidRequest($request->all(), Transaction::rules())) {
            return $this->errorResponse('Cannot validate request for creation new Transaction');
        }

        $newCustomer = Transaction::create($request->request->all());

        return response()->json([
            'message' => 'Transaction Created, Id:'.$newCustomer->getAttribute('id'),
            'data' => $newCustomer->getAttributes(),
        ]);

    }


    /**
     * @param int $customer_id
     * @param int $transaction_id
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function get(int $customer_id, int $transaction_id)
    {
        return response()->json(
            Transaction::where([
                'id' => $transaction_id,
                'customer_id' => $customer_id
            ])
            ->first());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function getWithFilters(Request $request)
    {
        return response()->json((new Transaction)->filter($request));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function update(Request $request, $id)
    {
        if(!$this->isValidRequest($request->all(), ['amount' => 'required|numeric'])) {
            return $this->errorResponse('Amount parameter should be set');
        }

        $transaction = Transaction::find($id);
        if(!$transaction){
            return $this->errorResponse('Transaction doesnt exists');
        }

        $transaction->setAttribute('amount', $request->input('amount'));
        if(!$transaction->save()){
            return $this->errorResponse('Couldt update transaction');
        }

        return response()->json($transaction->getAttributes());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function destroy($id)
    {
        if(!$this->isValidRequest(['id' => $id], ['id' => 'required|exists:transactions'])){
            return $this->errorResponse('Transaction doesnt exists');
        }

        if(Transaction::where('id',$id)->delete()){
            return response()->json([
                'data' => 'success'
            ]);
        } else {
            return response()->json([
                'data' => 'fail'
            ]);
        }
    }
}
