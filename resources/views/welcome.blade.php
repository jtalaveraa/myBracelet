<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyBracelet - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="main-body" class="bg-black text-white min-h-screen w-full overflow-x-hidden font-sans text-white">

    <!-- MAIN DASHBOARD VIEW -->
    <div id="dashboard-view"
        class="min-h-screen w-full flex flex-col p-6 md:p-12 transition-opacity duration-500 relative z-10">
        <header
            class="mb-12 flex flex-col md:flex-row md:justify-between md:items-end border-b border-white/20 pb-6 gap-6">
            <div>
                <h1 class="text-3xl md:text-5xl font-light tracking-[0.2em] uppercase text-white">MyBracelet</h1>
                <h2 class="text-xl md:text-2xl font-black tracking-widest uppercase mt-2 opacity-80 text-white">Overview
                </h2>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-end gap-6">
                <!-- Project Specifications Button -->
                <button onclick="toggleInfoModal(true)"
                    class="text-[10px] tracking-[0.3em] uppercase border border-white/20 px-6 py-3 hover:bg-white hover:text-black transition-all duration-300">
                    Especificaciones del Proyecto
                </button>

                <div class="flex flex-col items-end gap-2">
                    <span id="active-count"
                        class="text-xs tracking-widest opacity-50 uppercase flex items-center gap-2 text-white">
                        <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        1 Dispositivo Activo
                    </span>
                    <span id="connection-status"
                        class="text-[9px] tracking-[0.2em] uppercase opacity-30 text-white">Adafruit: Online</span>
                </div>
            </div>
        </header>

        <div id="bracelets-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Bracelet Card 1 -->
            <div id="card-1" class="relative group">
                <button id="card-bg-1" onclick="openBracelet(1)"
                    class="w-full text-left border border-white/20 p-8 flex flex-col gap-8 hover:bg-white hover:text-black transition-all duration-700 group/card bg-black/40 backdrop-blur-sm overflow-hidden">
                    <div
                        class="flex justify-between items-center w-full border-b border-white/10 group-hover/card:border-black/10 pb-4 relative z-10 text-white group-hover/card:text-black transition-colors duration-700">
                        <h3 class="text-2xl font-bold tracking-widest uppercase">Brazalete 01</h3>
                        <div
                            class="text-xs tracking-widest uppercase opacity-50 group-hover/card:opacity-100 flex items-center gap-2">
                            MB-001 <span
                                class="w-1.5 h-1.5 bg-white group-hover/card:bg-black rounded-full animate-pulse"></span>
                        </div>
                    </div>
                    <div
                        class="flex justify-center items-center w-full py-4 relative z-10 text-white group-hover/card:text-black transition-colors duration-700">
                        <div class="flex items-center gap-4">
                            <svg id="card-heart-1" class="w-8 h-8 fill-white opacity-0 transition-all duration-500"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                            <span id="card-pulse-1" class="text-7xl font-black tabular-nums">--</span>
                            <span class="text-sm tracking-widest opacity-60">BPM</span>
                        </div>
                    </div>
                </button>
                <button onclick="deleteBracelet(1, event)"
                    class="absolute top-4 right-4 p-2 opacity-0 group-hover:opacity-100 hover:bg-red-600 transition-all duration-200 z-20"
                    title="Eliminar Brazalete">
                    <svg class="w-4 h-4 fill-white group-hover/card:fill-black group-hover:fill-white transition-colors duration-700"
                        viewBox="0 0 24 24">
                        <path
                            d="M3 6h18v2H3V6zm2 3h14v13a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm3 3v7h2v-7H8zm4 0v7h2v-7h-2zm4 0v7h2v-7h-2zM9 4V2h6v2h5v2H4V4h5z" />
                    </svg>
                </button>
            </div>

            <!-- Add New Bracelet Button -->
            <button onclick="toggleModal(true)"
                class="border border-white/10 border-dashed p-8 flex flex-col items-center justify-center gap-4 hover:border-white/40 hover:bg-white/5 transition-all duration-300 group min-h-[220px]">
                <span
                    class="text-6xl font-light opacity-20 group-hover:opacity-100 group-hover:scale-110 transition-all text-white">+</span>
                <span class="text-xs tracking-[0.3em] uppercase opacity-40 group-hover:opacity-100 text-white">Añadir
                    Brazalete</span>
            </button>
        </div>
    </div>

    <!-- INDIVIDUAL BRACELET VIEW -->
    <div id="individual-view" class="hidden min-h-screen w-full flex-col h-screen overflow-hidden bg-black relative">

        <!-- Top Navigation -->
        <nav
            class="w-full border-b border-white/10 p-4 md:px-8 flex justify-between items-center z-30 shrink-0 bg-black">
            <div class="flex items-center gap-8">
                <button onclick="closeBracelet()"
                    class="text-xs md:text-sm tracking-[0.2em] uppercase hover:opacity-50 transition-opacity flex items-center gap-2 text-white text-white">
                    <span>&larr;</span> <span class="hidden md:inline">Dashboard</span><span
                        class="md:hidden">Volver</span>
                </button>

                <button onclick="toggleInfoModal(true)"
                    class="text-[10px] tracking-[0.3em] uppercase opacity-40 hover:opacity-100 transition-opacity hidden md:block">
                    Especificaciones del Proyecto
                </button>
            </div>

            <div class="relative flex items-center gap-4">
                <span
                    class="text-[10px] tracking-widest uppercase opacity-40 hidden md:block text-white text-white">Monitorizando:</span>
                <div class="relative group">
                    <select id="bracelet-selector" onchange="switchBracelet(this.value)"
                        class="appearance-none bg-black text-white border border-white/20 px-4 py-2 pr-10 text-xs md:text-sm tracking-widest uppercase cursor-pointer outline-none focus:border-white transition-colors uppercase">
                        <option value="1">Brazalete 01</option>
                    </select>
                    <div
                        class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none border-l border-white/20 group-hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 fill-current text-white text-white" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </nav>

        <main id="individual-main"
            class="flex-1 flex flex-col relative z-10 transition-colors duration-700 overflow-hidden">

            <!-- FULL SCREEN BACKGROUND CHART CANVAS -->
            <div class="absolute inset-0 z-0 opacity-80 pointer-events-none">
                <canvas id="bpm-chart" class="w-full h-full"></canvas>
            </div>

            <!-- BPM Indicator moved to Top-Left -->
            <div class="p-8 md:p-12 relative z-10 flex flex-col items-start gap-4">
                <div class="flex items-center gap-4 md:gap-8 text-white">
                    <!-- Animated White Heart -->
                    <div id="heart-container" class="opacity-0 transition-opacity duration-1000">
                        <svg id="main-heart-icon"
                            class="w-12 h-12 md:w-20 md:h-20 fill-white animate-[heartbeat_0.8s_ease-in-out_infinite]"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </div>
                    <span id="pulse-value"
                        class="text-[8rem] md:text-[12rem] font-black tabular-nums tracking-tighter transition-all duration-300 leading-none text-white text-white">--</span>
                </div>

                <div class="text-white text-white">
                    <span class="text-lg md:text-2xl font-light tracking-[0.4em] opacity-40 uppercase">Latidos por
                        minuto</span>
                </div>
            </div>

            <!-- Empty space for Chart prominence -->
            <div class="flex-1"></div>

            <!-- Alert Overlay (Flash effect) -->
            <div id="alert-flash"
                class="absolute inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-300 bg-red-600/20">
            </div>

            <!-- Footer Sensors Info -->
            <div class="w-full py-8 px-12 flex justify-center items-center gap-12 opacity-30 z-20 shrink-0">
                <div class="flex flex-col items-center gap-1 text-white text-white">
                    <span class="text-[8px] tracking-[0.3em] uppercase">Sensor 01</span>
                    <span class="text-[10px] font-bold tracking-widest uppercase">Fotopletismografía</span>
                </div>
                <div class="h-8 w-px bg-white/20"></div>
                <div class="flex flex-col items-center gap-1 text-white text-white text-white">
                    <span class="text-[8px] tracking-[0.3em] uppercase">Red</span>
                    <span class="text-[10px] font-bold tracking-widest uppercase">Adafruit IO Real-time</span>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: PROJECT SPECIFICATIONS -->
    <div id="info-modal"
        class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/60 backdrop-blur-xl transition-all duration-500 opacity-0">
        <div
            class="w-full max-w-4xl max-h-[90vh] border border-white/20 bg-black/80 p-8 md:p-16 shadow-2xl overflow-y-auto relative">
            <button onclick="toggleInfoModal(false)"
                class="absolute top-8 right-8 text-white opacity-40 hover:opacity-100 transition-opacity">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="flex flex-col gap-12 text-white">
                <header class="border-b border-white/10 pb-8">
                    <h3 class="text-3xl md:text-5xl font-black tracking-widest uppercase">Especificaciones</h3>
                    <p class="text-sm tracking-[0.4em] opacity-40 mt-4 uppercase">Carlos Alberto Delgadillo Rocha</p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                    <section>
                        <h4 class="text-xs tracking-[0.4em] uppercase opacity-30 mb-8">01 / Microlocalización</h4>
                        <ul class="flex flex-col gap-6 text-lg md:text-xl font-light tracking-wide">
                            <li class="flex gap-4 items-start"><span class="opacity-20">01.</span> Servicios básicos
                            </li>
                            <li class="flex gap-4 items-start"><span class="opacity-20">02.</span> Accesibilidad:
                                Transporte de carga y personal</li>
                            <li class="flex gap-4 items-start"><span class="opacity-20">03.</span> Costo del terreno
                            </li>
                        </ul>
                    </section>

                    <section>
                        <h4 class="text-xs tracking-[0.4em] uppercase opacity-30 mb-8">02 / Empaque</h4>
                        <div class="flex flex-col gap-8">
                            <div>
                                <p class="text-[10px] tracking-widest uppercase opacity-40 mb-4">Elementos del empaque:
                                </p>
                                <ul class="flex flex-wrap gap-x-6 gap-y-2 text-sm uppercase tracking-widest font-bold">
                                    <li>&bull; QR</li>
                                    <li>&bull; Código de barras</li>
                                    <li>&bull; Logo de la empresa</li>
                                    <li>&bull; Indicaciones de seguridad</li>
                                    <li>&bull; Eslogan</li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-widest uppercase opacity-40 mb-4">Por dentro del empaque:
                                </p>
                                <ul class="flex flex-col gap-2 text-sm uppercase tracking-widest">
                                    <li>&bull; Articulo promocional</li>
                                    <li>&bull; Manual de uso</li>
                                    <li>&bull; Garantía impresa</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>

                <footer
                    class="mt-12 pt-8 border-t border-white/5 flex justify-between items-center text-[10px] tracking-[0.3em] uppercase opacity-20">

                    <span>Carlos Alberto Delgadillo Rocha</span>
                </footer>
            </div>
        </div>
    </div>

    <!-- MODAL: ADD BRACELET -->
    <div id="add-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/90 backdrop-blur-sm transition-all duration-300 opacity-0 text-white">
        <div class="w-full max-w-md border border-white/20 bg-black p-8 md:p-12 shadow-2xl">
            <h3 class="text-2xl font-black tracking-widest uppercase mb-8 border-b border-white/10 pb-4 text-white">
                Nuevo
                Brazalete</h3>
            <div class="flex flex-col gap-6 text-white text-white">
                <div class="flex flex-col gap-2 text-white text-white">
                    <label for="new-bracelet-name"
                        class="text-[10px] tracking-widest uppercase opacity-40 text-white text-white">Nombre del
                        Dispositivo</label>
                    <input type="text" id="new-bracelet-name" maxlength="15" placeholder="EJ. BRAZALETE 04"
                        class="bg-transparent border border-white/20 px-4 py-4 text-sm tracking-widest uppercase outline-none focus:border-white transition-colors placeholder:opacity-20 text-white text-white">
                </div>
                <div class="flex gap-4 mt-4 text-white text-white text-white">
                    <button onclick="toggleModal(false)"
                        class="flex-1 py-4 text-xs tracking-widest uppercase border border-white/10 hover:bg-white/5 transition-colors text-white text-white text-white">Cancelar</button>
                    <button onclick="addBracelet()"
                        class="flex-1 py-4 text-xs tracking-widest uppercase bg-white text-black font-bold hover:bg-white/90 transition-colors">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: DELETE CONFIRMATION -->
    <div id="delete-confirm-modal"
        class="hidden fixed inset-0 z-[60] flex items-center justify-center p-6 bg-black/60 backdrop-blur-md transition-all duration-300 opacity-0 text-white text-white">
        <div class="w-full max-sm border border-white/20 bg-black p-8 md:p-10 shadow-2xl text-center">
            <div class="w-16 h-16 border border-white/20 flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 fill-white text-white" viewBox="0 0 24 24">
                    <path
                        d="M11 15h2v2h-2v-2zm0-8h2v6h-2V7zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
                </svg>
            </div>
            <h3 class="text-xl font-black tracking-widest uppercase mb-2 text-white text-white text-white">¿ELIMINAR
                DISPOSITIVO?</h3>
            <p id="delete-target-name"
                class="text-[10px] tracking-[0.2em] uppercase opacity-40 mb-8 px-4 leading-relaxed text-white text-white text-white">
                BRAZALETE 01</p>
            <div class="flex flex-col gap-3 text-white text-white text-white">
                <button onclick="confirmDelete()"
                    class="w-full py-4 text-xs tracking-widest uppercase bg-white text-black font-bold hover:bg-red-600 hover:text-white transition-all duration-300">Eliminar
                    Definitivamente</button>
                <button onclick="toggleDeleteModal(false)"
                    class="w-full py-4 text-xs tracking-widest uppercase border border-white/10 hover:bg-white/5 transition-colors text-white text-white text-white">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        const aioConfig = {
            username: "{{ config('services.adafruit.username') }}",
            key: "{{ config('services.adafruit.key') }}",
            feed: "{{ config('services.adafruit.feed') }}"
        };

        let currentBpm = "--";
        let bpmHistory = Array(15).fill(70); // Initialize with a baseline to keep line visible
        let braceletsData = {
            1: {
                name: 'Brazalete 01',
                bgName: 'MB-01'
            }
        };

        let nextId = 2;
        let braceletToDeleteId = null;
        let activeBraceletId = null;
        let myChart = null;

        const dashboardView = document.getElementById('dashboard-view');
        const individualView = document.getElementById('individual-view');
        const individualMain = document.getElementById('individual-main');
        const heartContainer = document.getElementById('heart-container');
        const mainHeartIcon = document.getElementById('main-heart-icon');
        const alertFlash = document.getElementById('alert-flash');
        const infoModal = document.getElementById('info-modal');

        window.addEventListener('load', async () => {
            initChart();
            if (aioConfig.username && aioConfig.key && aioConfig.feed) {
                try {
                    const response = await fetch(`https://io.adafruit.com/api/v2/${aioConfig.username}/feeds/${aioConfig.feed}/data/last`, {
                        headers: {
                            'X-AIO-Key': aioConfig.key
                        }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        updateAllBracelets(data.value);
                    }
                } catch (e) { }

                window.connectToAdafruit(
                    aioConfig.username,
                    aioConfig.key,
                    aioConfig.feed,
                    (newValue) => updateAllBracelets(newValue)
                );
            }
        });

        function initChart() {
            const ctx = document.getElementById('bpm-chart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 800);
            gradient.addColorStop(0, 'rgba(255, 255, 255, 0.4)');
            gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

            myChart = new window.Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array(15).fill(''),
                    datasets: [{
                        data: bpmHistory,
                        borderColor: '#ffffff',
                        borderWidth: 6,
                        pointRadius: 0,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: gradient,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            suggestedMin: 40,
                            suggestedMax: 160
                        },
                        x: {
                            display: false
                        }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 50,
                            bottom: 50
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }
        function updateAllBracelets(value) {
            const val = parseInt(value);
            if (isNaN(val)) return;

            currentBpm = val;
            bpmHistory.push(val);
            if (bpmHistory.length > 15) bpmHistory.shift();

            if (myChart) {
                myChart.data.datasets[0].data = bpmHistory;
                myChart.update('none');
            }

            // Update Visual Effects for Full Screen (Local to Main, not Nav)
            updateFullViewVisuals(val);

            // Update Dashboard Cards
            Object.keys(braceletsData).forEach(id => {
                const cardPulse = document.getElementById(`card-pulse-${id}`);
                const cardHeart = document.getElementById(`card-heart-${id}`);
                const cardBg = document.getElementById(`card-bg-${id}`);

                if (cardPulse) {
                    cardPulse.innerText = val;
                    cardPulse.classList.remove('opacity-30');
                    cardHeart.classList.remove('opacity-0');

                    // Local alert background for cards
                    if (cardBg) {
                        cardBg.classList.remove('bg-red-950', 'bg-red-900');
                        if (val >= 120) cardBg.classList.add('bg-red-900');
                        else if (val >= 100) cardBg.classList.add('bg-red-950');
                    }

                    updateHeartAnimation(cardHeart, val);
                }
            });

            if (activeBraceletId) {
                document.getElementById('pulse-value').innerText = val;
                heartContainer.classList.remove('opacity-0');
                updateHeartAnimation(mainHeartIcon, val);
            }
        }

        function updateFullViewVisuals(bpm) {
            // Apply ONLY to the main area, not the navigation
            individualMain.classList.remove('bg-red-950', 'bg-red-900');

            if (bpm >= 120) {
                individualMain.classList.add('bg-red-900');
                alertFlash.classList.add('animate-pulse');
            } else if (bpm >= 100) {
                individualMain.classList.add('bg-red-950');
                alertFlash.classList.remove('animate-pulse');
            } else {
                alertFlash.classList.remove('animate-pulse');
            }
        }

        function updateHeartAnimation(element, bpm) {
            let speed = "0.8s";
            if (bpm >= 120) speed = "0.2s";
            else if (bpm >= 100) speed = "0.4s";

            element.style.animationDuration = speed;
        }

        function toggleModal(show) {
            if (show) {
                document.getElementById('add-modal').classList.remove('hidden');
                setTimeout(() => document.getElementById('add-modal').classList.add('opacity-100'), 10);
            } else {
                document.getElementById('add-modal').classList.remove('opacity-100');
                setTimeout(() => document.getElementById('add-modal').classList.add('hidden'), 300);
            }
        }

        function toggleDeleteModal(show, id = null) {
            const modal = document.getElementById('delete-confirm-modal');
            if (show) {
                braceletToDeleteId = id;
                document.getElementById('delete-target-name').innerText = braceletsData[id].name;
                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.add('opacity-100'), 10);
            } else {
                modal.classList.remove('opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 300);
            }
        }

        function toggleInfoModal(show) {
            if (show) {
                infoModal.classList.remove('hidden');
                setTimeout(() => infoModal.classList.add('opacity-100'), 10);
            } else {
                infoModal.classList.remove('opacity-100');
                setTimeout(() => infoModal.classList.add('hidden'), 500);
            }
        }

        function addBracelet() {
            const nameInput = document.getElementById('new-bracelet-name');
            const name = nameInput.value.trim() || `BRAZALETE ${nextId < 10 ? '0' + nextId : nextId}`;
            const bgName = name.substring(0, 5).toUpperCase();
            const currentId = nextId;

            braceletsData[currentId] = {
                name,
                bgName
            };

            const newCardWrapper = document.createElement('div');
            newCardWrapper.id = `card-${currentId}`;
            newCardWrapper.className = "relative group animate-[fadeIn_0.5s_ease-out]";
            newCardWrapper.innerHTML = `
                    <button id="card-bg-${currentId}" onclick="openBracelet(${currentId})" class="w-full text-left border border-white/20 p-8 flex flex-col gap-8 hover:bg-white hover:text-black transition-all duration-700 group/card text-white bg-black/40 backdrop-blur-sm overflow-hidden">
                        <div class="flex justify-between items-center w-full border-b border-white/10 group-hover/card:border-black/10 pb-4 relative z-10 text-white group-hover/card:text-black transition-colors duration-700">
                            <h3 class="text-2xl font-bold tracking-widest uppercase">${name}</h3>
                            <div class="text-xs tracking-widest uppercase opacity-30 group-hover/card:opacity-100 flex items-center gap-2">
                                MB-${currentId < 10 ? '00' + currentId : '0' + currentId} <span class="w-1.5 h-1.5 bg-white/30 group-hover/card:bg-black/30 rounded-full"></span>
                            </div>
                        </div>
                        <div class="flex justify-center items-center w-full py-4 relative z-10 text-white group-hover/card:text-black transition-colors duration-700">
                            <div class="flex items-center gap-4">
                                <svg id="card-heart-${currentId}" class="w-8 h-8 fill-white ${currentBpm === '--' ? 'opacity-0' : ''} animate-[heartbeat_0.8s_ease-in-out_infinite]" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span id="card-pulse-${currentId}" class="text-7xl font-black tabular-nums ${currentBpm === '--' ? 'opacity-30' : ''}">${currentBpm}</span>
                                <span class="text-sm tracking-widest opacity-30 group-hover/card:opacity-60 text-white">BPM</span>
                            </div>
                        </div>
                    </button>
                    <button onclick="deleteBracelet(${currentId}, event)" class="absolute top-4 right-4 p-2 opacity-0 group-hover:opacity-100 hover:bg-red-600 transition-all duration-200 z-20" title="Eliminar Brazalete">
                        <svg class="w-4 h-4 fill-white group-hover/card:fill-black group-hover:fill-white transition-colors duration-700" viewBox="0 0 24 24"><path d="M3 6h18v2H3V6zm2 3h14v13a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm3 3v7h2v-7H8zm4 0v7h2v-7h-2zm4 0v7h2v-7h-2zM9 4V2h6v2h5v2H4V4h5z"/></svg>
                    </button>
                `;

            document.getElementById('bracelets-grid').insertBefore(newCardWrapper, document.getElementById('bracelets-grid').lastElementChild);
            const newOption = document.createElement('option');
            newOption.value = currentId;
            newOption.textContent = name;
            newOption.className = "uppercase";
            document.getElementById('bracelet-selector').appendChild(newOption);

            updateActiveCount();
            nextId++;
            toggleModal(false);
        }

        function deleteBracelet(id, event) {
            event.stopPropagation();
            toggleDeleteModal(true, id);
        }

        function confirmDelete() {
            if (!braceletToDeleteId) return;
            const id = braceletToDeleteId;
            delete braceletsData[id];
            const card = document.getElementById(`card-${id}`);
            if (card) {
                card.classList.add('opacity-0', 'scale-95');
                setTimeout(() => card.remove(), 300);
            }
            const option = document.querySelector(`#bracelet-selector option[value="${id}"]`);
            if (option) option.remove();
            updateActiveCount();
            toggleDeleteModal(false);
        }

        function updateActiveCount() {
            const count = Object.keys(braceletsData).length;
            document.getElementById('active-count').innerHTML = `
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    ${count} Dispositivo${count !== 1 ? 's' : ''} Activo${count !== 1 ? 's' : ''}
                </span>`;
        }

        function openBracelet(id) {
            activeBraceletId = id;
            document.getElementById('bracelet-selector').value = id;
            updateIndividualView(id);
            dashboardView.classList.add('hidden');
            individualView.classList.remove('hidden');
            individualView.classList.add('flex');
        }

        function closeBracelet() {
            activeBraceletId = null;
            individualView.classList.add('hidden');
            individualView.classList.remove('flex');
            dashboardView.classList.remove('hidden');
        }

        function switchBracelet(id) {
            activeBraceletId = id;
            updateIndividualView(id);
        }

        function updateIndividualView(id) {
            const data = braceletsData[id];
            if (!data) return;
            document.getElementById('pulse-value').innerText = currentBpm;

            if (currentBpm !== "--") {
                heartContainer.classList.remove('opacity-0');
                updateHeartAnimation(mainHeartIcon, currentBpm);
            }
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            10% {
                transform: scale(1.3);
            }

            20% {
                transform: scale(1);
            }

            30% {
                transform: scale(1.2);
            }

            40% {
                transform: scale(1);
            }
        }
    </style>
</body>

</html>