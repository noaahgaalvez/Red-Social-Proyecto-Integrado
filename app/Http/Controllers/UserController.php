<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Seguidor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function seguir(Request $request, User $user)
    {
        $data = $request->validate([
            'follow' => 'required|boolean'
        ]);

        if ($data['follow']) {
            $message = 'Ahora sigues a "' . $user->username . '"';
            Seguidor::create([
                'user_id' => $user->id,
                'follower_id' => Auth::id()
            ]);
        } else {
            $message = 'Dejaste de seguir a "' . $user->username . '"';
            Seguidor::query()->where('user_id', $user->id)->where('follower_id', Auth::id())->delete();
        }

        return back()->with('success', $message);
    }
}
