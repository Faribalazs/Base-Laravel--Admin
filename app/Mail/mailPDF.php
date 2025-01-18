<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class mailPDF extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailSubject;
    protected $mailBody;
    protected $pdf;
    protected $pdfName;
    protected $autoMsg;

    public function __construct($mailSubject, $mailBody, $pdf, $pdfName, $autoMsg)
    {
        $this->mailSubject = $mailSubject;
        $this->mailBody = $mailBody;
        $this->pdf = $pdf;
        $this->pdfName = $pdfName;
        $this->autoMsg = $autoMsg;
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.email'), config('app.name')),
            subject: $this->mailSubject ?? $this->pdfName ?? config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'worker.emails.send_pdf',
            with: [
                'auto_msg' => $this->autoMsg,
                'mailBody' => $this->mailBody,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if($this->pdf['pdf_blade'] == 'worker.pdf.contract-individual' || $this->pdf['pdf_blade'] == 'worker.pdf.contract-legal-entity')
        {
            return [
                Attachment::fromData(fn () => PDF::loadView($this->pdf['pdf_blade'],['fields' => $this->pdf['mergedData'], 'ugovorBr' => $this->pdf['ponuda_name']])->output(), 'Ugovor.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        else{
            return [
                Attachment::fromData(fn () => PDF::loadView($this->pdf['pdf_blade'],['mergedData' => $this->pdf['mergedData'], 'ponuda_name' => $this->pdf['ponuda_name'], 'company' => $this->pdf['company'], 'client' => $this->pdf['client'], 'type' => $this->pdf['type'], 'opis' => $this->pdf['opis']])->output(), $this->pdfName . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }
    }
}
