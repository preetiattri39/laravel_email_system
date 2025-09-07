@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            Zoho Refresh Token Generated
        </div>
        <div class="card-body">
            <p class="mb-3">Copy and paste this refresh token into your <code>.env</code> file as <code>ZOHO_REFRESH_TOKEN</code>:</p>
            <div class="alert alert-info"><strong>{{ $refreshToken }}</strong></div>
            <p class="mt-3">After saving, you can close this window.</p>
        </div>
    </div>
</div>
@endsection
