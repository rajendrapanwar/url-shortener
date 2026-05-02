<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $companies = Company::all();
            return view('invitations.create', compact('companies'));
        }

        return view('invitations.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|email|unique:users,email|unique:invitations,email',
            'role' => 'required|in:admin,member',
        ]);

        if ($user->isSuperAdmin()) {
            $request->validate(['company_id' => 'required|exists:companies,id']);
            $companyId = $request->company_id;
            if ($request->role !== 'admin') {
                return back()->withErrors(['role' => 'Super Admin can only invite Admins.']);
            }
        } else {
            $companyId = $user->company_id;
        }

        $invitation = Invitation::create([
            'email' => $request->email,
            'role' => $request->role,
            'company_id' => $companyId,
            'invited_by' => $user->id,
            'token' => Str::random(64),
        ]);

        return redirect()->route('invitations.index')
            ->with('success', 'Invitation sent! Link: ' . route('invitations.accept', $invitation->token));
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $invitations = Invitation::with('company', 'inviter')->get();
        } else {
            $invitations = Invitation::where('company_id', $user->company_id)
                ->with('inviter')
                ->get();
        }

        return view('invitations.index', compact('invitations'));
    }

    public function acceptForm($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->isAccepted()) {
            abort(403, 'This invitation has already been accepted.');
        }

        return view('invitations.accept', compact('invitation'));
    }

    public function accept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->isAccepted()) {
            abort(403, 'This invitation has already been accepted.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'role' => $invitation->role,
            'company_id' => $invitation->company_id,
        ]);

        $invitation->update(['accepted_at' => now()]);

        return redirect()->route('login')->with('success', 'Account created! Please login.');
    }
}
