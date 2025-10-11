<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\Room;
use App\Models\RoomMembers;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\PersonalIncome;
use App\Models\PersonalExpense;
use App\Models\FinalTransaction;



class SplitterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('index', compact('user'));
    }

    // ---------------- Authentication ----------------
    public function signup()
    {
        return view('joinus');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Redirect to home/index
        return redirect()->route('room_list')->with('success', 'Account created successfully!');
    }

    public function login()
    {
        return view('joinus');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('room_list')->with('success', 'Welcome back!');
        }

        return redirect()->back()->withErrors(['login' => 'Invalid username or password.'])->withInput($request->only('name'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
    public function addRoom()
    {
        return view('add_room');
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250'
        ]);

        $room = Room::create([
            'name' => $request->name,
            'creater_id' => Auth::id()
        ]);

        return redirect()->route('room_detail', ['pk' => $room->id])->with('success', 'Room created!');
    }
    public function roomList()
    {
        $rooms = Room::where('creater_id', Auth::id())
            ->orWhereHas('members', function ($q) {
                $q->where('member_id', Auth::id());
            })->get();

        return view('room_list', compact('rooms'));
    }

    public function roomDetails($pk)
    {
        $room = Room::findOrFail($pk);
        $transactions = $room->transactions()->with('payer')->get();
        $members_list = $room->members;
        $members_count = $members_list->count() + 1; 
        $creator = $room->creater_id == Auth::id();

      
        $all_participants = collect();

       
        if ($room->creater_id != Auth::id()) {
            $all_participants->push($room->creater);
        }

        
        $members_excluding_current = $members_list->filter(function ($member) {
            return $member->id != Auth::id();
        });

        $all_participants = $all_participants->merge($members_excluding_current);

        return view('room_detail', compact('room', 'transactions', 'members_list', 'members_count', 'creator', 'all_participants'));
    }
    public function addMember(Request $request, $pk, $id)
    {
        $room = Room::findOrFail($pk);
        $room->members()->attach($id);
        return redirect()->route('list_members', $pk)->with('success', 'Member added!');
    }
    public function listMembers(Request $request, $pk)
    {
        $room = Room::findOrFail($pk);

     
        $existingMemberIds = $room->members->pluck('id')->toArray();
        $existingMemberIds[] = $room->creater_id; 
        $query = User::whereNotIn('id', $existingMemberIds);

       
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        $members_list = $query->get();

        return view('members_list', compact('room', 'members_list'));
    }

    public function createTransactionForm($pk)
    {
        $room = Room::findOrFail($pk);
        $members = $room->members;
        return view('create_transaction', compact('room', 'members'));
    }

    public function storeTransaction(Request $request, $pk)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'reason' => 'required|string|max:250',
            'splitters' => 'required|array',
            'split_type' => 'required|in:equal,custom',
            'percentages' => 'required_if:split_type,custom|array'
        ]);

        if ($request->split_type === 'custom') {
            $totalPercentage = array_sum(array_filter($request->percentages, 'is_numeric'));
            if (abs($totalPercentage - 100) > 0.01) {
                return back()->withErrors(['percentages' => 'Percentages must total exactly 100%'])->withInput();
            }
        }

        // Prepare shares data
        $shares = [];
        if ($request->split_type === 'custom') {
            // Custom percentages
            foreach ($request->splitters as $splitter_id) {
                $percentage = $request->percentages[$splitter_id] ?? 0;
                if ($percentage > 0) {
                    $shares[$splitter_id] = floatval($percentage);
                }
            }
        } else {
            // Equal split
            $equalPercentage = 100 / count($request->splitters);
            foreach ($request->splitters as $splitter_id) {
                $shares[$splitter_id] = $equalPercentage;
            }
        }

        $transaction = Transaction::create([
            'room_id' => $pk,
            'payer_id' => Auth::id(),
            'amount' => $request->amount,
            'reason' => $request->reason,
            'split_type' => $request->split_type,
            'shares' => $shares
        ]);

        $transaction->splitters()->sync($request->splitters);

       
        foreach ($request->splitters as $splitter_id) {
            if ($splitter_id != Auth::id()) {
                $sharePercentage = $shares[$splitter_id] ?? 0;
                $debtAmount = ($request->amount * $sharePercentage) / 100;

                Debt::create([
                    'room_id' => $pk,
                    'transaction_id' => $transaction->id,
                    'sender_id' => $splitter_id,
                    'receiver_id' => Auth::id(),
                    'amount' => $debtAmount
                ]);
            }
        }

        $splitMessage = $request->split_type === 'custom' ? 'with custom percentages' : 'equally';
        return redirect()->route('room_detail', $pk)->with('success', "Transaction added and split {$splitMessage}!");
    }
    public function myDebts()
    {
        $userId = Auth::id();

        // Payments the user will receive
        $incomes = Debt::where('receiver_id', $userId)
            ->with(['sender', 'transaction', 'room'])
            ->get();

        // Payments the user needs to pay
        $expenses = Debt::where('sender_id', $userId)
            ->with(['receiver', 'transaction', 'room'])
            ->get();

        return view('my_debts', compact('incomes', 'expenses'));
    }


    public function deleteDebt($pk)
    {
        $debt = Debt::findOrFail($pk);
        $debt->delete();
        return redirect()->route('my_debts')->with('success', 'Debt settled!');
    }
    public function finalSettlements()
    {
        $userId = Auth::id();

        $incomes = Debt::where('receiver_id', $userId)
            ->with(['sender', 'transaction', 'room'])
            ->get();

        $expenses = Debt::where('sender_id', $userId)
            ->with(['receiver', 'transaction', 'room'])
            ->get();

        $netIncomes = collect();
        $netExpenses = collect();

        $incomeGroups = $incomes->groupBy('sender_id');
        foreach ($incomeGroups as $senderId => $debts) {
            $totalAmount = $debts->sum('amount');
            $sender = $debts->first()->sender;

            $netIncomes->push((object)[
                'sender' => $sender,
                'final_amount' => $totalAmount
            ]);
        }

        $expenseGroups = $expenses->groupBy('receiver_id');
        foreach ($expenseGroups as $receiverId => $debts) {
            $totalAmount = $debts->sum('amount');
            $receiver = $debts->first()->receiver;

            $netExpenses->push((object)[
                'receiver' => $receiver,
                'final_amount' => $totalAmount
            ]);
        }

        $user_receiver_positive = collect();
        $user_sender_negative = collect();

        foreach ($netIncomes as $income) {
            $senderId = $income->sender->id;
            $incomeAmount = $income->final_amount;

            $correspondingExpense = $netExpenses->firstWhere('receiver.id', $senderId);

            if ($correspondingExpense) {
                $expenseAmount = $correspondingExpense->final_amount;
                $netAmount = $incomeAmount - $expenseAmount;

                if ($netAmount > 0) {
                    // Net: they owe us money
                    $user_receiver_positive->push((object)[
                        'sender' => $income->sender,
                        'final_amount' => $netAmount
                    ]);
                } elseif ($netAmount < 0) {
                    // Net: we owe them money
                    $user_sender_negative->push((object)[
                        'receiver' => $income->sender,
                        'final_amount' => abs($netAmount)
                    ]);
                }
                $netExpenses = $netExpenses->reject(function ($expense) use ($senderId) {
                    return $expense->receiver->id == $senderId;
                });
            } else {
                // Pure income - they owe us money
                $user_receiver_positive->push($income);
            }
        }

        foreach ($netExpenses as $expense) {
            $user_sender_negative->push($expense);
        }

        $noincome = $user_receiver_positive->isEmpty();
        $noexpense = $user_sender_negative->isEmpty();

        return view('final_settlements', compact('user_receiver_positive', 'user_sender_negative', 'noincome', 'noexpense'));
    }
    public function transactionHistory(Request $request)
    {
        $userId = Auth::id();

        // Get transactions where user is the payer
        $payerTransactions = Transaction::where('payer_id', $userId)
            ->with(['room', 'splitters'])
            ->get();

        // Get transactions where user is a splitter
        $splitterTransactions = Transaction::whereHas('splitters', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('payer_id', '!=', $userId) // Exclude if already included as payer
            ->with(['room', 'payer', 'splitters'])
            ->get();

        // Combine and sort by date (newest first)
        $allTransactions = $payerTransactions->merge($splitterTransactions)
            ->sortByDesc('created_at');

        // Apply search filter if provided
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $allTransactions = $allTransactions->filter(function ($transaction) use ($searchTerm) {
                return stripos($transaction->reason, $searchTerm) !== false ||
                    stripos($transaction->room->name, $searchTerm) !== false ||
                    stripos($transaction->payer->name, $searchTerm) !== false;
            });
        }

        // Calculate statistics
        $totalPaid = $payerTransactions->sum('amount');
        $totalSplitTransactions = $splitterTransactions->count();
        $totalPaidTransactions = $payerTransactions->count();

        return view('transaction_history', compact(
            'allTransactions',
            'totalPaid',
            'totalSplitTransactions',
            'totalPaidTransactions'
        ));
    }
    public function transactionDetails($pk)
    {
        $transaction = Transaction::findOrFail($pk);
        $transaction->load(['payer', 'splitters', 'room', 'room.creater']); // Load relationships
        $transaction_splitters_username = $transaction->splitters->pluck('name')->toArray();

        // Get room members for the edit form (including creator)
        $room = $transaction->room;
        $members_list = $room->members;

        // Add creator to members list if not already included
        if (!$members_list->contains('id', $room->creater_id)) {
            $members_list = $members_list->push($room->creater);
        }

        return view('transaction_details', compact('transaction', 'transaction_splitters_username', 'members_list'));
    }
    public function updateTransactionForm($pk, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $room = Room::findOrFail($pk);
        return view('update_transaction', compact('transaction', 'room'));
    }

    public function updateTransaction(Request $request, $pk, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'reason' => 'required|string|max:250',
            'splitters' => 'array'
        ]);

        $transaction = Transaction::findOrFail($id);

        // Update transaction details
        $transaction->update([
            'amount' => $request->amount,
            'reason' => $request->reason
        ]);

        // Update splitters if provided
        if ($request->has('splitters')) {
            $transaction->splitters()->sync($request->splitters);

            // Delete existing debts for this transaction
            Debt::where('transaction_id', $transaction->id)->delete();

            // Create new debts for each splitter
            foreach ($request->splitters as $splitter_id) {
                if ($splitter_id != $transaction->payer_id) {
                    Debt::create([
                        'room_id' => $pk,
                        'transaction_id' => $transaction->id,
                        'sender_id' => $splitter_id,
                        'receiver_id' => $transaction->payer_id,
                        'amount' => $request->amount / count($request->splitters)
                    ]);
                }
            }
        }

        return redirect()->route('transaction_details', $id)->with('success', 'Transaction updated successfully!');
    }
    public function deletePersonalIncome($pk)
    {
        $income = PersonalIncome::findOrFail($pk);
        $income->delete();
        return redirect()->route('personal_budget')->with('success', 'Income deleted!');
    }

    public function deletePersonalExpense($pk)
    {
        $expense = PersonalExpense::findOrFail($pk);
        $expense->delete();
        return redirect()->route('personal_budget')->with('success', 'Expense deleted!');
    }

   
    // ---------------- Static Pages ----------------
    public function joinUs()
    {
        return view('joinus');
    }

}

