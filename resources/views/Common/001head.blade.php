<!--suppress JSUnresolvedLibraryURL -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')

    <style>
        body { font-family: 'Figtree', system-ui, sans-serif; }

        /* Section collapse toggle buttons */
        .section-toggle {
            display: block;
            width: 100%;
            padding: .45rem .8rem;
            background: #f1f5f9;
            border: 1px solid #dee2e6;
            border-radius: .3rem;
            color: #334155;
            font-size: .825rem;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            transition: background .12s ease, color .12s ease;
        }
        .section-toggle:hover       { background: #e2e8f0; color: #1e3a5c; text-decoration: none; }
        .section-toggle[aria-expanded="true"] { background: #dbe4f0; color: #1e3a5c; border-color: #b8c9e0; }
        .section-toggle::after {
            content: '▾';
            position: absolute;
            right: .8rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: .45;
            transition: transform .2s ease;
        }
        .section-toggle[aria-expanded="true"]::after { transform: translateY(-50%) rotate(180deg); }

        /* Data navbar list */
        #datanavbar .table td { font-size: .8rem; padding: .2rem .3rem; }
        #datanavbar .table a  { text-decoration: none; color: #1e3a5c; }
        #datanavbar .table a:hover { text-decoration: underline; }
    </style>
</head>
