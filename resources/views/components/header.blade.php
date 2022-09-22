<header class="fixed top-0 z-10 bg-white flex w-screen text-gray-600 body-font border-b border-gray-300">
    <div class="container mx-auto flex flex-wrap px-5 py-3 items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <img class="object-cover object-center rounded" alt="logo" src="{{asset('/images/logo/logo-light.png')}}" width='100'>
            <span class="text-lg md:text-xl hidden md:flex ">Examination System</span>
        </a>
        <div class="ml-auto flex flex-wrap items-center text-base justify-center">
            <span class="hidden md:flex mr-3 ">{{auth()->user()->name}}</span>
            <span class="hidden md:flex flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 items-center justify-center text-white relative z-10">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </span>
            <button data-collapse-toggle="sidebar" aria-controls="sidebar" aria-expanded="false" class="md:invisible p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" id='menu'>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>
</header>