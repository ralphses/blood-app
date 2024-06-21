<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Donation;
use App\Models\DonationAppointment;
use App\Models\DonationMatch;
use App\Models\DonationRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * Display the index page listing all users with optional search functionality.
     *
     * @param  Request  $request
     * @return Response | RedirectResponse
     */
    public function index(Request $request): Response | RedirectResponse
    {
        // Check if the current user is not an admin, redirect back if not authorized
        if ($request->user()->cannot('isAdmin', User::class)) {
            return back();
        }

        // Retrieve search input from request
        $search = $request->input('search');

        // Initialize the query to fetch users
        $query = User::query();

        // Apply search filtering if search term is provided
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%")
                    ->orWhere('role', 'LIKE', "%$search%")
                    ->orWhere('blood_type', 'LIKE', "%$search%");
            });
        }

        // Paginate the results and include query string in pagination links
        $users = $query->paginate(10)->withQueryString();

        // Return view with paginated users data
        return response()->view("dashboard.users.all", compact('users'));
    }

    /**
     * Display detailed information about a specific user, including their donations and donation requests.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id): Response
    {
        // Retrieve the user with their donations and donation requests based on the provided ID
        $user = User::with(['donations', 'donationRequests'])->findOrFail($id);

        // Paginate the user's donations and donation requests for display
        $donations = $user->donations()->paginate(5);
        $donationRequests = $user->donationRequests()->paginate(5);

        // Return view with user details, donations, and donation requests
        return response()->view('dashboard.users.show', compact('user', 'donations', 'donationRequests'));
    }

    /**
     * Display the dashboard home page with statistics based on user role.
     *
     * @param  Request  $request
     * @return Response
     */
    public function dashboard(Request $request): Response
    {
        $user = $request->user();
        $data = [];

        // Check user roles to determine which statistics to display
        if ($user->can('isAdmin', User::class)) {

            // Admin role: Fetch statistics for appointments, users, donations, donation matches, and donation requests
            $data['appointments'] = $this->getStats(DonationAppointment::query(), 'status');
            $data['users'] = $this->getStats(User::query(), 'role');
            $data['donations'] = $this->getStats(Donation::query(), 'status');
            $data['donation-match'] = $this->getStats(DonationMatch::query(), 'status');
            $data['donation-requests'] = $this->getStats(DonationRequest::query(), 'status');

        } elseif ($user->can('isDonor', User::class)) {

            // Donor role: Fetch statistics for appointments and donations specific to the donor
            $data['appointments'] = $this->getStats($user->donationAppointments(), 'status');
            $data['donations'] = $this->getStats($user->donations(), 'status');

        } else {

            // Recipient role: Fetch statistics for appointments and donation requests specific to the recipient
            $data['appointments'] = $this->getStats($user->donationAppointments(), 'status');
            $data['donation-requests'] = $this->getStats($user->donationRequests(), 'status');
        }

        // Return the dashboard view with compacted data
        return response()->view('dashboard.home', compact('data'));
    }

    /**
     * Get statistics based on the provided query and group by field.
     *
     * @param  mixed  $query
     * @param  string  $groupByField
     * @return array
     */
    private function getStats($query, $groupByField): array
    {
        // Retrieve statistics by selecting count grouped by the specified field
        $stats = $query->select($groupByField, DB::raw('count(*) as count'))
            ->groupBy($groupByField)
            ->pluck('count', $groupByField)
            ->toArray();

        // Calculate total count of statistics
        $count = array_sum($stats);

        // Return statistics array with stats and total count
        return ['stats' => $stats, 'count' => $count];
    }

    /**
     * Display the change role form for a specific user.
     *
     * @param  Request  $request
     * @return Response | RedirectResponse
     */
    public function showRole(Request $request): Response | RedirectResponse
    {
        try {
            // Attempt to find the user with the given ID
            $user = User::findOrFail($request->userId);

            // Retrieve all available roles
            $roles = Arr::pluck(Role::cases(), 'name');

            // Return the view with user and roles data
            return response()->view('dashboard.users.change-role', compact('user', 'roles'));
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if user is not found
            return back()->withErrors(['user' => 'User not found']);
        }
    }

    /**
     * Store the updated role for a specific user.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function storeRole(Request $request): RedirectResponse
    {
        // Validate request parameters
        $request->validate([
            'userId' => 'required|exists:users,id',
            'role' => 'required|in:' . implode(',', Arr::pluck(Role::cases(), 'name')),
        ]);

        try {
            // Retrieve the user with the given ID
            $user = User::findOrFail($request->userId);

            // Update the user's role
            $user->update(['role' => $request->input('role')]);

            // Redirect to the users index page after successful update
            return redirect()->route('dashboard.users');
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if user is not found
            return back()->withErrors(['role' => 'User not found']);
        } catch (Exception $exception) {
            // Redirect back with error message for unexpected errors
            return back()->withErrors(['role' => 'An unexpected error occurred']);
        }
    }

    /**
     * Delete a specific user.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        // Validate request parameters
        $request->validate(['userId' => 'required|exists:users,id']);

        try {
            // Retrieve the user with the given ID
            $user = User::findOrFail($request->userId);

            // Delete the user
            $user->delete();

            // Redirect to the users index page after successful deletion
            return redirect()->route('dashboard.users');
        } catch (ModelNotFoundException $exception) {
            // Redirect back with error message if user is not found
            return back()->withErrors(['user' => 'User not found']);
        } catch (Exception $exception) {
            // Redirect back with error message for unexpected errors
            return back()->withErrors(['user' => 'An unexpected error occurred']);
        }
    }
}
