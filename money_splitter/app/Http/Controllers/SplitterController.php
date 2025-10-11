<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomMembers;
use App\Models\Transaction;
use App\Models\Debt;
use App\Models\FinalTransaction;
use App\Models\PersonalIncome;
use App\Models\PersonalExpense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SplitterController extends Controller
{
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
}