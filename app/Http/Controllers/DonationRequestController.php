<?php

namespace App\Http\Controllers;

use App\Enums\Status\DonationAppointmentStatus;
use App\Enums\Status\DonationRequestStatus;
use App\Enums\Status\DonationStatus;
use App\Enums\UrgencyLevel;
use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class DonationRequestController extends Controller
{
    /**
     * Display a listing of donation requests.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        // Retrieve the authenticated user
        $user = $request->user();

        // Retrieve search query parameter
        $search = $request->input('search');

        // Initialize query builder based on user permissions
        if ($user->can('isAdmin', User::class)) {
            // Admin can see all donation requests
            $query = DonationRequest::with('recipient');
        } else {
            // Non-admin users see only their own donation requests
            $query = DonationRequest::with('recipient')
                ->where('user_id', $user->id);
        }

        // Apply search filtering if search query is present
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('recipient', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('blood_type', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('notes', 'like', "%$search%");
            });
        }

        // Paginate the results and include query string parameters in pagination links
        $requests = $query->paginate(10)->withQueryString();

        // Pass donation requests data to the view
        return response()->view('dashboard.donations.requests.index', compact('requests'));
    }

    /**
     * Display the specified donation request.
     *
     * @param int $id
     * @return Response|RedirectResponse
     */
    public function show(int $id): Response|RedirectResponse
    {
        try {
            // Retrieve the donation request with the given ID including recipient information
            $donationRequest = DonationRequest::with('recipient')->findOrFail($id);

            // Return the view with donation request data
            return response()->view('dashboard.donations.requests.show', compact('donationRequest'));
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if donation request is not found
            return back()->with("error", "Donation request not found");
        }
    }

    /**
     * Show the form for editing the specified donation request.
     *
     * @param int $id
     * @return Response|RedirectResponse
     */
    public function edit(int $id): Response|RedirectResponse
    {
        try {
            // Retrieve the donation request with the given ID including recipient information
            $donationRequest = DonationRequest::with('recipient')->findOrFail($id);

            // Retrieve urgency levels and blood types
            $urgencyLevels = Arr::map(UrgencyLevel::cases(), fn($level) => $level->name);
            $bloodTypes = Utils::BLOOD_TYPE;

            // Return the view with donation request data, urgency levels, and blood types
            return response()->view('dashboard.donations.requests.edit', compact('donationRequest', 'urgencyLevels', 'bloodTypes'));
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if donation request is not found
            return back()->with("error", "Donation request not found");
        }
    }

    /**
     * Update the specified donation request in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            // Retrieve the donation request with the given ID
            $donationRequest = DonationRequest::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'blood_type' => 'required|string|max:3',
                'amount' => 'required|integer',
                'notes' => 'nullable|string',
                'urgency_level' => 'required|in:' . implode(',', Arr::pluck(UrgencyLevel::cases(), 'name')),
            ]);

            // Update the donation request with validated data
            $donationRequest->update($validatedData);

            // Redirect to the donation request show page with success message
            return redirect()->route('dashboard.donations.requests.show', $donationRequest->id)
                ->with('success', 'Donation request updated successfully.');
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if donation request is not found
            return back()->with("error", "Donation request not found");
        }
    }

    /**
     * Remove the specified donation request from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Retrieve the donation request with the given ID
            $donationRequest = DonationRequest::findOrFail($id);

            // Delete the donation request
            $donationRequest->delete();

            // Redirect to the donation requests index page with success message
            return redirect()->route('dashboard.donations.requests.index')
                ->with('success', 'Donation request deleted successfully.');
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if donation request is not found
            return back()->with("error", "Donation request not found");
        }
    }

    /**
     * Show the form for creating a new donation request.
     *
     * @return Response
     */
    public function create(): Response
    {
        // Retrieve urgency levels and blood types for the form
        $urgencyLevels = Arr::map(UrgencyLevel::cases(), fn($level) => $level->name);
        $bloodTypes = Utils::BLOOD_TYPE;

        // Return the view with urgency levels and blood types data
        return response()->view('dashboard.donations.requests.create', compact('urgencyLevels', 'bloodTypes'));
    }

    /**
     * Store a newly created donation request in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request): RedirectResponse | Response
    {
        try {
            // Retrieve the logged-in user and check if admin
            $user = $request->user();
            $isAdmin = $user->can('isAdmin', User::class);

            // Validate request data
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'urgency_level' => 'required|in:' . implode(',', Arr::pluck(UrgencyLevel::cases(), 'name')),
                'notes' => 'nullable|string|max:255',
                'blood_type' => $isAdmin ? 'required' : 'nullable', // Conditionally require blood_type based on admin status
            ]);

            // Determine blood type based on admin status
            $bloodType = $isAdmin ? $request->input('blood_type') : $user->blood_type;

            // Create new donation request
            $donationRequest = DonationRequest::create([
                'user_id' => $user->id,
                'blood_type' => $bloodType,
                'amount' => $request->input('amount'),
                'urgency_level' => Arr::first(UrgencyLevel::cases(), fn($level) => strcasecmp($level->name, $request->input('urgency_level')) === 0)->name,
                'notes' => $request->input('notes'),
                'status' => DonationRequestStatus::PENDING,
            ]);

            // Fetch available donations for matching
            $availableDonations = Donation::query()
                ->where('status', DonationStatus::CREATED)
                ->when($bloodType, function ($query, $bloodType) {
                    return $query->whereIn('blood_type', Utils::BLOOD_MATCH[$bloodType]);
                })
                ->paginate(10);

            // Return view with matched donations and donation request details
            return response()->view('dashboard.donations.requests.match', compact('availableDonations', 'donationRequest'));

        } catch (\Exception $exception) {
            // Handle unexpected errors and redirect back with error message
            return back()->with('error', 'An unexpected error occurred while processing your request.');
        }
    }

    /**
     * Delete the specified donation request from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {
            // Retrieve the donation request with the given ID
            $request = DonationRequest::findOrFail($id);

            // Delete the donation request
            $request->delete();

            // Redirect to the donation requests index page with success message
            return redirect()->route('dashboard.donations.requests')->with('success', 'Donation request deleted successfully.');

        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if donation request is not found
            return back()->with('error', 'Donation request not found.');
        }
    }

    /**
     * Retrieve available donations for a donation request based on request ID or request code.
     *
     * @param  Request  $request
     * @return Response|RedirectResponse
     */
    public function getDonations(Request $request): Response | RedirectResponse
    {
        $donationRequest = null;

        try {
            // Attempt to find donation request by request ID
            if ($request->requestId) {
                $donationRequest = DonationRequest::findOrFail($request->requestId);
            }
            // Attempt to find donation request by request code
            elseif ($request->has('request_code')) {
                $donationRequest = DonationRequest::where('code', $request->input('request_code'))->first();
            }

            // If a valid donation request is found
            if ($donationRequest) {
                // Fetch available donations based on criteria
                $availableDonations = Donation::where('status', DonationStatus::CREATED)
                    ->when($donationRequest->blood_type, function ($query, $bloodType) {
                        return $query->whereIn('blood_type', Utils::BLOOD_MATCH[$bloodType]);
                    })
                    ->paginate(10);

                // Return view with matched donations and donation request details
                return response()->view('dashboard.donations.requests.match', compact('availableDonations', 'donationRequest'));
            }

            // Redirect back with error message for invalid request
            return back()->with('error', 'Invalid request');

        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if donation request is not found
            return back()->with('error', 'Invalid request');
        }
    }
}
