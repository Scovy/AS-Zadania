<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = JobOffer::with(['companyProfile', 'category', 'tags'])
            ->active()
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by tags
        if ($request->filled('tags')) {
            $tagIds = is_array($request->tags) ? $request->tags : [$request->tags];
            $query->byTags($tagIds);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }

        // Filter by salary
        if ($request->filled('salary_min') || $request->filled('salary_max')) {
            $query->bySalary($request->salary_min, $request->salary_max);
        }

        // Filter by work type
        if ($request->filled('work_type')) {
            $query->byWorkType($request->work_type);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('tytul', 'ILIKE', "%{$request->search}%");
        }

        $jobOffers = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('kolejnosc')->get();
        $tags = Tag::orderBy('nazwa')->get();

        return view('home', compact('jobOffers', 'categories', 'tags'));
    }

    public function show(JobOffer $jobOffer): View
    {
        $jobOffer->load(['companyProfile', 'category', 'tags']);
        
        $hasApplied = false;
        if (auth()->check() && auth()->user()->isCandidate()) {
            $hasApplied = auth()->user()->applications()
                ->where('job_offer_id', $jobOffer->id)
                ->exists();
        }

        return view('job-offer.show', compact('jobOffer', 'hasApplied'));
    }
}
