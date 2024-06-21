<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">

            <!-- Donation Match Details Section -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0 shadow">
                        <div class="d-flex justify-content-between p-4">
                            <h6 class="fw-bold mb-0">Donation Match Details</h6>
                            <a href="{{ route('dashboard.donation.matches') }}" class="btn btn-secondary btn-sm">Back to Matches</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6>Donor Information</h6>
                                    <p><strong>Name:</strong> {{ $match->donor->name }}</p>
                                    <p><strong>Email:</strong> {{ $match->donor->email }}</p>
                                    <p><strong>Phone:</strong> {{ $match->donor->phone }}</p>
                                    <p><strong>Blood Type:</strong> {{ $match->donor->blood_type }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Recipient Information</h6>
                                    <p><strong>Name:</strong> {{ $match->recipient->name }}</p>
                                    <p><strong>Email:</strong> {{ $match->recipient->email }}</p>
                                    <p><strong>Phone:</strong> {{ $match->recipient->phone }}</p>
                                    <p><strong>Blood Type:</strong> {{ $match->recipient->blood_type }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6>Match Details</h6>
                                    <p><strong>Blood Type:</strong> {{ $match->blood_type }}</p>
                                    <p><strong>Status:</strong> {{ $match->status }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if($match->status == 'CONFIRMED')
                                        <a href="#" class="btn btn-primary">Track</a>
                                    @endif
                                    <form action="{{ route('dashboard.donation.matches.delete', $match->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this match?')">Delete Match</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div><!--end container-->

</x-app-layout>
