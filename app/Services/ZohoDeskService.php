<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZohoDeskService
{
    protected $clientId;
    protected $clientSecret;
    protected $refreshToken;
    protected $orgId;
    protected $departmentId;
    protected $accessToken;

    public function __construct()
    {
        $this->clientId = env('ZOHO_CLIENT_ID');
        $this->clientSecret = env('ZOHO_CLIENT_SECRET');
        $this->refreshToken = env('ZOHO_REFRESH_TOKEN');
        $this->orgId = env('ZOHO_DESK_ORG_ID');
        $this->departmentId = env('ZOHO_DESK_DEPARTMENT_ID');
        $this->accessToken = $this->getAccessToken();

        // Auto fetch Org ID if missing
        if (!$this->orgId) {
            $this->orgId = $this->fetchOrgId();
            $this->saveEnvValue('ZOHO_DESK_ORG_ID', $this->orgId);
        }
    }

    /**
     * Get a fresh access token using the refresh token
     */
    protected function getAccessToken()
    {
        $response = Http::asForm()->post('https://accounts.zoho.in/oauth/v2/token', [
            'refresh_token' => $this->refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
        ]);

        $data = $response->json();

        if (!isset($data['access_token'])) {
            throw new \Exception('Failed to fetch access token: ' . json_encode($data));
        }

        return $data['access_token'];
    }

    /**
     * Fetch Org ID if not set
     */
    protected function fetchOrgId()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken,
        ])->get('https://desk.zoho.in/api/v1/org');

        $data = $response->json();

        if (!isset($data['orgId'])) {
            throw new \Exception('Failed to fetch Org ID: ' . json_encode($data));
        }

        return $data['orgId'];
    }

    /**
     * Fetch all departments
     */
    public function getDepartments()
    {
        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken,
        ];

        if ($this->orgId) {
            $headers['orgId'] = $this->orgId;
        }

        $response = Http::withHeaders($headers)
                        ->get('https://desk.zoho.in/api/v1/departments');

        $data = $response->json();

        if ($response->failed() || !isset($data['data'])) {
            throw new \Exception('Failed to fetch departments: ' . json_encode($data));
        }

        // Save first department as default if not set
        if (!env('ZOHO_DESK_DEPARTMENT_ID') && isset($data['data'][0]['id'])) {
            $this->saveEnvValue('ZOHO_DESK_DEPARTMENT_ID', $data['data'][0]['id']);
        }

        return $data;
    }

    /**
     * Create a ticket in Zoho Desk
     */
    public function createTicket($subject, $contactEmail, $description, $priority = 'High')
    {
        if (!$this->departmentId) {
            throw new \Exception('Department ID is missing. Fetch departments first.');
        }

        $response = Http::withHeaders([
            'orgId' => $this->orgId,
            'Authorization' => 'Zoho-oauthtoken ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post('https://desk.zoho.in/api/v1/tickets', [
            'subject' => $subject,
            'email' => $contactEmail,
            'description' => $description,
            'priority' => $priority,
            'departmentId' => $this->departmentId,
        ]);

        $data = $response->json();

        if ($response->failed()) {
            throw new \Exception('Failed to create ticket: ' . json_encode($data));
        }

        return $data;
    }

    /**
     * Save value to .env file
     */
    public function saveEnvValue($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $env = file_get_contents($path);

            if (strpos($env, $key . '=') !== false) {
                $env = preg_replace("/{$key}=.*/", "{$key}={$value}", $env);
            } else {
                $env .= "\n{$key}={$value}";
            }

            file_put_contents($path, $env);
        }
    }
}
