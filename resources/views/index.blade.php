<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-800">
    <header class="w-full bg-gray-900 h-16 flex items-center justify-center border-b border-gray-600">
        <h1 class="text-gray-100 font-black text-3xl">Task Manager</h1>
    </header>

    <section class="mt-24">
        @livewire('task-manager')
    </section>
</body>
</html>
