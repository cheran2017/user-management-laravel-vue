<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5)
        ->withQueryString(); // Keep query params during pagination

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }
    // Show Create Form
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    // Store New User
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'addresses' => 'required|array|min:1',
            'addresses.*.address_type' => 'required|in:home,work',
            'addresses.*.door_street' => 'required|string|max:255',
            'addresses.*.landmark' => 'nullable|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.country' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
            ]);

            foreach ($validated['addresses'] as $address) {
                $user->addresses()->create([
                    'address_type' => $address['address_type'],
                    'door_street' => $address['door_street'] ?? null,
                    'landmark' => $address['landmark'] ?? null,
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'country' => $address['country'],
                ]);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
        
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    // Show Edit Form
    public function edit(User $user)
    {
        $user->load('addresses');
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    // Update User
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'addresses' => 'required|array|min:1',
            'addresses.*.address_type' => 'required|in:home,work',
            'addresses.*.door_street' => 'required|string|max:255',
            'addresses.*.landmark' => 'nullable|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.country' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $validated['first_name'].' '.$validated['last_name'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
            ]);

            $user->addresses()->delete();
            foreach ($validated['addresses'] as $address) {
                $user->addresses()->create($address);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->addresses()->delete();
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Delete failed!');
        }
    }



}
