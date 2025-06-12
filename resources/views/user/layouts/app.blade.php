<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Bu çox vacibdir --}}
    <title>@yield('title', 'Rent A Car')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .footer-fixed {
            margin-top: auto;
        }

        /* Responsive tweaks if needed */
        @media (max-width: 576px) {
            .card-title {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

@include('user.partials.header')

<main class="container mt-4">
    @include('components.flash-messages')
    @yield('content')
</main>

@include('user.partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
