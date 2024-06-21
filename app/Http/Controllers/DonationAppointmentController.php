<?php

namespace App\Http\Controllers;

use App\Enums\Status\DonationAppointmentStatus;
use App\Enums\Status\DonationMatchStatus;
use App\Models\Donation;
use App\Models\DonationAppointment;
use App\Models\DonationMatch;
use App\Models\DonationRequest;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DonationAppointmentController extends Controller
{
    /**
     * Display a listing of appointments based on user role.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        // Fetch appointments based on user role
        if ($user->can('isAdmin', User::class)) {
            // If user is admin, fetch all appointments with donor and recipient details
            $appointments = DonationAppointment::with(['donationMatch.donor', 'donationMatch.recipient'])
                ->paginate(10);
        } elseif ($user->can('isDonor', User::class)) {
            // If user is donor, fetch appointments where the donor_id matches user's id
            $appointments = DonationAppointment::with('donationMatch')
                ->whereHas('donationMatch', function ($query) use ($user) {
                    $query->where('donor_id', $user->id);
                })
                ->paginate(10);
        } else {
            // For other users (recipients), fetch appointments where the recipient_id matches user's id
            $appointments = DonationAppointment::with('donationMatch')
                ->whereHas('donationMatch', function ($query) use ($user) {
                    $query->where('recipient_id', $user->id);
                })
                ->paginate(10);
        }

        // Return appointments data to the view
        return response()->view('dashboard.appointments.index', compact('appointments'));
    }


    /**
     * Show the form for editing the specified appointment.
     *
     * @param  DonationAppointment  $appointment
     * @return Response
     */
    public function edit(DonationAppointment $appointment): Response
    {
        // Retrieve all possible statuses and map them to their names
        $statuses = Arr::map(DonationAppointmentStatus::cases(), fn($status) => $status->name);

        // Return view with appointment and statuses data
        return response()->view('dashboard.appointments.edit', compact('appointment', 'statuses'));
    }

    /**
     * Update the specified appointment.
     *
     * @param  Request  $request
     * @param  DonationAppointment  $appointment
     * @return RedirectResponse
     */
    public function update(Request $request, DonationAppointment $appointment): RedirectResponse
    {
        // Validate the incoming request data
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:' . implode(',', Arr::pluck(DonationAppointmentStatus::cases(), 'name')),
        ]);

        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($request, $appointment) {
            // Update the appointment details
            $appointment->update([
                'appointment_date' => $request->input('appointment_date'),
                'appointment_time' => $request->input('appointment_time'),
                'status' => $request->input('status'),
            ]);

            // Perform additional operations if the appointment status is 'Scheduled'
            if ($appointment->status === DonationAppointmentStatus::SCHEDULED->name) {
                $donationMatch = $appointment->donationMatch;
                $donationMatch->status = DonationMatchStatus::CONFIRMED;
                $donationMatch->save();

                // Todo: Additional operations related to scheduling
                // Todo: Send notifications, update statuses, etc.
            }
        });

        // Redirect to the appointment modification page with a success message
        return redirect()->route('dashboard.appointments.modify', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Book a donation appointment for a specific donation request.
     *
     * @param  Request  $request
     * @return Response|RedirectResponse
     */
    public function book(Request $request): Response|RedirectResponse
    {
        try {
            // Find the donation request and donation based on request parameters
            $donationRequest = DonationRequest::findOrFail($request->requestId);
            $donation = Donation::findOrFail($request->donation);

            // Return the view for booking the appointment with the donation request and donation details
            return response()->view('dashboard.appointments.request', compact('donationRequest', 'donation'));
        } catch (ModelNotFoundException $exception) {
            // Handle the case where either the donation request or donation is not found
            return back()->with('error', "Invalid Request");
        }
    }

    /**
     * Request a new donation appointment.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function requestAppointment(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'donation' => 'required|exists:donations,id',
            'donationRequest' => 'required|exists:donation_requests,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-90,90',
        ]);

        try {
            // Use a database transaction to ensure data integrity
            DB::transaction(function () use ($request, $validated) {
                // Find the donation and donation request based on validated IDs
                $donation = Donation::findOrFail($validated['donation']);
                $donationRequest = DonationRequest::findOrFail($validated['donationRequest']);

                // Create a new donation match between donor and recipient
                $donationMatch = DonationMatch::create([
                    'donor_id' => $donation->user_id,
                    'recipient_id' => $donationRequest->user_id,
                    'blood_type' => $donation->blood_type,
                    'status' => DonationMatchStatus::PENDING,
                ]);

                // Create a new location entry for the appointment
                $location = Location::create([
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'address' => $validated['location'],
                ]);

                // Create a new donation appointment record
                DonationAppointment::create([
                    'user_id' => $request->user()->id,
                    'donation_id' => $donation->id,
                    'donation_match_id' => $donationMatch->id,
                    'appointment_date' => $validated['appointment_date'],
                    'appointment_time' => $validated['appointment_time'],
                    'location_id' => $location->id,
                    'status' => DonationAppointmentStatus::REQUESTED,
                ]);
            });

            // Redirect to the donations requests index with success message
            return redirect()->route('dashboard.donations.requests')->with('success', 'Donation appointment request sent successfully');
        } catch (ModelNotFoundException $exception) {
            // Handle the case where the donation or donation request is not found
            return back()->with('error', 'Invalid Request');
        } catch (\Exception $exception) {
            // Handle other exceptions that may occur during the transaction
            return back()->with('error', 'An error occurred while processing your request');
        }
    }

    /**
     * View the tracking information for a specific appointment.
     *
     * @param  DonationAppointment  $appointment
     * @return Response
     */
    public function track(DonationAppointment $appointment): Response
    {
        // Retrieve the location associated with the appointment
        $location = $appointment->location;

        // Return the view for tracking the appointment with appointment and location details
        return response()->view('dashboard.appointments.track', compact('appointment', 'location'));
    }

    /**
     * Show JSON representation of appointment location for mapping.
     *
     * @param  DonationAppointment  $appointment
     * @return JsonResponse
     */
    public function show(DonationAppointment $appointment): JsonResponse
    {
        // Construct JSON response with appointment location details
        // Used for map
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $appointment->location->longitude,
                            $appointment->location->latitude,
                        ],
                    ],
                    'properties' => [
                        'id' => $appointment->id,
                        'title' => 'Appointment Location',
                        'description' => $appointment->location->address,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Update the location of a donation appointment.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updateLocation(Request $request): JsonResponse
    {
        // Find the donation appointment based on the input appointment ID
        $appointment = DonationAppointment::findOrFail($request->input('appointment'));

        // Update the location associated with the appointment
        $updated = $appointment->location->update([
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        // Return JSON response indicating success or failure
        return response()->json(['success' => $updated]);
    }

    /**
     * Mark a donation appointment as completed.
     *
     * @param  DonationAppointment  $appointment
     * @return RedirectResponse
     */
    public function markCompleted(DonationAppointment $appointment): RedirectResponse
    {
        // Update the status of the appointment to completed
        $appointment->update(['status' => DonationAppointmentStatus::COMPLETED]);

        // Redirect to the dashboard appointments page after marking completed
        return redirect()->route('dashboard.appointments');
    }
}
