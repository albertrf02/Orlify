<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "Head.php" ?>
    <title>Login</title>
</head>
<body class="bg-background">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-5 rounded shadow-md w-full sm:w-96">
            <form id="registerForm" class="max-w-sm mx-auto" action="/dorecoverpassword" method="post">
                <div class="mb-5 flex items-center justify-center">
                    <a href="/"> 
                        <img src="/img/logo.png" class="h-10" alt="orlify">
                    </a>
                </div>
                <?php if ($errorpass != "") { ?>
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                        <?= $errorpass ?>
                    </div>
                <?php } ?>
                <label for="website-adminn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nova contrasenya</label>
                <div class="flex mb-4">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                        <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                      </svg>
                    </span>
                    <input type="password" name="new_password" class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nova contrasenya">
                </div>
                <label for="website-adminn-repeat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Repeteix contrasenya</label>
                <div class="flex mb-4">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                        <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                      </svg>
                    </span>
                    <input type="password" name="repeat_password" id="password" class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Repeteix contrasenya">
                    <input type="text" name="token" id="token" value ="<?= $token ?>" class="hidden">
                </div>
                <button type="submit" class="mt-4 w-full text-white bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:focus:ring-blue-800">Desa els canvis</button>
            </form>
        </div>
    </div>
    <?php require "Scripts.php" ?>
</body>
</html>
