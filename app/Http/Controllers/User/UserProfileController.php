<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfile\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    public function edit(User $user)
    {
        $user->load('profile');

        return Inertia::render('UserProfile/CreateEdit', [
            'user' => $user
        ]);
    }

    public function update(UpdateRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $request->phone
                ]
            );
        });

        return redirect()->back();
    }
}
