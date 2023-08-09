<?php

include "koneksi.php";

$tampil = queryAll("SELECT * FROM kost_detail");

?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pemetaan Kost</title>
  <link href="./dist/output.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <link rel="stylesheet" href="https://unpkg.com/claymorphism-css/dist/clay.css" />
  <link rel="stylesheet" href="src/css/style.css">
  <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script>
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
        '(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark')
    }
  </script>
</head>

<body>
  <header>
    <nav class="px-2 sm:px-4 py-2.5 fixed w-full z-20 top-0 left-0 bg-transparent backdrop-blur-md">
      <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="index.php" class="flex items-center">
          <span class="self-center text-green-500 text-4xl font-serif font-bold whitespace-nowrap">Kost.id</span>
        </a>
        <div class="flex md:order-2">
          <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
            </svg>
          </button>
          <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
          <ul class="flex flex-col gap-5 p-4 mt-4 border border-gray-100 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-lg md:font-medium md:border-0">
            <li>
              <a href="#beranda" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Beranda</a>
            </li>
            <li>
              <a href="#tentang" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Tentang
                kami</a>
            </li>
            <li>
              <a href="#fitur" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Fitur</a>
            </li>
            <li>
              <a href="#peta" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Peta</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section id="beranda" class="p-5 bg-white dark:bg-gray-900">
    <div class="container">
      <div class="flex flex-wrap">
        <div class="w-full self-center px-4 lg:w-1/2">
          <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Pemetaan Kost di<span class="mt-1 block text-4xl font-bold text-dark dark:text-white lg:text-5xl">Purwokerto Utara</span></h1>
          <p class="mb-8 mt-3 font-medium leading-relaxed dark:text-gray-400 text-secondary">Temukan rekomendasi pilihan
            kost
            terbaik disini
          </p>
          <a href="#tentang" class="relative inline-flex items-center rounded-full justify-center px-10 py-4 overflow-hidden font-mono font-medium tracking-tighter text-gray-800 dark:text-white bg-gray-800 dark:bg-gray-100 group">
            <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-green-500 rounded-full group-hover:w-56 group-hover:h-56"></span>
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-gray-700 dark:to-gray-100"></span>
            <span class="relative text-white dark:text-gray-800 dark:hover:text-white">Selengkapnya</span>
          </a>
        </div>
        <div class="w-full self-end px-4 lg:w-1/2">
          <div class="relative mt-10 lg:right-0 lg:mt-9">
            <img src="assets/hero.png" alt="gambar hero section" class="relative z-10 mx-auto max-w-full" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="tentang" class="bg-white dark:bg-gray-900">
    <div class="py-2 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
      <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Apa itu Kost.id ?</h1>
      <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Kost.id
        merupakan salah satu
        website sistem informasi geografis pemetaan kost dengan wilayah Kecamatan Purwokerto Utara yang dapat
        memudahkan penggunanya untuk
        menemukan kost terbaik di wilayah tersebut
      </p>
      <div class="relative mt-10 lg:center-0 lg:mt-9">
        <img src="assets/room.png" alt="gambar hero section" class="relative object-cover z-10 mx-auto max-w-lg" />
      </div>
    </div>
  </section>

  <section id="fitur" class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
      <div class="py-2 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
          Fitur Pemetaan</h1>
        <p class="text-gray-500 sm:text-xl dark:text-gray-400">Berikut beberapa fitur pada sistem informasi geografis pemetaan kost di Purwoketo Utara</p>
      </div>
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4 text-center">
        <div class="clay p-6 bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden md:max-w-2xl my-5 transform translate-y-4 hover:translate-y-0 duration-500 ease-in-out">
          <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
            Batas Wilayah
          </h3>
          <p class="text-sm leading-6 text-gray-500 sm:text-xl dark:text-gray-400">
            Pada peta terdapat batas wilayah kecamatan purwokerto utara dalam bentuk geojson
          </p>
        </div>
        <div class="clay p-6 bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden md:max-w-2xl my-5 transform translate-y-4 hover:translate-y-0 duration-500 ease-in-out">
          <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
            Marker
          </h3>
          <p class="text-sm leading-6 text-gray-500 sm:text-xl dark:text-gray-400">
            Marker pada peta menunjukkan posisi kost pada kecamatan purwokerto utara
          </p>
        </div>
        <div class="clay p-6 bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden md:max-w-2xl my-5 transform translate-y-4 hover:translate-y-0 duration-500 ease-in-out">
          <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
            Rute
          </h3>
          <p class="text-sm leading-6 text-gray-500 sm:text-xl dark:text-gray-400">
            Terdapat fitur rute menuju lokasi kost dari posisi pengguna berada
          </p>
        </div>
        <div class="clay p-6 bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden md:max-w-2xl my-5 transform translate-y-4 hover:translate-y-0 duration-500 ease-in-out">
          <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
            Kontrol Peta
          </h3>
          <p class="text-sm leading-6 text-gray-500 sm:text-xl dark:text-gray-400">
            Dapat menggunakan beberapa fitur pada peta leaflet js
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="peta" class="p-5 bg-white dark:bg-gray-900">
    <div class="py-2 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
      <h1 class="text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Pemetaan Kost</h1>
      </p>
    </div>
    <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow flex w-full flex-wrap justify-center px-4 xl:mx-auto xl:w-10/12">
      <form>
        <div class="grid gap-6 mb-6 md:grid-cols-3">
          <input type="text" name=latNow class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></input>
          <input type="text" name=lngNow class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></input>
          <button type="button" class="lokasiAwal text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-800">Lokasi Saya</button>
        </div>
      </form>
      <div id="map" style="height:500px;width: 100%;">
      </div>
    </div>
  </section>

  <footer class="bg-green-700 pt-10 pb-3">
    <div class="container">
      <div class="flex flex-wrap">
        <div class="mb-5 w-full px-4 font-medium text-slate-300 md:w-1/3">
          <h2 class="mb-5 text-4xl font-bold text-white">Kost.id</h2>
          <h3 class="mb-2 text-2xl font-bold">Hubungi Kami</h3>
          <p>kostid@gmail.com</p>
          <p>Jl. DI Panjaitan No.128, Karangreja</p>
          <p>Purwokerto Selatan</p>
          <div class="mt-3 flex items-center justify-start">
            <a href="#" target="_blank" class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-red-700 hover:bg-red-700 hover:text-white">
              <svg role="img" width="20" class="fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>YouTube</title>
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
              </svg>
            </a>
            <a href="#" target="_blank" class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-purple-700 hover:bg-purple-700 hover:text-white">
              <svg role="img" width="20" class="fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>Instagram</title>
                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
              </svg>
            </a>
            <a href="#" target="_blank" class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-black hover:bg-black hover:text-white">
              <svg role="img" width="20" class="fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>TikTok</title>
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
              </svg>
            </a>
            <a href="#" target="_blank" class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-blue-500 hover:bg-blue-500 hover:text-white">
              <svg role="img" width="20" class="fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <title>Twitter</title>
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
              </svg>
            </a>
          </div>
        </div>
        <div class="mb-5 w-full px-4 md:w-1/3">
          <h3 class="mb-5 text-xl font-semibold text-white">Artikel</h3>
          <ul class="text-slate-300">
            <li>
              <a href="#" class="mb-3 inline-block text-base hover:text-primary">Tips makanan sehat</a>
            </li>
            <li>
              <a href="#" class="mb-3 inline-block text-base hover:text-primary">Tips merawat kamar</a>
            </li>
            <li>
              <a href="#" class="mb-3 inline-block text-base hover:text-primary">Tips manajemen keuangan</a>
            </li>
          </ul>
        </div>
        <div class="mb-12 w-full px-4 md:w-1/3">
          <h3 class="mb-5 text-xl font-semibold text-white">Tautan</h3>
          <ul class="text-slate-300">
            <li>
              <a href="#home" class="mb-3 inline-block text-base hover:text-primary">Beranda</a>
            </li>
            <li>
              <a href="#about" class="mb-3 inline-block text-base hover:text-primary">Tentang Kami</a>
            </li>
            <li>
              <a href="#portfolio" class="mb-3 inline-block text-base hover:text-primary">Peta</a>
            </li>
            <li>
              <a href="#clients" class="mb-3 inline-block text-base hover:text-primary">Kontak</a>
            </li>
          </ul>
        </div>
      </div>
      <hr class="w-full border-t border-slate-400 pt-5">
      <p class="text-center text-xs font-medium text-white">
        <span class="text-sm sm:text-center">© 2023 <a href="#" class="hover:underline">Kost.id™</a>. All Rights Reserved.
        </span>
      </p>
    </div>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
  <script src="src/js/main.js"></script>
  <script src="leaflet.ajax.min.js"></script>
  <script>
    let latLng;
    //let centerMap = false;
    var map = L.map('map', {
      center: [-7.388061, 109.232632],
      zoom: 14,
      layers: [],
      fullscreenControl: true,
      fullscreenControlOptions: { // optional
        title: "Show the fullscreen !",
        titleCancel: "Exit fullscreen mode"
      }
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    // area geojson purwokerto utara
    var geoJsonLayer = new L.GeoJSON.AJAX("purwokerto_utara.geojson");
    geoJsonLayer.addTo(map);

    // ambil titik lokasi pengguna
    getLocation();

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
      $("[name=latNow]").val(position.coords.latitude);
      $("[name=lngNow]").val(position.coords.longitude);
    }

    // marker kost di purwokerto utara
    <?php
    foreach ($tampil as $row) { ?>
      var marker = L.marker([<?php echo $row['latitude']; ?>, <?php echo $row['longitude']; ?>])
        .bindPopup('<p class="font-bold"><?php echo $row['nama']; ?></p>' +
          '<p><?php echo $row['alamat']; ?></p>' +
          '<button type="button" class="mr-3 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-bold rounded-lg text-sm px-2 py-2"><a href="detail_kost.php?id_kost=<?= $row['id_kost']; ?>">Detail</a></button>' +
          '<button type="button" class="bg-green-500 hover:bg-green-700 text-sm text-white font-bold py-2 px-2 rounded" onclick="return posisiKost(<?php echo $row['latitude']; ?>, <?php echo $row['longitude']; ?>)">Rute</button>')
        .bindTooltip("<?php echo $row['jenis']; ?>")
        .addTo(map);
    <?php } ?>

    // kontrol rute
    var control = L.Routing.control({
      waypoints: [
        latLng
      ],
      geocoder: L.Control.Geocoder.nominatim(),
      routeWhileDragging: true,
      reverseWaypoints: true,
      showAlternatives: true,
      altLineOptions: {
        style: [{
            color: 'black',
            opacity: 0.15,
            weight: 9
          },
          {
            color: 'white',
            opacity: 0.8,
            weight: 6
          },
          {
            color: 'blue',
            opacity: 0.5,
            weight: 2
          },
        ]
      },
      createMarker: function(i, waypoint, n) {
        const marker = L.marker(waypoint.latLng, {
          draggable: true,
          bounceOnAdd: false,
          bounceOnAddOptions: {
            duration: 1000,
            height: 800,
            function() {
              (bindPopup(myPopup).openOn(map))
            }
          },
          icon: L.icon({
            iconUrl: 'assets/user.png',
            iconSize: [38, 45]
          })
        });
        return marker;
      }
    })
    control.addTo(map);

    // fungsi menuju titik lokasi kost
    function posisiKost(latitude, longitude) {
      let latLng = L.latLng(latitude, longitude);
      control.spliceWaypoints(control.getWaypoints().length - 1, 1, latLng);
    }

    // fungsi klik titik awal lokasi
    $(document).on("click", ".lokasiAwal", function() {
      let latLng = [$("[name=latNow]").val(), $("[name=lngNow]").val()];
      control.spliceWaypoints(0, 1, latLng);
      map.panTo(latLng);
    })
  </script>
</body>

</html>