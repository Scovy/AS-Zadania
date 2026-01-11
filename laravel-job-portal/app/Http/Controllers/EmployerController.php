<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\JobOffer;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();
        $company = $user->companyProfile;

        $stats = [
            'total_offers' => 0,
            'active_offers' => 0,
            'total_applications' => 0,
            'new_applications' => 0,
        ];

        if ($company) {
            $stats['total_offers'] = $company->jobOffers()->count();
            $stats['active_offers'] = $company->jobOffers()->where('aktywna', true)->count();
            $stats['total_applications'] = Application::whereHas('jobOffer', function ($q) use ($company) {
                $q->where('company_profile_id', $company->id);
            })->count();
            $stats['new_applications'] = Application::whereHas('jobOffer', function ($q) use ($company) {
                $q->where('company_profile_id', $company->id);
            })->where('status_id', 1)->count();
        }

        $recentApplications = $company ? Application::whereHas('jobOffer', function ($q) use ($company) {
            $q->where('company_profile_id', $company->id);
        })->with(['jobOffer', 'user.candidateProfile', 'status'])
          ->latest()
          ->take(5)
          ->get() : collect();

        return view('employer.dashboard', compact('stats', 'recentApplications', 'company'));
    }

    public function profile(): View
    {
        $profile = auth()->user()->companyProfile 
            ?? new CompanyProfile();

        return view('employer.profile', compact('profile'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nazwa_firmy' => 'required|string|max:200',
            'opis' => 'nullable|string|max:5000',
            'strona_www' => 'nullable|url|max:255',
            'lokalizacja' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();
        $profile = $user->companyProfile ?? new CompanyProfile(['user_id' => $user->id]);

        $profile->fill($validated);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($profile->logo_path) {
                Storage::disk('public')->delete($profile->logo_path);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $profile->logo_path = $path;
        }

        $profile->save();

        return redirect()->route('employer.profile')
            ->with('success', 'Profil firmy został zaktualizowany.');
    }

    public function offers(): View
    {
        $company = auth()->user()->companyProfile;
        
        $offers = $company ? $company->jobOffers()
            ->with(['category', 'tags'])
            ->withCount('applications') // eager loading is good, keep it
            ->latest()
            ->paginate(10) : collect();

        return view('employer.offers', compact('offers', 'company'));
    }

    public function createOffer(): View
    {
        // Simple query without repositories
        $categories = Category::orderBy('kolejnosc')->get();
        $tags = Tag::orderBy('nazwa')->get();

        return view('employer.offer-form', [
            'offer' => null,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function storeOffer(Request $request): RedirectResponse
    {
        $company = auth()->user()->companyProfile;

        if (!$company) {
            return redirect()->route('employer.profile')
                ->with('error', 'Najpierw uzupełnij profil firmy.');
        }

        // Validation logic directly in controller
        $validated = $request->validate([
            'tytul' => 'required|string|max:200',
            'opis' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
            'lokalizacja' => 'required|string|max:100',
            'typ_pracy' => 'required|in:remote,hybrid,office',
            'wynagrodzenie_min' => 'nullable|numeric|min:0',
            'wynagrodzenie_max' => 'nullable|numeric|min:0|gte:wynagrodzenie_min',
            'wazna_do' => 'nullable|date|after:today',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $offer = $company->jobOffers()->create([
            'tytul' => $validated['tytul'],
            'opis' => $validated['opis'],
            'category_id' => $validated['category_id'],
            'lokalizacja' => $validated['lokalizacja'],
            'typ_pracy' => $validated['typ_pracy'],
            'wynagrodzenie_min' => $validated['wynagrodzenie_min'],
            'wynagrodzenie_max' => $validated['wynagrodzenie_max'],
            'wazna_do' => $validated['wazna_do'],
            'aktywna' => true,
        ]);

        if (!empty($validated['tags'])) {
            $offer->tags()->sync($validated['tags']);
        }

        return redirect()->route('employer.offers')
            ->with('success', 'Oferta została utworzona.');
    }

    public function editOffer(JobOffer $jobOffer): View
    {
        $this->authorizeOffer($jobOffer);

        $categories = Category::orderBy('kolejnosc')->get();
        $tags = Tag::orderBy('nazwa')->get();

        return view('employer.offer-form', [
            'offer' => $jobOffer,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function updateOffer(Request $request, JobOffer $jobOffer): RedirectResponse
    {
        $this->authorizeOffer($jobOffer);

        $validated = $request->validate([
            'tytul' => 'required|string|max:200',
            'opis' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
            'lokalizacja' => 'required|string|max:100',
            'typ_pracy' => 'required|in:remote,hybrid,office',
            'wynagrodzenie_min' => 'nullable|numeric|min:0',
            'wynagrodzenie_max' => 'nullable|numeric|min:0|gte:wynagrodzenie_min',
            'wazna_do' => 'nullable|date|after:today',
            'aktywna' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $jobOffer->update($validated);
        $jobOffer->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('employer.offers')
            ->with('success', 'Oferta została zaktualizowana.');
    }

    public function deleteOffer(JobOffer $jobOffer): RedirectResponse
    {
        $this->authorizeOffer($jobOffer);

        $jobOffer->delete();

        return redirect()->route('employer.offers')
            ->with('success', 'Oferta została usunięta.');
    }

    public function allApplications(): View
    {
        $company = auth()->user()->companyProfile;

        $applications = Application::whereHas('jobOffer', function ($q) use ($company) {
                $q->where('company_profile_id', $company->id);
            })
            ->with(['jobOffer', 'user.candidateProfile', 'status'])
            ->latest()
            ->paginate(15);

        $statuses = ApplicationStatus::all();

        return view('employer.applications', [
            'jobOffer' => null, // null means "show all"
            'applications' => $applications, 
            'statuses' => $statuses
        ]);
    }

    public function applications(JobOffer $jobOffer): View
    {
        $this->authorizeOffer($jobOffer);

        $applications = $jobOffer->applications()
            ->with(['user.candidateProfile', 'status'])
            ->latest()
            ->paginate(10);

        $statuses = ApplicationStatus::all();

        return view('employer.applications', compact('jobOffer', 'applications', 'statuses'));
    }

    public function updateApplicationStatus(Request $request, Application $application): RedirectResponse
    {
        $this->authorizeOffer($application->jobOffer);

        $validated = $request->validate([
            'status_id' => 'required|exists:application_statuses,id',
        ]);

        $application->update(['status_id' => $validated['status_id']]);

        return back()->with('success', 'Status aplikacji został zmieniony.');
    }

    private function authorizeOffer(JobOffer $jobOffer): void
    {
        $company = auth()->user()->companyProfile;

        if (!$company || $jobOffer->company_profile_id !== $company->id) {
            abort(403, 'Brak dostępu do tej oferty.');
        }
    }
}
