<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Wars Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body { background-color: #f8f9fa; }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #0b0b0b;
            border-radius: 10px;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.8);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(
                    180deg,
                    #FFE81F,
                    #d4b600
            );
            border-radius: 10px;
            border: 2px solid #0b0b0b;
            box-shadow:
                    0 0 6px rgba(255, 232, 31, 0.6),
                    inset 0 0 4px rgba(0,0,0,0.6);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(
                    180deg,
                    #fff2a8,
                    #FFE81F
            );
            box-shadow:
                    0 0 10px rgba(255, 232, 31, 0.9);
        }

        ::-webkit-scrollbar-corner {
            background: #0b0b0b;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Star Wars API</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Films</a></li>
                <li class="nav-item"><a class="nav-link" href="/characters">People</a></li>
                <li class="nav-item"><a class="nav-link" href="/planets">Planets</a></li>
                <li class="nav-item"><a class="nav-link" href="/species">Species</a></li>
                <li class="nav-item"><a class="nav-link" href="/vehicles">Vehicles</a></li>
                <li class="nav-item"><a class="nav-link" href="/starships">Starships</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">