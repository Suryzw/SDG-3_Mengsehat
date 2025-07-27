<x-layouts.app :title="__('Dashboard - Mengsehat')">
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const manualForm = document.getElementById("manual-city-form");

        // Jangan langsung redirect, tunggu geolocation
        if (!window.location.search.includes('city=')) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        // Jika user IZINKAN lokasi
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        fetch(`/get-city-from-coordinates?lat=${latitude}&lon=${longitude}`) 
                            .then(response => response.json())
                            .then(data => {
                                if (data.city) {
                                    window.location.href = `/dashboard?city=${encodeURIComponent(data.city)}`;
                                } else {
                                    // Jika gagal mengambil kota dari API
                                    manualForm.classList.remove("hidden");
                                }
                                
                            })
                            .catch(err => {
                                console.error('Gagal mendapatkan nama kota:', err);
                                manualForm.classList.remove("hidden");
                            });
                    },
                    function (error) {
                        // Jika user TOLAK izin lokasi
                        console.warn("Geolocation error:", error.message);
                        manualForm.classList.remove("hidden");
                    }
                );
            } else {
                // Browser tidak mendukung Geolocation
                manualForm.classList.remove("hidden");
            }
            
        }
    });
</script>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Ringkasan cuaca hari ini - Selalu jaga kesehatan yaa ! ~') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Form Manual Input Kota -->
    <div id="manual-city-form" class="mt-4 hidden">
        <form method="GET" action="/dashboard">
            <label for="city" class="block font-semibold">Masukkan Nama Kota:</label>
            <input type="text" id="city" name="city" class="border rounded px-3 py-1 mt-1" required>
            <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-1 rounded">Kirim</button>
        </form>
    </div>

    <div class="grid grid-cols-3 grid-rows-5 gap-6">
        <div class="row-span-2 col-start-1 row-start-1 border-l-5 border-accent-content bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="text-4xl mt-3 text-center font-bold mb-9 text-gray-600">
                {{ $weatherData['name'] }}
            </div>            
            <div class="text-5xl text-center my-3 font-medium text-gray-600">
                {{ $weatherData['datetime'] }}
            </div>
            <div class="text-center text-xl text-gray-600 mb-3">
                {{ $weatherData['date'] }}
            </div>
        </div>
       
        
        <div class="col-span-2 row-span-2 col-start-2 row-start-1 border-l-5 border-accent-content text-gray-600 bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="bg-blue-50 dark:bg-gray-800 p-6 rounded-xl shadow-md mt-6">
                <h2 class="text-xl font-semibold text-blue-700 dark:text-blue-200 mb-4">
                    Rekomendasi Hari Ini ({{ $weatherData['weather'][0]['main'] }})
                </h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-100">
                    @foreach($recommendations as $rec)
                        <li class="leading-relaxed">{{ $rec->recommendation }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
        <div class="content-center col-span-2 row-span-2 col-start-2 row-start-3 border-l-5 border-accent-content bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="grid grid-cols-3 grid-rows-1 gap-2 ">
               <div class="text-gray-600 self-center text-center">
                    <p class="text-4xl mb-8">🌡️</p>
                    <p class="text-4xl">{{ $weatherData['main']['temp'] }}&deg;C<br></p>
                    <p class="text mt-2">Feels Like: {{ $weatherData['main']['feels_like'] }}&deg;C</p>
                </div>
                <div > 
                    <div class="flex flex-col items-center gap-1 my-4">
                        <img src="http://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}@2x.png" alt="Weather Icon" class="w-30 h-30">
                        <span class="text-2xl capitalize text-gray-600 text-center">{{ $weatherData['weather'][0]['description'] }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 grid-rows-2 gap-4 text-gray-600">
                    <div class="text-center self-center" >
                        <p class="text-3xl mb-3">🌬️</p>
                        <p class="font-bold">{{ $weatherData['wind']['speed'] }}</p>
                        <p>Wind Speed</p>
                    </div>
                    <div class="text-center self-center">
                        <p class="text-3xl mb-3">🧭</p>
                        <p class="font-bold">{{ $weatherData['main']['pressure'] }}</p>
                        <p>Pressure</p>
                    </div>
                    <div class="text-center self-center">
                        <p class="text-3xl mb-3">💧</p>
                        <p class="font-bold">{{ $weatherData['main']['humidity'] }}</p>
                        <p>Humidity</p>
                    </div>
                    <div class="text-center self-center">
                        <p class="text-3xl mb-3">☁️</p>
                        <p class="font-bold">{{ $weatherData['clouds']['all'] }}</p>
                        <p>Cloud</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-span-3 col-start-1 row-start-3 border-l-5 border-accent-content bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="text-3xl font-bold text-center mb-6 text-gray-600">
                Today Forecast
            </div>
            <div class="flex flex-col gap-4 text-gray-600">
                @foreach ($todayForecast as $forecast)
                    <div class="flex items-center justify-between bg-white rounded-lg shadow-lg hover:shadow-xl p-4">
                        {{-- Time --}}
                        <div class="text-center w-1/3 text-lg font-medium">
                            {{ \Carbon\Carbon::parse($forecast['dt_txt'])->format('H:i') }}
                        </div>

                        {{-- Icon --}}
                        <div class="w-1/3 flex justify-center">
                            <img src="http://openweathermap.org/img/wn/{{ $forecast['weather'][0]['icon'] }}@2x.png" alt="icon" class="w-12 h-12">
                        </div>

                        {{-- Temperature --}}
                        <div class="text-center w-1/3 text-xl font-semibold">
                            {{ $forecast['main']['temp'] }}°C
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script></script>
</x-layouts.app>
