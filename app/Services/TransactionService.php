<?php

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\UnauthorizedResourceException;
use App\Exceptions\UserNotEnabledForTransactionsException;
use App\Exceptions\UserTypeNotFoundException;
use App\Models\Contracts\CustomerContract;
use App\Models\Contracts\UserContract;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Auth;

class TransactionService extends ServiceBase
{
    public function __construct(TransactionRepository $repository)
    {
        parent::__construct($repository);
    }


    /**
     * @throws UserNotEnabledForTransactionsException
     * @throws UnauthorizedResourceException
     * @throws InsufficientBalanceException
     */
    public function transaction(array $data)
    {
        $user = Auth::user();
        $this->validateTransaction($data, $user);
        $this->makeTransaction($user, $data);
    }

    /**
     * @throws UserNotEnabledForTransactionsException
     * @throws UnauthorizedResourceException
     * @throws InsufficientBalanceException
     */
    private function validateTransaction(array $data, UserContract $user = null): void
    {
        if (empty($user)) {
            throw new UnauthorizedResourceException();
        }

        $wallet = $user->wallet()->first();

        if ($wallet->balance <= 0 || $wallet->balance < $data['amount']) {
            throw new InsufficientBalanceException();
        }
    }

    /**
     * @throws UserTypeNotFoundException
     */
    private function makeTransaction(CustomerContract $user, array $data): void
    {
        $customerWallet = $user->wallet();

        $service = UserTypeService::getService($data['userType']);

        $payee = $service->findBy('uuid', $data['payee']);

        $payeeWallet = $payee->wallet();

        Transaction::create([
            'payer' => $user->uuid,
            'payee' => $payee->uuid,
            'amount' => $data['amount'],
        ]);

        $decreasedBalance = $customerWallet->first()->balance - $data['amount'];
        $increasedBalance = $payeeWallet->first()->balance + $data['amount'];

        $customerWallet->update([
            'balance' => $decreasedBalance
        ]);

        $payeeWallet->update([
           'balance' => $increasedBalance
        ]);
    }
}
