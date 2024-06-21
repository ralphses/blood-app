<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Donation Request Details</h6>
                        </div>
                        <div class="p-4">
                            <p><strong>Recipient Name:</strong> {{ $donationRequest->recipient->name }}</p>
                            <p><strong>Blood Type:</strong> {{ $donationRequest->blood_type }}</p>
                            <p><strong>Amount:</strong> {{ $donationRequest->amount }}</p>
                            <p><strong>Urgency Level:</strong> {{ $donationRequest->urgency_level }}</p>
                            <p><strong>Status:</strong> {{ $donationRequest->status }}</p>
                            <p><strong>Notes:</strong> {{ $donationRequest->notes }}</p>
                            <a href="{{ route('dashboard.donations.requests.edit', $donationRequest->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('dashboard.donations.requests.delete', $donationRequest->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this request?')">Delete</button>
                            </form>
                            @if($donationRequest->status == 'PENDING')
                                <a href="{{ route('dashboard.donations.requests.donations', ['requestId' => $donationRequest->id]) }}" class="btn btn-outline-primary">Find Donations</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
