<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel Email System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Laravel Email System</a>
        <div class="d-flex">
            <a href="{{ route('zoho.oauth.redirect') }}" class="btn btn-warning me-2">Generate Zoho Access Token</a>
            <form action="{{ url('/zoho/fetch-info') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success">Fetch Department ID</button>
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar vh-100">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a class="nav-link text-white" href="{{ route('leads.index') }}">Leads</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-white" href="{{ route('tickets.index') }}">Tickets</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-white" href="{{ route('emails.index') }}">Emails</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-white" href="{{ route('timelines.index') }}">Timelines</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-white" href="{{ route('notes.index') }}">Notes</a></li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container text-center">
        <span class="text-muted">&copy; {{ date('Y') }} Laravel Email System. All rights reserved.</span>
    </div>
</footer>
</body>
</html>
