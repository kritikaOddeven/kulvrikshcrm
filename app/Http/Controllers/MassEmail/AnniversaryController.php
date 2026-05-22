<?php

namespace App\Http\Controllers\MassEmail;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Family;
use App\Models\Country;
use App\Models\EmailTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnniversaryController extends Controller
{
    public function todayBirthdays(Request $request)
    {
        $query = Lead::isClient();
        
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }

        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }

        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }

        // Get today's date in the format stored in the database (Y-m-d)
        $today = now()->format('Y-m-d');
        
        // Query for birthdays today from leads table
        $leadBirthdays = $query->whereNotNull('birth_date')
            ->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today])
            ->with(['countries', 'states', 'cities'])
            ->get();

        // Query for birthdays today from wife details
        $wifeBirthdays = $query->whereHas('wifeDetail', function($q) use ($today) {
            $q->whereNotNull('birth_date')
              ->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today]);
        })->with(['wifeDetail', 'countries', 'states', 'cities'])->get();

        // Query for birthdays today from families table
        $familyBirthdays = Family::whereNotNull('birth_date')
            ->whereHas('lead', function($q) use ($request) {
                if ($request->has('country') && $request->country) {
                    $q->where('country', $request->country);
                }
                if ($request->has('state') && $request->state) {
                    $q->where('state', $request->state);
                }
                if ($request->has('city') && $request->city) {
                    $q->where('city', $request->city);
                }
            })
            ->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today])
            ->with(['lead.countries', 'lead.states', 'lead.cities'])
            ->get();

        // Combine and format the data
        $birthdays = collect();
        
        // Add lead birthdays
        foreach ($leadBirthdays as $lead) {
            $birthdays->push([
                'id' => $lead->id,
                'name' => $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                'birth_date' => $lead->birth_date,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'lead',
                'relation' => 'Lead'
            ]);
        }

        // Add wife birthdays
        foreach ($wifeBirthdays as $lead) {
            $birthdays->push([
                'id' => $lead->id,
                'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                'birth_date' => $lead->wifeDetail->birth_date,
                'email' => $lead->wifeDetail->email ?? $lead->email,
                'phone' => $lead->wifeDetail->phone ?? $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'wife',
                'relation' => 'Wife'
            ]);
        }

        // Add family member birthdays
        foreach ($familyBirthdays as $family) {
            $birthdays->push([
                'id' => $family->lead->id,
                'name' => $family->name,
                'birth_date' => $family->birth_date,
                'email' => $family->lead->email,
                'phone' => $family->lead->phone,
                'country' => $family->lead->countries->name ?? '',
                'state' => $family->lead->states->name ?? '',
                'city' => $family->lead->cities->name ?? '',
                'type' => 'family',
                'relation' => ucfirst($family->relation) . ' (' . ucfirst($family->belongs_to) . ')'
            ]);
        }

        $countries = Country::all();
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.birthday.today-birthday', compact('birthdays', 'countries', 'templates'));
    }

    public function allBirthdays(Request $request)
    {
        $query = Lead::isClient();
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }
        
        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }
        
        // Filter by taluka if provided
        if ($request->has('taluka') && $request->taluka) {
            $query->where('taluka', $request->taluka);
        }
        
        // Filter by village if provided
        if ($request->has('village') && $request->village) {
            $query->where('village', $request->village);
        }

        // Prepare date filter
        $dateFilter = null;
        if ($request->has('filter_date') && $request->filter_date) {
            $dateFilter = $request->filter_date;
        }

        // Get all clients with birth dates from leads table
        $leadQuery = clone $query;
        $leadBirthdays = $leadQuery->whereNotNull('birth_date');
        
        // Apply date filter
        if ($dateFilter) {
            $leadBirthdays->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
        }
        
        $leadBirthdays = $leadBirthdays->with(['countries', 'states', 'cities'])->get();

        // Get all wife details with birth dates
        $wifeQuery = clone $query;
        if ($dateFilter) {
            $wifeBirthdays = $wifeQuery->whereHas('wifeDetail', function($q) use ($dateFilter) {
                $q->whereNotNull('birth_date')
                  ->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
            });
        } else {
            $wifeBirthdays = $wifeQuery->whereHas('wifeDetail', function($q) {
                $q->whereNotNull('birth_date');
            });
        }
        $wifeBirthdays = $wifeBirthdays->with(['wifeDetail', 'countries', 'states', 'cities'])->get();

        // Get all family members with birth dates
        $familyQuery = Family::whereNotNull('birth_date');
        
        // Apply date filter
        if ($dateFilter) {
            $familyQuery->whereRaw("DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
        }
        
        $familyBirthdays = $familyQuery->whereHas('lead', function($q) use ($request) {
                if ($request->has('country') && $request->country) {
                    $q->where('country', $request->country);
                }
                if ($request->has('state') && $request->state) {
                    $q->where('state', $request->state);
                }
                if ($request->has('city') && $request->city) {
                    $q->where('city', $request->city);
                }
                if ($request->has('taluka') && $request->taluka) {
                    $q->where('taluka', $request->taluka);
                }
                if ($request->has('village') && $request->village) {
                    $q->where('village', $request->village);
                }
            })
            ->with(['lead.countries', 'lead.states', 'lead.cities'])
            ->get();

        // Combine and format the data
        $birthdays = collect();
        
        // Add lead birthdays
        foreach ($leadBirthdays as $lead) {
            $birthdays->push([
                'id' => $lead->id,
                'name' => $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                'birth_date' => $lead->birth_date,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'lead',
                'relation' => 'Lead'
            ]);
        }

        // Add wife birthdays
        foreach ($wifeBirthdays as $lead) {
            $birthdays->push([
                'id' => $lead->id,
                'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                'birth_date' => $lead->wifeDetail->birth_date,
                'email' => $lead->wifeDetail->email ?? $lead->email,
                'phone' => $lead->wifeDetail->phone ?? $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'wife',
                'relation' => 'Wife'
            ]);
        }

        // Add family member birthdays
        foreach ($familyBirthdays as $family) {
            $birthdays->push([
                'id' => $family->lead->id,
                'name' => $family->name,
                'birth_date' => $family->birth_date,
                'email' => $family->lead->email,
                'phone' => $family->lead->phone,
                'country' => $family->lead->countries->name ?? '',
                'state' => $family->lead->states->name ?? '',
                'city' => $family->lead->cities->name ?? '',
                'type' => 'family',
                'relation' => ucfirst($family->relation) . ' (' . ucfirst($family->belongs_to) . ')'
            ]);
        }

        $countries = Country::all();
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.birthday.all-birthday', compact('birthdays', 'countries', 'templates'));
    }

    public function todayMarriageAnniversaries(Request $request)
    {
        $query = Lead::isClient();
        
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }
        
        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }

        // Get today's date in the format stored in the database (Y-m-d)
        $today = now()->format('Y-m-d');
        
        // Get clients with marriage anniversaries today from leads table
        $leadAnniversaries = $query->whereNotNull('marriage_date')
            ->whereRaw("DATE_FORMAT(marriage_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today])
            ->with(['countries', 'states', 'cities'])
            ->get();

        // Get wife details with marriage anniversaries today
        $wifeAnniversaries = $query->whereHas('wifeDetail', function($q) use ($today) {
            $q->whereNotNull('marriage_date')
              ->whereRaw("DATE_FORMAT(marriage_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today]);
        })->with(['wifeDetail', 'countries', 'states', 'cities'])->get();

        // Get family members with marriage anniversaries today
        $familyAnniversaries = Family::whereNotNull('marriage_date')
            ->whereHas('lead', function($q) use ($request) {
                if ($request->has('country') && $request->country) {
                    $q->where('country', $request->country);
                }
                if ($request->has('state') && $request->state) {
                    $q->where('state', $request->state);
                }
                if ($request->has('city') && $request->city) {
                    $q->where('city', $request->city);
                }
            })
            ->whereRaw("DATE_FORMAT(marriage_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today])
            ->with(['lead.countries', 'lead.states', 'lead.cities'])
            ->get();

        // Combine and format the data
        $anniversaries = collect();
        
        // Add lead marriage anniversaries
        foreach ($leadAnniversaries as $lead) {
            $anniversaries->push([
                'id' => $lead->id,
                'name' => $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                'marriage_date' => $lead->marriage_date,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'lead',
                'relation' => 'Lead'
            ]);
        }

        // Add wife marriage anniversaries
        foreach ($wifeAnniversaries as $lead) {
            $anniversaries->push([
                'id' => $lead->id,
                'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                'marriage_date' => $lead->wifeDetail->marriage_date,
                'email' => $lead->wifeDetail->email ?? $lead->email,
                'phone' => $lead->wifeDetail->phone ?? $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'wife',
                'relation' => 'Wife'
            ]);
        }

        // Add family member marriage anniversaries
        foreach ($familyAnniversaries as $family) {
            $anniversaries->push([
                'id' => $family->lead->id,
                'name' => $family->name,
                'marriage_date' => $family->marriage_date,
                'email' => $family->lead->email,
                'phone' => $family->lead->phone,
                'country' => $family->lead->countries->name ?? '',
                'state' => $family->lead->states->name ?? '',
                'city' => $family->lead->cities->name ?? '',
                'type' => 'family',
                'relation' => ucfirst($family->relation) . ' (' . ucfirst($family->belongs_to) . ')'
            ]);
        }

        $countries = Country::all();
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.marriage.today-marriage', compact('anniversaries', 'countries', 'templates'));
    }

    public function allMarriageAnniversaries(Request $request)
    {
        $query = Lead::isClient();
        
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }
        
        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }
        
        // Filter by taluka if provided
        if ($request->has('taluka') && $request->taluka) {
            $query->where('taluka', $request->taluka);
        }
        
        // Filter by village if provided
        if ($request->has('village') && $request->village) {
            $query->where('village', $request->village);
        }

        // Prepare date filter
        $dateFilter = null;
        if ($request->has('filter_date') && $request->filter_date) {
            $dateFilter = $request->filter_date;
        }

        // Get all clients with marriage dates from leads table
        $leadQuery = clone $query;
        $leadAnniversaries = $leadQuery->whereNotNull('marriage_date');
        
        // Apply date filter
        if ($dateFilter) {
            $leadAnniversaries->whereRaw("DATE_FORMAT(marriage_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
        }
        
        $leadAnniversaries = $leadAnniversaries->with(['countries', 'states', 'cities'])->get();

        // Get all wife details with marriage dates
        $wifeQuery = clone $query;
        if ($dateFilter) {
            $wifeAnniversaries = $wifeQuery->whereHas('wifeDetail', function($q) use ($dateFilter) {
                $q->whereNotNull('marriage_date')
                  ->whereRaw("DATE_FORMAT(marriage_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
            });
        } else {
            $wifeAnniversaries = $wifeQuery->whereHas('wifeDetail', function($q) {
                $q->whereNotNull('marriage_date');
            });
        }
        $wifeAnniversaries = $wifeAnniversaries->with(['wifeDetail', 'countries', 'states', 'cities'])->get();

        // Get all family members with marriage dates
        $familyQuery = Family::whereNotNull('marriage_date');
        
        // Apply date filter
        if ($dateFilter) {
            $familyQuery->whereRaw("DATE_FORMAT(marriage_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
        }
        
        $familyAnniversaries = $familyQuery->whereHas('lead', function($q) use ($request) {
                if ($request->has('country') && $request->country) {
                    $q->where('country', $request->country);
                }
                if ($request->has('state') && $request->state) {
                    $q->where('state', $request->state);
                }
                if ($request->has('city') && $request->city) {
                    $q->where('city', $request->city);
                }
                if ($request->has('taluka') && $request->taluka) {
                    $q->where('taluka', $request->taluka);
                }
                if ($request->has('village') && $request->village) {
                    $q->where('village', $request->village);
                }
            })
            ->with(['lead.countries', 'lead.states', 'lead.cities'])
            ->get();

        // Combine and format the data
        $anniversaries = collect();
        
        // Add lead marriage anniversaries
        foreach ($leadAnniversaries as $lead) {
            $anniversaries->push([
                'id' => $lead->id,
                'name' => $lead->first_name . ' ' . $lead->middle_name . ' ' . $lead->last_name,
                'marriage_date' => $lead->marriage_date,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'lead',
                'relation' => 'Lead'
            ]);
        }

        // Add wife marriage anniversaries
        foreach ($wifeAnniversaries as $lead) {
            $anniversaries->push([
                'id' => $lead->id,
                'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                'marriage_date' => $lead->wifeDetail->marriage_date,
                'email' => $lead->wifeDetail->email ?? $lead->email,
                'phone' => $lead->wifeDetail->phone ?? $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'wife',
                'relation' => 'Wife'
            ]);
        }

        // Add family member marriage anniversaries
        foreach ($familyAnniversaries as $family) {
            $anniversaries->push([
                'id' => $family->lead->id,
                'name' => $family->name,
                'marriage_date' => $family->marriage_date,
                'email' => $family->lead->email,
                'phone' => $family->lead->phone,
                'country' => $family->lead->countries->name ?? '',
                'state' => $family->lead->states->name ?? '',
                'city' => $family->lead->cities->name ?? '',
                'type' => 'family',
                'relation' => ucfirst($family->relation) . ' (' . ucfirst($family->belongs_to) . ')'
            ]);
        }

        $countries = Country::all();
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.marriage.all-marriage', compact('anniversaries', 'countries', 'templates'));
    }

    public function todayDeathAnniversaries(Request $request)
    {
        $query = Lead::isClient();
        
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }
        
        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }

        // Get today's date in the format stored in the database (Y-m-d)
        $today = now()->format('Y-m-d');
        
        // Get wife details with death anniversaries today
        $wifeAnniversaries = $query->whereHas('wifeDetail', function($q) use ($today) {
            $q->whereNotNull('death_date')
              ->whereRaw("DATE_FORMAT(death_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today]);
        })->with(['wifeDetail', 'countries', 'states', 'cities'])->get();

        // Get family members with death anniversaries today
        $familyAnniversaries = Family::whereNotNull('death_date')
            ->whereHas('lead', function($q) use ($request) {
                if ($request->has('country') && $request->country) {
                    $q->where('country', $request->country);
                }
                if ($request->has('state') && $request->state) {
                    $q->where('state', $request->state);
                }
                if ($request->has('city') && $request->city) {
                    $q->where('city', $request->city);
                }
            })
            ->whereRaw("DATE_FORMAT(death_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$today])
            ->with(['lead.countries', 'lead.states', 'lead.cities'])
            ->get();

        // Combine and format the data
        $anniversaries = collect();
        
        // Add wife death anniversaries
        foreach ($wifeAnniversaries as $lead) {
            $anniversaries->push([
                'id' => $lead->id,
                'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                'death_date' => $lead->wifeDetail->death_date,
                'email' => $lead->wifeDetail->email ?? $lead->email,
                'phone' => $lead->wifeDetail->phone ?? $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'wife',
                'relation' => 'Wife'
            ]);
        }

        // Add family member death anniversaries
        foreach ($familyAnniversaries as $family) {
            $anniversaries->push([
                'id' => $family->lead->id,
                'name' => $family->name,
                'death_date' => $family->death_date,
                'email' => $family->lead->email,
                'phone' => $family->lead->phone,
                'country' => $family->lead->countries->name ?? '',
                'state' => $family->lead->states->name ?? '',
                'city' => $family->lead->cities->name ?? '',
                'type' => 'family',
                'relation' => ucfirst($family->relation) . ' (' . ucfirst($family->belongs_to) . ')'
            ]);
        }

        $countries = Country::all();
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.death.today-death', compact('anniversaries', 'countries', 'templates'));
    }

    public function allDeathAnniversaries(Request $request)
    {
        $query = Lead::isClient();
        
        // Filter by country if provided
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        // Filter by state if provided
        if ($request->has('state') && $request->state) {
            $query->where('state', $request->state);
        }
        
        // Filter by city if provided
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }
        
        // Filter by taluka if provided
        if ($request->has('taluka') && $request->taluka) {
            $query->where('taluka', $request->taluka);
        }
        
        // Filter by village if provided
        if ($request->has('village') && $request->village) {
            $query->where('village', $request->village);
        }

        // Prepare date filter
        $dateFilter = null;
        if ($request->has('filter_date') && $request->filter_date) {
            $dateFilter = $request->filter_date;
        }

        // Get all wife details with death dates
        $wifeQuery = clone $query;
        if ($dateFilter) {
            $wifeAnniversaries = $wifeQuery->whereHas('wifeDetail', function($q) use ($dateFilter) {
                $q->whereNotNull('death_date')
                  ->whereRaw("DATE_FORMAT(death_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
            });
        } else {
            $wifeAnniversaries = $wifeQuery->whereHas('wifeDetail', function($q) {
                $q->whereNotNull('death_date');
            });
        }
        $wifeAnniversaries = $wifeAnniversaries->with(['wifeDetail', 'countries', 'states', 'cities'])->get();

        // Get all family members with death dates
        $familyQuery = Family::whereNotNull('death_date');
        
        // Apply date filter
        if ($dateFilter) {
            $familyQuery->whereRaw("DATE_FORMAT(death_date, '%m-%d') = DATE_FORMAT(?, '%m-%d')", [$dateFilter]);
        }
        
        $familyAnniversaries = $familyQuery->whereHas('lead', function($q) use ($request) {
                if ($request->has('country') && $request->country) {
                    $q->where('country', $request->country);
                }
                if ($request->has('state') && $request->state) {
                    $q->where('state', $request->state);
                }
                if ($request->has('city') && $request->city) {
                    $q->where('city', $request->city);
                }
                if ($request->has('taluka') && $request->taluka) {
                    $q->where('taluka', $request->taluka);
                }
                if ($request->has('village') && $request->village) {
                    $q->where('village', $request->village);
                }
            })
            ->with(['lead.countries', 'lead.states', 'lead.cities'])
            ->get();

        // Combine and format the data
        $anniversaries = collect();
        
        // Add wife death anniversaries
        foreach ($wifeAnniversaries as $lead) {
            $anniversaries->push([
                'id' => $lead->id,
                'name' => $lead->wifeDetail->first_name . ' ' . $lead->wifeDetail->middle_name . ' ' . $lead->wifeDetail->last_name,
                'death_date' => $lead->wifeDetail->death_date,
                'email' => $lead->wifeDetail->email ?? $lead->email,
                'phone' => $lead->wifeDetail->phone ?? $lead->phone,
                'country' => $lead->countries->name ?? '',
                'state' => $lead->states->name ?? '',
                'city' => $lead->cities->name ?? '',
                'type' => 'wife',
                'relation' => 'Wife'
            ]);
        }

        // Add family member death anniversaries
        foreach ($familyAnniversaries as $family) {
            $anniversaries->push([
                'id' => $family->lead->id,
                'name' => $family->name,
                'death_date' => $family->death_date,
                'email' => $family->lead->email,
                'phone' => $family->lead->phone,
                'country' => $family->lead->countries->name ?? '',
                'state' => $family->lead->states->name ?? '',
                'city' => $family->lead->cities->name ?? '',
                'type' => 'family',
                'relation' => ucfirst($family->relation) . ' (' . ucfirst($family->belongs_to) . ')'
            ]);
        }

        $countries = Country::all();
        $templates = EmailTemplate::all();
        
        return view('admin.mass-email.death.all-death', compact('anniversaries', 'countries', 'templates'));
    }
} 