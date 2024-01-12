<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\UnauthorizedResourceException;
use App\Exceptions\UserNotEnabledForTransactionsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Exception;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $service)
    {
        $this->middleware('auth:customer', ['pay']);
    }

    public function pay(TransactionRequest $request)
    {
        try {
            $this->service->transaction($request->validated());

            return response([
                'message' => 'transaction completed successfully!'
            ]);
        } catch (UserNotEnabledForTransactionsException|UnauthorizedResourceException|InsufficientBalanceException $exception) {
            return response([
                'message' => $exception->getMessage()
            ], $exception->getCode());
        } catch (Exception $exception) {
            return response([
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ], $exception->getCode());
        }
    }
}
