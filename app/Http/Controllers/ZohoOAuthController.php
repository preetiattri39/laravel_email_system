<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZohoOAuthController extends Controller
{
    /**
     * Step 1: Redirect user to Zoho OAuth consent page
     */
    public function redirectToZoho()
    {
        $clientId = env('ZOHO_CLIENT_ID');
        $redirectUri = route('zoho.oauth.callback');
        $scope = 'Desk.tickets.READ,Desk.tickets.CREATE,Desk.basic.READ';
        $state = csrf_token();

        $url = "https://accounts.zoho.in/oauth/v2/auth?"
            . "scope=" . urlencode($scope)
            . "&client_id={$clientId}"
            . "&response_type=code"
            . "&access_type=offline"
            . "&redirect_uri=" . urlencode($redirectUri)
            . "&state={$state}";

        return redirect($url);
    }

    /**
     * Step 2: Handle Zoho OAuth callback and save refresh token
     */
    public function handleZohoCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('home')
                ->with('error', $request->get('error'));
        }

        $code = $request->get('code');
        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');
        $redirectUri = route('zoho.oauth.callback');
        $tokenUrl = 'https://accounts.zoho.in/oauth/v2/token';

        // Exchange authorization code for access & refresh tokens
        $response = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]);

        if ($response->failed()) {
            return redirect()->route('home')
                ->with('error', 'Failed to get token: ' . json_encode($response->json()));
        }

        $data = $response->json();
        $refreshToken = $data['refresh_token'] ?? null;

        if (!$refreshToken) {
            return redirect()->route('home')
                ->with('error', 'No refresh token received');
        }

        // Save refresh token to .env
        $this->setEnvValue('ZOHO_REFRESH_TOKEN', $refreshToken);

        return redirect()->route('home')
            ->with('success', 'Refresh token saved successfully!');
    }

    /**
     * Step 3: Use refresh token from .env to get a new access token
     */
    public function getAccessToken()
    {
        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');
        $refreshToken = env('ZOHO_REFRESH_TOKEN');

        if (!$refreshToken) {
            return redirect()->route('home')
                ->with('error', 'Refresh token not found in .env');
        }

        $tokenUrl = 'https://accounts.zoho.in/oauth/v2/token';
        $response = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken,
        ]);

        if ($response->failed()) {
            return redirect()->route('home')
                ->with('error', 'Failed to refresh access token: ' . json_encode($response->json()));
        }

        $accessToken = $response->json()['access_token'];

        return redirect()->route('home')
            ->with('success', 'Access token generated successfully!')
            ->with('access_token', $accessToken);
    }

    /**
     * Helper: Update .env file with new value
     */
    protected function setEnvValue($key, $value)
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
