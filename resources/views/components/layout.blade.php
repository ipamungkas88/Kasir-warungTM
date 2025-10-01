<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  <title>
    {{ $title }}
  </title>
</head>

<body class="h-full dark:text-white">
  <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
  <div class="min-h-full">
    <x-navbar />

    <x-header />
    <main>
      {{ $slot }}
    </main>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

</body>

</html>
