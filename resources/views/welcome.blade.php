<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MyBracelet - Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-black text-white min-h-screen w-full overflow-x-hidden font-sans text-white">
        
        <!-- MAIN DASHBOARD VIEW -->
        <div id="dashboard-view" class="min-h-screen w-full flex flex-col p-6 md:p-12 transition-opacity duration-500">
            <header class="mb-12 flex flex-col md:flex-row md:justify-between md:items-end border-b border-white/20 pb-6 gap-4">
                <div>
                    <h1 class="text-3xl md:text-5xl font-light tracking-[0.2em] uppercase">MyBracelet</h1>
                    <h2 class="text-xl md:text-2xl font-black tracking-widest uppercase mt-2 opacity-80">Overview</h2>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span id="active-count" class="text-xs tracking-widest opacity-50 uppercase flex items-center gap-2">
                        <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        1 Dispositivo Activo
                    </span>
                    <span id="connection-status" class="text-[9px] tracking-[0.2em] uppercase opacity-30">Adafruit: Online</span>
                </div>
            </header>
            
            <div id="bracelets-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Bracelet Card 1 (Only one by default) -->
                <div id="card-1" class="relative group">
                    <button onclick="openBracelet(1)" class="w-full text-left border border-white/20 p-8 flex flex-col gap-8 hover:bg-white hover:text-black transition-all duration-300 group/card">
                        <div class="flex justify-between items-center w-full border-b border-white/10 group-hover/card:border-black/10 pb-4">
                            <h3 class="text-2xl font-bold tracking-widest uppercase">Brazalete 01</h3>
                            <div class="text-xs tracking-widest uppercase opacity-50 group-hover/card:opacity-100 flex items-center gap-2">
                                MB-001 <span class="w-1.5 h-1.5 bg-white group-hover/card:bg-black rounded-full animate-pulse"></span>
                            </div>
                        </div>
                        <div class="flex justify-center items-end w-full py-4">
                            <div>
                                <span id="card-pulse-1" class="text-7xl font-black tabular-nums">--</span>
                                <span class="text-sm tracking-widest opacity-60 ml-1">BPM</span>
                            </div>
                        </div>
                    </button>
                    <button onclick="deleteBracelet(1, event)" class="absolute top-4 right-4 p-2 opacity-0 group-hover:opacity-100 hover:bg-red-600 transition-all duration-200 z-10" title="Eliminar Brazalete">
                        <svg class="w-4 h-4 fill-white group-hover/card:fill-black group-hover:fill-white" viewBox="0 0 24 24">
                            <path d="M3 6h18v2H3V6zm2 3h14v13a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm3 3v7h2v-7H8zm4 0v7h2v-7h-2zm4 0v7h2v-7h-2zM9 4V2h6v2h5v2H4V4h5z"/>
                        </svg>
                    </button>
                </div>

                <!-- Add New Bracelet Button -->
                <button onclick="toggleModal(true)" class="border border-white/10 border-dashed p-8 flex flex-col items-center justify-center gap-4 hover:border-white/40 hover:bg-white/5 transition-all duration-300 group min-h-[220px]">
                    <span class="text-6xl font-light opacity-20 group-hover:opacity-100 group-hover:scale-110 transition-all">+</span>
                    <span class="text-xs tracking-[0.3em] uppercase opacity-40 group-hover:opacity-100">Añadir Brazalete</span>
                </button>
            </div>
        </div>

        <!-- INDIVIDUAL BRACELET VIEW -->
        <div id="individual-view" class="hidden min-h-screen w-full flex-col h-screen overflow-hidden">
            <nav class="w-full border-b border-white/20 p-4 md:px-8 flex justify-between items-center z-20 shrink-0">
                <button onclick="closeBracelet()" class="text-xs md:text-sm tracking-[0.2em] uppercase hover:opacity-50 transition-opacity flex items-center gap-2">
                    <span>&larr;</span> <span class="hidden md:inline">Dashboard</span><span class="md:hidden">Volver</span>
                </button>
                <div class="relative flex items-center gap-4">
                    <span class="text-[10px] tracking-widest uppercase opacity-40 hidden md:block">Monitorizando:</span>
                    <div class="relative group">
                        <select id="bracelet-selector" onchange="switchBracelet(this.value)" class="appearance-none bg-black text-white border border-white/20 px-4 py-2 pr-10 text-xs md:text-sm tracking-widest uppercase cursor-pointer outline-none focus:border-white transition-colors uppercase">
                            <option value="1">Brazalete 01</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none border-l border-white/20 group-hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>
            </nav>
            <main class="flex-1 flex flex-col overflow-hidden relative">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-0 pointer-events-none opacity-[0.03]">
                    <h1 id="bg-bracelet-name" class="text-[8rem] md:text-[20rem] font-black tracking-tighter whitespace-nowrap uppercase">MB-01</h1>
                </div>
                <section class="flex-1 flex flex-col items-center justify-center p-8 relative z-10 group">
                    <div class="absolute top-6 left-1/2 -translate-x-1/2 md:left-8 md:translate-x-0"><span class="text-[10px] tracking-widest uppercase opacity-40">Sensor 01 / Pulso</span></div>
                    
                    <div class="flex flex-col items-center">
                        <span id="pulse-value" class="text-9xl md:text-[18rem] font-black tabular-nums tracking-tighter transition-all duration-300">--</span>
                        <span class="text-xl md:text-3xl font-light tracking-[0.2em] opacity-60 -mt-4 md:-mt-10">BPM</span>
                    </div>

                    <!-- Decorative heart rate line -->
                    <div class="absolute bottom-24 w-48 h-1 bg-white/5 overflow-hidden">
                        <div id="pulse-indicator" class="w-full h-full bg-white/20"></div>
                    </div>
                </section>
            </main>
        </div>

        <!-- MODAL: ADD BRACELET -->
        <div id="add-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/90 backdrop-blur-sm transition-all duration-300 opacity-0">
            <div class="w-full max-w-md border border-white/20 bg-black p-8 md:p-12 shadow-2xl">
                <h3 class="text-2xl font-black tracking-widest uppercase mb-8 border-b border-white/10 pb-4">Nuevo Brazalete</h3>
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-2">
                        <label for="new-bracelet-name" class="text-[10px] tracking-widest uppercase opacity-40">Nombre del Dispositivo</label>
                        <input type="text" id="new-bracelet-name" maxlength="15" placeholder="EJ. BRAZALETE 04" class="bg-transparent border border-white/20 px-4 py-4 text-sm tracking-widest uppercase outline-none focus:border-white transition-colors placeholder:opacity-20 text-white">
                    </div>
                    <div class="flex gap-4 mt-4">
                        <button onclick="toggleModal(false)" class="flex-1 py-4 text-xs tracking-widest uppercase border border-white/10 hover:bg-white/5 transition-colors">Cancelar</button>
                        <button onclick="addBracelet()" class="flex-1 py-4 text-xs tracking-widest uppercase bg-white text-black font-bold hover:bg-white/90 transition-colors">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL: DELETE CONFIRMATION -->
        <div id="delete-confirm-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-6 bg-black/60 backdrop-blur-md transition-all duration-300 opacity-0">
            <div class="w-full max-sm border border-white/20 bg-black p-8 md:p-10 shadow-2xl text-center">
                <div class="w-16 h-16 border border-white/20 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 fill-white" viewBox="0 0 24 24">
                        <path d="M11 15h2v2h-2v-2zm0-8h2v6h-2V7zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black tracking-widest uppercase mb-2">¿ELIMINAR DISPOSITIVO?</h3>
                <p id="delete-target-name" class="text-[10px] tracking-[0.2em] uppercase opacity-40 mb-8 px-4 leading-relaxed">BRAZALETE 01</p>
                <div class="flex flex-col gap-3">
                    <button onclick="confirmDelete()" class="w-full py-4 text-xs tracking-widest uppercase bg-white text-black font-bold hover:bg-red-600 hover:text-white transition-all duration-300">Eliminar Definitivamente</button>
                    <button onclick="toggleDeleteModal(false)" class="w-full py-4 text-xs tracking-widest uppercase border border-white/10 hover:bg-white/5 transition-colors">Cancelar</button>
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
            let braceletsData = {
                1: { name: 'Brazalete 01', bgName: 'MB-01' }
            };

            let nextId = 2;
            let braceletToDeleteId = null;
            let activeBraceletId = null;

            const dashboardView = document.getElementById('dashboard-view');
            const individualView = document.getElementById('individual-view');
            const addModal = document.getElementById('add-modal');
            const deleteModal = document.getElementById('delete-confirm-modal');
            const braceletsGrid = document.getElementById('bracelets-grid');
            const braceletSelector = document.getElementById('bracelet-selector');
            
            // Initialization: Connect to Adafruit
            window.addEventListener('load', async () => {
                if (aioConfig.username && aioConfig.key && aioConfig.feed) {
                    // 1. Fetch last value via REST API for instant update
                    try {
                        const response = await fetch(`https://io.adafruit.com/api/v2/${aioConfig.username}/feeds/${aioConfig.feed}/data/last`, {
                            headers: { 'X-AIO-Key': aioConfig.key }
                        });
                        if (response.ok) {
                            const data = await response.json();
                            updateAllBracelets(data.value);
                        }
                    } catch (e) {
                        // Silent fail for REST
                    }

                    // 2. Connect via MQTT for real-time updates
                    window.connectToAdafruit(
                        aioConfig.username, 
                        aioConfig.key, 
                        aioConfig.feed, 
                        (newValue) => updateAllBracelets(newValue)
                    );
                }
            });

            function updateAllBracelets(value) {
                currentBpm = value;
                // Update all cards in dashboard
                Object.keys(braceletsData).forEach(id => {
                    const cardPulse = document.getElementById(`card-pulse-${id}`);
                    if (cardPulse) {
                        cardPulse.innerText = value;
                        cardPulse.classList.remove('opacity-30');
                    }
                });
                
                // Update individual view if active
                if (activeBraceletId) {
                    document.getElementById('pulse-value').innerText = value;
                    const pulseIndicator = document.getElementById('pulse-indicator');
                    pulseIndicator.classList.add('animate-[pulse_2s_infinite]');
                    pulseIndicator.classList.remove('opacity-10');
                }
            }

            function toggleModal(show) {
                if (show) {
                    addModal.classList.remove('hidden');
                    setTimeout(() => addModal.classList.add('opacity-100'), 10);
                } else {
                    addModal.classList.remove('opacity-100');
                    setTimeout(() => addModal.classList.add('hidden'), 300);
                }
            }

            function toggleDeleteModal(show, id = null) {
                if (show) {
                    braceletToDeleteId = id;
                    document.getElementById('delete-target-name').innerText = braceletsData[id].name;
                    deleteModal.classList.remove('hidden');
                    setTimeout(() => deleteModal.classList.add('opacity-100'), 10);
                } else {
                    deleteModal.classList.remove('opacity-100');
                    setTimeout(() => {
                        deleteModal.classList.add('hidden');
                        braceletToDeleteId = null;
                    }, 300);
                }
            }

            function addBracelet() {
                const nameInput = document.getElementById('new-bracelet-name');
                const name = nameInput.value.trim() || `BRAZALETE ${nextId < 10 ? '0' + nextId : nextId}`;
                const bgName = name.substring(0, 5).toUpperCase();
                const currentId = nextId;

                braceletsData[currentId] = { name, bgName };

                const newCardWrapper = document.createElement('div');
                newCardWrapper.id = `card-${currentId}`;
                newCardWrapper.className = "relative group animate-[fadeIn_0.5s_ease-out]";
                
                newCardWrapper.innerHTML = `
                    <button onclick="openBracelet(${currentId})" class="w-full text-left border border-white/20 p-8 flex flex-col gap-8 hover:bg-white hover:text-black transition-all duration-300 group/card">
                        <div class="flex justify-between items-center w-full border-b border-white/10 group-hover/card:border-black/10 pb-4">
                            <h3 class="text-2xl font-bold tracking-widest uppercase">${name}</h3>
                            <div class="text-xs tracking-widest uppercase opacity-30 group-hover/card:opacity-100 flex items-center gap-2">
                                MB-${currentId < 10 ? '00' + currentId : '0' + currentId} <span class="w-1.5 h-1.5 bg-white/30 group-hover/card:bg-black/30 rounded-full"></span>
                            </div>
                        </div>
                        <div class="flex justify-center items-end w-full py-4">
                            <div>
                                <span id="card-pulse-${currentId}" class="text-7xl font-black tabular-nums ${currentBpm === '--' ? 'opacity-30' : ''}">${currentBpm}</span>
                                <span class="text-sm tracking-widest opacity-30 group-hover/card:opacity-60 ml-1">BPM</span>
                            </div>
                        </div>
                    </button>
                    <button onclick="deleteBracelet(${currentId}, event)" class="absolute top-4 right-4 p-2 opacity-0 group-hover:opacity-100 hover:bg-red-600 transition-all duration-200 z-10" title="Eliminar Brazalete">
                        <svg class="w-4 h-4 fill-white group-hover/card:fill-black group-hover:fill-white" viewBox="0 0 24 24">
                            <path d="M3 6h18v2H3V6zm2 3h14v13a2 2 0 01-2 2H7a2 2 0 01-2-2V9zm3 3v7h2v-7H8zm4 0v7h2v-7h-2zm4 0v7h2v-7h-2zM9 4V2h6v2h5v2H4V4h5z"/>
                        </svg>
                    </button>
                `;
                
                braceletsGrid.insertBefore(newCardWrapper, braceletsGrid.lastElementChild);

                const newOption = document.createElement('option');
                newOption.value = currentId;
                newOption.textContent = name;
                newOption.className = "uppercase";
                braceletSelector.appendChild(newOption);

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
                const option = braceletSelector.querySelector(`option[value="${id}"]`);
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
                braceletSelector.value = id;
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
                document.getElementById('bg-bracelet-name').innerText = data.bgName;

                const pulseIndicator = document.getElementById('pulse-indicator');
                if (currentBpm === '--') {
                    pulseIndicator.classList.remove('animate-[pulse_2s_infinite]');
                    pulseIndicator.classList.add('opacity-10');
                } else {
                    pulseIndicator.classList.add('animate-[pulse_2s_infinite]');
                    pulseIndicator.classList.remove('opacity-10');
                }
            }
        </script>

        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </body>
</html>