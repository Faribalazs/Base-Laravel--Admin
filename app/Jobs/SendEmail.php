<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\mailPDF;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailTo;
    protected $mailSubject;
    protected $mailBody;
    protected $pdf;
    protected $pdfName;
    protected $autoMsg;

    public function __construct($mailTo, $mailSubject, $mailBody, $pdf, $pdfName, $autoMsg)
    {
        $this->mailTo = $mailTo;
        $this->mailSubject = $mailSubject;
        $this->mailBody = $mailBody;
        $this->pdf = $pdf;
        $this->pdfName = $pdfName;
        $this->autoMsg = $autoMsg;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mailTo)->send(new mailPDF($this->mailSubject, $this->mailBody, $this->pdf, $this->pdfName, $this->autoMsg));
    }
}
