<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/main.css">
    <link rel="icon" href="/images/logo.jpg">
    <title>Login</title>
</head>

<body class="bg-background">
    <div class="w-full flex flex-wrap">

        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center">

            <div class="bg-white p-5 rounded w-full sm:w-96">
                <form class="max-w-sm mx-auto" action="/dologin" method="post">
                    <div class="mb-5 flex items-center justify-center">
                        <img src="/img/logo.png" class="h-10" alt="orlify">
                    </div>

                    <?php if ($error != "") { ?>
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            <?= $error ?>
                        </div>
                    <?php } ?>
                    <label for="website-admin"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correu
                        electrònic</label>
                    <div class="flex mb-4">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path
                                    d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                <path
                                    d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="website-admin"
                            class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="example@gmail.com">
                    </div>

                    <label for="website-adminn"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contrasenya</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="website-adminn"
                            class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="******">
                    </div>
                    <div class="flex mt-5">
                        <p class="block mb-2 text-sm font-medium text-grey-800 dark:text-white">Heu oblidat la
                            contrasenya ? <a href="/recover"
                                class="text-customBlue hover:text-customDarkBlue">Restablir-la</a></p>
                    </div>
                    <button type="submit"
                        class="mt-4 w-full text-white bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:focus:ring-blue-800">Iniciar
                        sessió</button>
                </form>
                <div class="mt-6 flex items-center justify-center">
                    <p class="block mb-2 text-sm font-medium text-grey-800 dark:text-white">No tens compte ? <a
                            href="/register" class="text-customBlue hover:text-customDarkBlue">Registra't</a></p>
                </div>
            </div>

        </div>

        <div class="w-1/2 shadow-2xl">
            <div class="image-container-login relative">
                <img class="object-cover w-full h-screen hidden md:block" src="img/backgroundImage.jpg"
                    alt="Background Image">
                <div
                    class="overlay-login absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white p-8">
                    <h1 class="text-6xl font-bold text-black mb-4">Orlify</h1>
                    <p class="text-sm text-gray-700 mb-10">Visualitza les nostres orles publiques clicant el següent
                        botó
                    </p>
                    <a href="/home"
                        class="inline-flex items-center w-full px-5 py-3 mb-3 mr-1 text-base font-semibold text-white no-underline align-middle bg-blue-600 border border-transparent border-solid rounded-md cursor-pointer select-none sm:mb-0 sm:w-auto hover:bg-blue-700 hover:border-blue-700 hover:text-white focus-within:bg-blue-700 focus-within:border-blue-700">
                        Orles publiques
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

</html>