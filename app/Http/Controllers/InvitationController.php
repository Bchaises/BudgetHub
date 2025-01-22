<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InvitationController
{
    public function index(): View
    {
        $user = User::findOrFail(Auth::id());
        return view('invitation.index', [
            'invitations' => $user->invitations,
            'accounts' => $user->accounts,
        ]);
    }

    public function store(): Redirector
    {
        //TODO vérifier que l'utilisateur avec l'e-mail existe

        //TODO vérifier si l'utilisateur a déjà accès au compte ou non

        //TODO ajouter une date d'expération de +1 jour

        //TODO envoyer un mail à la personne

        return redirect('/');
    }
}
