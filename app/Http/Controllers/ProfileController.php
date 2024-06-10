<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Seguidor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;


class ProfileController extends Controller
{
    public function index(User $user)
    {
        $esSeguidor = false;
        
        if (!Auth::guest()) {
            $esSeguidor = Seguidor::where('user_id', $user->id)->where('follower_id', Auth::id())->exists();
        }
           
        $numSeguidores = Seguidor::where('user_id', $user->id)->count();
        
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'success' => session('success'),
            'isFollower' => $esSeguidor,
            'numFollowers' => $numSeguidores,
            'user' => new UserResource($user),
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile', $request->user())->with('success', 'Los datos de tu perfil han sido actualiazados.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function actualizarImagen(Request $request)
    {
        $data = $request->validate([
            'portada' => ['image', 'nullable'],
            'imagenPerfil' => ['image', 'nullable']
        ]);

        $user = $request->user();

        $portada = $data['portada'] ?? null;
        $imagenPerfil = $data['imagenPerfil'] ?? null;

        $success = '';

        if ($portada) {
            if ($user->cover_path) {
                Storage::disk('public')->delete($user->cover_path);
            }
            $path = $portada->store('user-' . $user->id, 'public');
            $user->update(['cover_path' => $path]);
            $success = 'Tu imagen de portada ha sido actualizada';
        }

        if ($imagenPerfil) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $imagenPerfil->store('user-' . $user->id, 'public');
            $user->update(['avatar_path' => $path]);
            $success = 'Tu imagen de perfil ha sido actualizada';
        }

        return back()->with('success', $success);
    }
}
