<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and process new emails from the mailbox.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch emails using webklex/laravel-imap
        $client = \Webklex\IMAP\Client::account('default');
        $client->connect();

        $folder = $client->getFolder('INBOX');
        $messages = $folder->messages()->unseen()->get();

        foreach ($messages as $message) {
            $emailData = [
                'uid' => $message->getUid(),
                'from' => $message->getFrom()[0]->mail ?? null,
                'subject' => $message->getSubject(),
                'body' => $message->getTextBody(),
                'headers' => $message->getHeaders()->toArray(),
            ];
            // Dispatch job for each email
            \App\Jobs\ProcessEmailJob::dispatch($emailData);
            // Mark as seen
            $message->setFlag(['Seen']);
        }

        $this->info('Processed ' . count($messages) . ' new emails.');
        return Command::SUCCESS;
    }
}
