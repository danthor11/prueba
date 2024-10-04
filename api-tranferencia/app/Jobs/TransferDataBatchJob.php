<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\EmployeeBackup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TransferDataBatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $batch;

    /**
     * Create a new job instance.
     */
    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->batch as $employee) {
            // EmployeeBackup::create([
            //     "email" => $employee->email,
            //     "name" => $employee->name,
            //     "birthday" => $employee->birthday
            // ]);
            DB::table('employee_backups')->insert([
                "email" => $employee->email,
                "name" => $employee->name,
                "birthday" => $employee->birthday
            ]);
        }
    }
}
