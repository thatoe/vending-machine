<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        //if logged in user is admin, show all transactions
        if (auth()->user()->hasRole('admin')) {
            $transactions = Transaction::with('product', 'user')->paginate(5);
        }
        else {
            //if logged in user is not admin, show only transactions of the logged in user
            $transactions = Transaction::with('product', 'user')->where('user_id', auth()->id())->paginate(5);
        }
        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

}
