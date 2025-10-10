<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\Room;

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
}
