<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pizza</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>
    <style>
        .Pizz{
            font-size: 7ch;
            text-align: center;
        }
        .redes{
            text-align: center;
        }
    </style>
    <header class="bg-[#ffbb2a] font-bold">
        <div class="flex ...">
            <div class="flex-none w-20 ...">
                <img  width="250" src="/img/pizzalogo.webp" class="logo">
            </div>
            <div class="flex-1">
                <h1 class="Pizz">PIZZERIA MANIA</h1>
            </div>
            <div class="flex-none w-20 ...">
                <img  width="250" src="/img/pizzalogo.webp" class="logo">
            </div>
          </div>
    </header>
    <!-- buscador y menú -->
    <div class="flex ...">
        <div class="flex-auto w-32 ...">
            <form class="max-w-md ">   
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Mockups, Logos..." required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div>
        <div class="flex-auto w-64 ...">
            <div class="menu">
                <nav class="flex justify-center space-x-1">
                    <a href="/dashboard" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">OFERTAS</a>
                    <a href="/team" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">DELIVERY</a>
                    <a href="/projects" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">RECOJO EN LOCAL</a>
                    <a href="/reports" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">VENTA</a>
                    </nav>
            </div>
        </div>
    </div>
    <div>
        <img src="/img/banner.jpg" class="w-full h-auto" height="500px">
    </div>
    
    <div class="container">
        
        
        <div class="bg-[#e8e8eb] py-10">
            <h2 class="text-6xl font-bold text-center mb-8">NUESTROS PRODUCTOS</h2>
            <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70"></div>
            <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Producto 1 -->
                <div class="bg-[#ffffff] shadow-lg rounded-lg overflow-hidden">
                    <img src="/img/producto1.jpg" alt="Producto 1" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-xl mb-2">Pizza Clásica</h3>
                        <p class="text-gray-600">Una pizza clásica con salsa de tomate, mozzarella y albahaca fresca.</p>
                        <p class="text-orange-500 font-bold text-lg mt-4">100 Bs.</p>
                        <button class="mt-4 bg-[#f97316] text-white px-4 py-2 rounded hover:bg-[#ff8f3e]">Comprar</button>
                    </div>
                </div>
                <!-- Producto 2 -->
                <div class="bg-[#ffffff] shadow-lg rounded-lg overflow-hidden">
                    <img src="/img/producto1.jpg" alt="Producto 2" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-xl mb-2">Pizza Pepperoni</h3>
                        <p class="text-gray-600">Deliciosa pizza con abundante pepperoni y queso derretido.</p>
                        <p class="text-orange-500 font-bold text-lg mt-4">120 Bs.</p>
                        <button class="mt-4 bg-[#f97316] text-white px-4 py-2 rounded hover:bg-[#ff8f3e]">Comprar</button>
                    </div>
                </div>
                <!-- Producto 3 -->
                <div class="bg-[#ffffff] shadow-lg rounded-lg overflow-hidden">
                    <img src="/img/producto1.jpg" alt="Producto 3" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-xl mb-2">Pizza Hawaiana</h3>
                        <p class="text-gray-600">Una mezcla de dulce y salado con piña, jamón y queso.</p>
                        <p class="text-orange-500 font-bold text-lg mt-4">115 Bs.</p>
                        <button class="mt-4 bg-[#f97316] text-white px-4 py-2 rounded hover:bg-[#ff8f3e]">Comprar</button>
                    </div>
                </div>
            </div>
            <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70"></div>


            <!-- Mapa -->
            <h2 class="text-6xl font-bold text-center mb-8">NUESTRA UBICACIÓN</h2>
            <div class="flex justify-center">
                <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.12345!2d-122.0858482!3d37.4221316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba5cd6d3456b:0x123abc4567def89!2sGoogleplex!5e0!3m2!1sen!2sus!4v1601234567890!5m2!1sen!2sus" 
                width="100%" 
                height="250" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                class="rounded-md shadow-md">
                </iframe>
            </div>
        </div>

        
    </div>
</body>
<footer class="bg-[#ffbb2a] text-white py-10">
      
    <!-- Información de contacto y redes sociales -->
    <div class="redes">
    <!-- Íconos de redes sociales -->
        <div class="flex-auto" >
            <a href="#" class="text-blue-500 hover:text-blue-400">
                <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="#" class="text-blue-400 hover:text-blue-300">
                <i class="fab fa-twitter fa-2x"></i>
                </a>
                <a href="#" class="text-pink-500 hover:text-pink-400">
                <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="#" class="text-red-500 hover:text-red-400">
                <i class="fab fa-youtube fa-2x"></i>
                </a>
        </div>
    </div>
    <div class="text-center text-gray-400 mt-8 text-sm">
      &copy; 2025 Pizzeria Mania. Todos los derechos reservados.
    </div>
  </footer>
  
</html>