<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserApiController extends Controller
{
    public function show($id)
    {
        $user = User::with('addresses')->find($id);

        if (!$user) {
            return response()->json([
                'status_code' => 404,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }


        return response()->json([
            'status_code' => 200,
            'message' => 'User details',
            'data' => [
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'mobile' => '9345345352', // hardcoded because it is missing in the task description
                'dob' => $user->dob,
                'gender' => ucfirst($user->gender),
                'Address' => $user->addresses->map(function ($address, $i) {
                    return [
                        'address_type' => ucfirst($address->address_type),
                        'address' . ($i + 1) => [
                            'door/street' => $address->door_street,
                            'landmark' => $address->landmark,
                            'city' => $address->city,
                            'state' => $address->state,
                            'country' => $address->country,
                        ],
                        'primary' => $address->primary ?? 'No',
                    ];
                }),
            ]
        ]);
    }
}
