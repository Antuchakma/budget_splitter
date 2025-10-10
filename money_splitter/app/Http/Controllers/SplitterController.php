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
 public function addPersonalBudget(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:inc,exp',
            'description' => 'required|string|max:250',
            'amount' => 'required|numeric'
        ]);

        if ($request->type == 'inc') {
            PersonalIncome::create([
                'user_id' => Auth::id(),
                'description' => $request->description,
                'amount' => $request->amount
            ]);
        } else {
            PersonalExpense::create([
                'user_id' => Auth::id(),
                'description' => $request->description,
                'amount' => $request->amount
            ]);
        }

        return redirect()->route('personal_budget')->with('success', 'Entry added!');
    }
}