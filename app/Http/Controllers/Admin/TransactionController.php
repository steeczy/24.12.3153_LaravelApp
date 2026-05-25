<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('event')->latest()->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $events = Event::latest()->get();

        return view('admin.transactions.create', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'order_id' => 'required|string|max:255|unique:transactions,order_id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Success,Expired',
            'snap_token' => 'nullable|string|max:255',
        ]);

        Transaction::create($data);

        return redirect()->route('admin.transactions.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        $events = Event::latest()->get();

        return view('admin.transactions.edit', compact('transaction', 'events'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'order_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('transactions', 'order_id')->ignore($transaction->id),
            ],
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Success,Expired',
            'snap_token' => 'nullable|string|max:255',
        ]);

        $transaction->update($data);

        return redirect()->route('admin.transactions.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}
