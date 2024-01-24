<?php
$logged = isset($_SESSION['logged']) && $_SESSION['logged'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="px-3 dark:bg-gray-800 dark:text-white">
    <nav class="mt-3 dark:text-black">
        <ul class="flex justify-end flex-col md:flex-row">
            <li><a href="/"      class="block md:inline-block rounded bg-indigo-100 hover:bg-indigo-300 no-underline px-4 py-2 ml-1">Inicio</a></li>
            <?php if($logged): ?>
            <li><a href="/admin" class="block md:inline-block rounded bg-indigo-100 hover:bg-indigo-300 no-underline px-4 py-2 ml-1">Admin</a></li>
            <li><a href="/logout" class="block md:inline-block rounded bg-indigo-100 hover:bg-indigo-300 no-underline px-4 py-2 ml-1">Cerrar sesión</a></li>
            <?php else: ?>
            <li><a href="/login" class="block md:inline-block rounded bg-indigo-100 hover:bg-indigo-300 no-underline px-4 py-2 ml-1">Login</a></li>
            <?php endif; ?>
            <li><a href="/juego" class="block md:inline-block rounded bg-indigo-100 hover:bg-indigo-300 no-underline px-4 py-2 ml-1">Juego</a></li>
        </ul>
    </nav>
    <main class="mt-2">
