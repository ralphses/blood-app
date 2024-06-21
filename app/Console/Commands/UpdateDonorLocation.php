<?php

namespace App\Console\Commands;

use App\Models\DonationAppointment;
use Illuminate\Console\Command;

class UpdateDonorLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $location = DonationAppointment::findOrFail(10)->location;

        $location->latitude += $this->generateIncrement(); // Define generateIncrement() method
        $location->longitude += $this->generateIncrement(); // Define generateIncrement() method
        $location->save();
    }

    private function generateIncrement(): float|int
    {
        // Generate a small increment (e.g., between -0.001 to 0.001 degrees)
        return mt_rand(-100, 100) / 100000;
    }
}
