<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'candidates' => User::whereHas('role', fn($q) => $q->where('nazwa', 'kandydat'))->count(),
            'employers' => User::whereHas('role', fn($q) => $q->where('nazwa', 'pracodawca'))->count(),
            'tags' => Tag::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request): View
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'ILIKE', "%{$request->search}%")
                  ->orWhere('email', 'ILIKE', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('role', fn($q) => $q->where('nazwa', $request->role));
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function editUser(User $user): View
    {
        $roles = Role::all();
        return view('admin.user-edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'aktywny' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'Użytkownik został zaktualizowany.');
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        // Prevent admin from blocking themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Nie możesz zablokować własnego konta.');
        }

        $user->update(['aktywny' => !$user->aktywny]);

        $status = $user->aktywny ? 'odblokowany' : 'zablokowany';
        return back()->with('success', "Użytkownik został {$status}.");
    }

    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Nie możesz usunąć własnego konta.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Użytkownik został usunięty.');
    }

    public function tags(): View
    {
        $tags = Tag::orderBy('nazwa')->paginate(20);
        return view('admin.tags', compact('tags'));
    }

    public function storeTag(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nazwa' => 'required|string|max:50|unique:tags,nazwa',
        ]);

        Tag::create($validated);

        return redirect()->route('admin.tags')
            ->with('success', 'Tag został dodany.');
    }

    public function updateTag(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'nazwa' => 'required|string|max:50|unique:tags,nazwa,' . $tag->id,
        ]);

        $tag->update($validated);

        return back()->with('success', 'Tag został zaktualizowany.');
    }

    public function deleteTag(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('admin.tags')
            ->with('success', 'Tag został usunięty.');
    }
}
