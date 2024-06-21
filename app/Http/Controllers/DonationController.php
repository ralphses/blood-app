<?php

namespace App\Http\Controllers;

use App\Enums\Status\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Nette\Utils\Random;

class DonationController extends Controller
{
    /**
     * Display a listing of donations based on user permissions and search criteria.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        // Initialize the query to fetch donations with user relationships
        $query = Donation::with('user');

        // Check if the logged-in user is a donor
        if ($request->user()->can('isDonor', User::class)) {
            // Fetch only donations for this specific donor
            $query->where('user_id', auth()->id());
        } else {
            // Fetch donations based on search criteria if provided
            if ($search = $request->input('search')) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('status', 'like', "%$search%");
            }
        }

        // Paginate the results
        $donations = $query->paginate(10);

        // Return view with donations data
        return response()->view('dashboard.donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new donation.
     *
     * @return Response
     */
    public function create(): Response
    {
        // Retrieve blood types from utility class
        $bloodTypes = Utils::BLOOD_TYPE;

        // Return view with blood types data
        return response()->view('dashboard.donations.create', compact('bloodTypes'));
    }

    /**
     * Store a newly created donation in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $isAdmin = $user->can('isAdmin', User::class);

        // Validate the incoming request data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'blood_type' => [
                Rule::requiredIf($isAdmin),
                Rule::in(array_keys(Utils::BLOOD_TYPE))
            ]
        ]);

        // Create a new donation record in the database
        Donation::create([
            'user_id' => $user->id,
            'code' => Str::upper(Str::random()), // Generate a random code for the donation
            'amount' => $request->input('amount'),
            'blood_type' => $isAdmin ? $request->input('blood_type') : $user->blood_type,
            'status' => DonationStatus::CREATED,
        ]);

        // Redirect back to donations index with success message
        return redirect()->route('dashboard.donations')->with('success', 'Donation created successfully');
    }

    /**
     * Cancel a specific donation based on user permissions.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function cancel(Request $request): RedirectResponse
    {
        try {
            // Retrieve the donation based on the donation ID from the request
            $donation = Donation::findOrFail($request->donationId);

            // Check if the logged-in user is authorized to cancel the donation
            if ($request->user()->id === $donation->user_id || $request->user()->can('isAdmin', User::class)) {
                // Update the status of the donation to canceled
                $donation->status = DonationStatus::CANCELED;
                $donation->save();

                // Redirect back to donations index with success message
                return redirect()->route('dashboard.donations')->with('success', 'Donation has been cancelled successfully.');
            }

            // Redirect back with an error message if the user is not authorized
            return redirect()->route('dashboard.donations')->with('error', 'You are not authorized to cancel this donation.');
        } catch (ModelNotFoundException $exception) {
            // Redirect back with an error message if the donation ID is not found
            return redirect()->route('dashboard.donations')->with('error', 'You are not authorized to cancel this donation.');
        }
    }
}
