<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>

    <section class="text-gray-600 body-font px-2 md:px-24">
        <div class="container mx-auto flex py-24 md:flex-row flex-col-reverse items-center">
            <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                <h1 class="title-font sm:text-4xl md:text-4xl mb-4 font-medium text-gray-900">EXAMINATION SYSTEM</h1>
                <p class="mb-8 leading-relaxed">University of Okara, Pakistan</p>

                <div class="flex flex-col w-full items-start">
                    <div class="w-full">
                        <label for="hero-field" class="leading-7 text-sm text-gray-600">User ID</label>
                        <input type="text" id="id" name="id" class="w-full input-indigo" placeholder="Enter your login id">
                    </div>
                    <div class="w-full mt-3">
                        <label for="hero-field" class="leading-7 text-sm text-gray-600">Password</label>
                        <input type="password" id="id" name="password" class="w-full input-indigo" placeholder="Enter your login id">
                    </div>
                    <button class="w-full md:w-1/4 mt-4 btn-indigo">Login</button>
                </div>

            </div>
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo-light.png')}}" width='700'>
            </div>
        </div>
    </section>
</body>

</html>