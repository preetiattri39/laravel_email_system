<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message     = $this->message;
        $messageId   = $message['uid'] ?? \Illuminate\Support\Str::uuid()->toString();
        $fromEmail   = $message['from'];
        $fromName    = $message['from'] ?? 'Unknown';
        $subject     = $message['subject'] ?? '(no subject)';
        $body        = $message['body'] ?? '';
        $headers     = json_encode($message);

        // Prevent duplicates
        if (\App\Models\Email::where('message_id', $messageId)->exists()) {
            return;
        }

        \DB::transaction(function () use (
            $messageId, $fromName, $fromEmail, $subject, $body, $headers
        ) {
            // 1. Save email record
            $email = \App\Models\Email::create([
                'message_id' => $messageId,
                'from_name'  => $fromName,
                'from_email' => $fromEmail,
                'subject'    => $subject,
                'body'       => $body,
                'headers'    => $headers,
            ]);

            // 2. Create or update Lead
            $lead = \App\Models\Lead::updateOrCreate(
                ['email' => $fromEmail],
                ['name'  => $fromName, 'uuid' => (string) \Illuminate\Support\Str::uuid()]
            );

            $email->lead()->associate($lead);
            $email->save();

            // 3. Keyword detection
            $hay        = mb_strtolower($subject . ' ' . strip_tags($body));
            $foundIssue = collect(config('email_rules.issue_keywords'))
                            ->contains(fn($k) => mb_stripos($hay, mb_strtolower($k)) !== false);
            $foundSales = collect(config('email_rules.sales_keywords'))
                            ->contains(fn($k) => mb_stripos($hay, mb_strtolower($k)) !== false);

            // 4. Decision table
            if ($this->isInternal($fromEmail)) {
                // skip internal
                return;
            }

            if ($foundIssue && !$foundSales) {
                // Issue → Create ticket
                $ticket = \App\Models\Ticket::create([
                    'lead_id'   => $lead->id,
                    'email_id'  => $email->id,
                    'priority'  => 'high',
                ]);
                // Call Zoho Desk API service
                $zoho = app(\App\Services\ZohoDeskService::class);
                $response = $zoho->createTicket($subject, $fromEmail, $body, 'High');
                $ticket->zoho_ticket_id = $response['id'] ?? null;
                $ticket->save();

            } elseif ($foundSales && !$foundIssue) {
                // Sales → Forward to sales@hurak.com
                \Mail::raw($body, function ($mail) use ($fromEmail, $subject) {
                    $mail->to(config('email_rules.sales_email', env('SALES_EMAIL')))
                         ->subject($subject)
                         ->replyTo($fromEmail);
                });
                // Update timeline
                $lead->timelines()->create([
                    'type'    => 'email',
                    'message' => $body,
                ]);

            } elseif ($foundIssue && $foundSales) {
                // Both → Forward to IT
                \Mail::raw($body, function ($mail) use ($fromEmail, $subject) {
                    $mail->to(config('email_rules.it_email', env('IT_EMAIL')))
                         ->subject($subject)
                         ->replyTo($fromEmail);
                });
            }
            // else → no match, store only
        });
    }

    private function isInternal(string $email): bool
    {
        $domains = config('email_rules.internal_domains');
        foreach ($domains as $domain) {
            if (str_ends_with($email, '@' . $domain)) {
                return true;
            }
        }
        return false;
    }
}
