<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function dashboard(): View
    {
        $applications = auth()->user()->applications()
            ->with(['jobOffer.companyProfile', 'status'])
            ->latest()
            ->take(5)
            ->get();

        return view('candidate.dashboard', compact('applications'));
    }

    public function profile(): View
    {
        $profile = auth()->user()->candidateProfile 
            ?? new CandidateProfile();

        return view('candidate.profile', compact('profile'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        // Validation logic
        $validated = $request->validate([
            'imie' => 'required|string|max:100',
            'nazwisko' => 'required|string|max:100',
            'telefon' => 'nullable|string|max:20',
            'o_mnie' => 'nullable|string|max:2000',
            'cv' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
        ]);

        $user = auth()->user();
        $profile = $user->candidateProfile ?? new CandidateProfile(['user_id' => $user->id]);

        $profile->fill($validated);

        // Handle CV upload
        if ($request->hasFile('cv')) {
            // Delete old CV if exists
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            
            $path = $request->file('cv')->store('cv', 'public');
            $profile->cv_path = $path;
        }

        $profile->save();

        return redirect()->route('candidate.profile')
            ->with('success', 'Profil został zaktualizowany.');
    }

    public function applications(): View
    {
        $applications = auth()->user()->applications()
            ->with(['jobOffer.companyProfile', 'jobOffer.category', 'status'])
            ->latest()
            ->paginate(10);

        return view('candidate.applications', compact('applications'));
    }

    public function apply(Request $request, JobOffer $jobOffer): RedirectResponse
    {
        $user = auth()->user();

        // Check if already applied
        if ($user->applications()->where('job_offer_id', $jobOffer->id)->exists()) {
            return back()->with('error', 'Już aplikowałeś na tę ofertę.');
        }

        // Check if profile is complete
        if (!$user->candidateProfile || !$user->candidateProfile->imie) {
            return redirect()->route('candidate.profile')
                ->with('error', 'Najpierw uzupełnij swój profil.');
        }

        $validated = $request->validate([
            'wiadomosc' => 'nullable|string|max:2000',
        ]);

        Application::create([
            'job_offer_id' => $jobOffer->id,
            'user_id' => $user->id,
            'status_id' => 1, // "Nowa"
            'wiadomosc' => $validated['wiadomosc'] ?? null,
        ]);

        return redirect()->route('candidate.applications')
            ->with('success', 'Aplikacja została wysłana.');
    }
}
