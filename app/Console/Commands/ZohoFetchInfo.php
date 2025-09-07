<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZohoDeskService;

class ZohoFetchInfo extends Command
{
    protected $signature = 'zoho:fetch-info';
    protected $description = 'Fetch Zoho Desk Org ID and Department IDs using OAuth';

    public function handle()
    {
        $zoho = app(ZohoDeskService::class);
        $orgId = env('ZOHO_DESK_ORG_ID');
        $this->info('Your .env ZOHO_DESK_ORG_ID: ' . ($orgId ?: '[not set]'));

        $departments = $zoho->getDepartments();
        if (isset($departments['data'])) {
            $this->info("Departments:");
            foreach ($departments['data'] as $dept) {
                $this->line("- {$dept['name']} (ID: {$dept['id']})");
            }
        } else {
            $this->error('Could not fetch departments. Check your credentials and refresh token.');
        }
    }
}
