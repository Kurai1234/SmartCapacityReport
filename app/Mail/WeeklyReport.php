<?php

namespace App\Mail;

use App\Exports\PeakCapacityThroughputWithDatesExportMapping;
use App\Exports\AccessPointStatsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class WeeklyReport extends Mailable
{
    use Queueable, SerializesModels;
    public $username;
    public $start_time;
    public $end_time;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $start_time, $end_time)
    {
        $this->username = $username;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        //
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.weekly.report')
            ->attach(
                Excel::download(
                    new AccessPointStatsExport([$this->start_time, $this->end_time], '')
                )->getFile(),
                ['as' => 'WeeklyReport' . Carbon::now() . '.xlsx']
            )
            ->with([
                'username' => $this->username,
            ]);
    }
}
