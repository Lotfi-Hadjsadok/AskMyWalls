<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Assistant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-transparent w-full h-screen overflow-hidden">
    <livewire:chatbot-demo :chatbotId="$chatbotId" :embedded="true" />

    @livewireScripts
</body>

</html>