<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/home" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="../img/logo.png" class="h-11" alt="Logo" />
    </a>
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <button type="button"
        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
        data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full" src="<?= '../avatars/' . $user["avatar"] ?>" alt="Alternative Text"
          onerror="this.onerror=null; this.src='../avatars/avatar-nen1.png';" id="avatarImage">
      </button>
      <div
        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
        id="user-dropdown">
        <div class="px-4 py-3">

          <?php if (isset($logged) && $logged): ?>
            <span class="block text-sm text-gray-900 dark:text-white">
              <?= $user["name"] ?>
            </span>
            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">
              <?= $user["email"] ?>
            </span>
          <?php else: ?>
            <li>
              <a href="/"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Iniciar
                sessió</a>
            </li>
            <li>
              <a href="/register"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Registrar-se</a>
            </li>
          <?php endif ?>

        </div>

        <?php if (isset($logged) && $logged): ?>
          <ul class="border-b border-gray-200 py-2" aria-labelledby="user-menu-button">
            <li>
              <a href="perfil"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Perfil</a>
            </li>
            <?php if ($user["role"] == 4): ?>
              <li class="border-b border-gray-200">
                <a href="/admin"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Panell
                  d'administració</a>
              </li>
            <?php elseif ($user["role"] == 3): ?>
              <li class="border-b border-gray-200 py-2" aria-labelledby="user-menu-button">
                <a href="/equipDirectiu"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Panell
                  equip
                  directiu</a>
              </li>
            <?php elseif ($user["role"] == 2): ?>
              <li class="border-b border-gray-200">
                <a href="/professor"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Panell
                  professor</a>
              </li>
            <?php endif ?>
            <li>
              <a href="canviarContrasenya"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Canviar
                Contrasenya</a>
            </li>
            <li>
              <a href="logout"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tancar
                sessió</a>
            </li>
          </ul>
        <?php endif ?>
      </div>
      <button data-collapse-toggle="navbar-user" type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-user" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
    </div>
  </div>
</nav>