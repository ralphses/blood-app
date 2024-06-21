<?php

namespace App\Http\Controllers;

use App\Enums\Status\DonationMatchStatus;
use App\Models\DonationMatch;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DonationMatchController extends Controller
{

    /**
     * Display a listing of donation matches based on user permissions and search criteria.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $search = $request->input('search');

        // Initialize the query to fetch donation matches with donor and recipient relationships
        if ($user->can('isAdmin', User::class)) {
            // Fetch all donation matches for admin users
            $query = DonationMatch::with(['donor', 'recipient']);
        } else {
            // Fetch donation matches for non-admin users based on donor or recipient ID
            $query = DonationMatch::with(['donor', 'recipient'])
                ->where(function ($q) use ($user) {
                    $q->where('donor_id', $user->id)
                        ->orWhere('recipient_id', $user->id);
                });
        }

        // Apply search filtering if search criteria is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('donor', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhereHas('recipient', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('status', 'like', "%$search%")
                    ->orWhere('blood_type', "$search");
            });
        }

        // Paginate the results and maintain query string parameters
        $matches = $query->paginate(10)->withQueryString();

        // Pass donation matches data to the view
        return response()->view('dashboard.donations.matches.index', compact('matches'));
    }

    /**
     * Cancel a specific donation match based on user permissions.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response|RedirectResponse
     */
    public function cancel(Request $request, $id): Response|RedirectResponse
    {
        try {
            // Retrieve the donation match based on the match ID from the request
            $match = DonationMatch::findOrFail($id);

            // Ensure only admins or relevant users can cancel the donation match
            if ($request->user()->can('isAdmin', User::class) || $request->user()->id() === $match->donor_id || $request->user()->id() === $match->recipient_id) {
                // Update the status of the donation match to declined
                $match->status = DonationMatchStatus::DECLINED;
                $match->save();

                // Redirect back to donation matches index with success message
                return redirect()->route('dashboard.donation.matches')->with('success', 'Donation match canceled successfully.');
            }

            // Redirect back with an error message if the user is not authorized
            return redirect()->route('dashboard.donation-matches')->with('error', 'Unauthorized action.');
        } catch (ModelNotFoundException $exception) {
            // Redirect back with an error message if the donation match ID is not found
            return redirect()->route('dashboard.donation-matches')->with('error', 'Unauthorized action.');
        }
    }

    /**
     * Show the details of a specific donation match.
     *
     * @param  Request  $request
     * @return Response|RedirectResponse
     */
    public function show(Request $request): Response|RedirectResponse
    {
        try {
            // Fetch the donation match with the given match ID
            $match = DonationMatch::with(['donor', 'recipient'])->findOrFail($request->matchId);

            // Pass the donation match data to the view
            return response()->view('dashboard.donations.matches.show', compact('match'));
        } catch (ModelNotFoundException $exception) {
            // Redirect back with an error message if the donation match ID is not found
            return back()->with("error", "Invalid request");
        }
    }
}
