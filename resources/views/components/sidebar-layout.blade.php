<!DOCTYPE html>
<html lang="en" class="h-full bg-white dark:bg-gray-900">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  <title>{{ $title ?? 'Warung TM' }}</title>
</head>

<body class="h-full">
  <div class="min-h-full">
    <x-role-sidebar>
      {{ $slot }}
    </x-role-sidebar>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</body>

</html>
