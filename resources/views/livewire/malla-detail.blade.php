<div>
    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Mensaje de error -->
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-sm relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <x-panels.main>
        <button
            onclick="if(!confirm('¿Estás seguro de borrar los registros seleccionados?')) return false;"
            wire:click="deleteSelected"
            class="btn btn-danger">
            Borrar seleccionados
        </button>
        <div class="mx-auto bg-white max-w-7xl px-6 lg:px-8 py-6 lg:py-8">
            <div
                class="mx-auto items-center flex max-w-3xl flex-col-reverse justify-between gap-16 lg:mx-0 lg:max-w-none
                lg:flex-row">

                <!-- Lado Izquierdo - Datos de la Malla -->
                <div class="w-full lg:max-w-sm lg:flex-auto py-5 px-2 md:px-4 lg:px-0">
                    <h2 class="font-bold text-gray-801 text-xl mb-6">DATOS DE LA MALLA</h2>

                    @if($grid)
                        <!-- Información de la Malla -->
                        <div class="space-y-4">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nombre</label>
                                <p class="text-gray-900 text-lg">{{ $grid->name }}</p>
                            </div>

                            <!-- Archivo PDF -->
                            @if($grid->pdf_file)
                                <div class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Archivo PDF</label>
                                </div>
                            @else
                                <div class="mt-6">
                                    <p class="text-gray-500 text-sm">No hay archivo PDF cargado</p>
                                </div>
                            @endif

                            <!-- Fechas de Gestión -->
                            <div class="border-t pt-4 mt-6">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <label class="block font-semibold text-gray-600">Creado:</label>
                                        <p class="text-gray-700">{{ $grid->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-gray-600">Actualizado:</label>
                                        <p class="text-gray-700">{{ $grid->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="mt-6 space-y-3">
                                @can('admin-access')
                                    <!-- Botón Editar Malla -->
                                    <button wire:click="openModal"
                                            type="button"
                                            class="w-full px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar Malla
                                    </button>

                                    <!-- Botón Borrar Malla -->
                                    <button wire:click="openDeleteModal"
                                            type="button"
                                            class="w-full px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Borrar Malla
                                    </button>
                                @endcan
                            </div>
                        </div>
                    @else
                        <!-- No hay malla registrada -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay malla registrada</h3>

                            @can('admin-access')
                                <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva malla de perforaciones.</p>

                                <!-- Botón Nueva Malla -->
                                <div class="mt-6">
                                    <button wire:click="openModal"
                                            type="button"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                        Nueva Malla
                                    </button>
                                </div>
                            @endcan
                        </div>
                    @endif
                </div>

                <!-- Lado Derecho - Imagen o Placeholder -->
                <div class="w-full">
                    <div class="text-center">
                        @if($grid)
                            <div class="pdf-secure-viewer bg-linear-to-br from-gray-50 to-gray-100 rounded-lg px-6 py-2
                            shadow-lg">
                                <!-- Header del visor -->
                                <div class="mb-4 text-center">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $grid->name }}</h3>
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        🔒 Visualización Segura - Impresión Deshabilitada
                                    </div>
                                </div>

                                <!-- Controles de navegación -->
                                <div
                                    class="controls mb-6 flex items-center justify-between bg-white rounded-xl px-6 py-4 shadow-xs border">
                                    <button onclick="prevPage()" id="prevBtn"
                                            class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all duration-200 shadow-xs">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Anterior
                                    </button>

                                    <div class="hidden md:flex items-center space-x-6">
                        <span class="text-sm font-medium text-gray-700">
                            Página <span id="currentPage" class="font-bold text-blue-600">1</span>
                            de <span id="totalPages" class="font-bold text-blue-600">--</span>
                        </span>
                                        <!-- Input para ir a página específica -->
                                        <div class="flex items-center space-x-2">
                                            <label for="pageInput" class="text-xs text-gray-500">Ir a:</label>
                                            <input type="number" id="pageInput" min="1"
                                                   class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   onchange="goToPage(this.value)"
                                                   onkeypress="if(event.key==='Enter') goToPage(this.value)">
                                            <button onclick="goToPage(document.getElementById('pageInput').value)"
                                                    class="px-3 py-1 bg-blue-main text-white rounded-md text-sm hover:bg-blue-700
                                                    transition-colors shadow-xs">
                                                Ir
                                            </button>
                                        </div>

                                        <!-- Zoom controls -->
                                        <div class="lg:hidden flex items-center space-x-1">
                                            <button onclick="zoomOut()"
                                                    class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition-colors"
                                                    title="Alejar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                                                </svg>
                                            </button>
                                            <span id="zoomLevel"
                                                  class="text-xs text-gray-500 min-w-12 text-center">100%</span>
                                            <button onclick="zoomIn()"
                                                    class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition-colors"
                                                    title="Acercar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <button onclick="nextPage()" id="nextBtn"
                                            class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all duration-200 shadow-xs">
                                        Siguiente
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Indicador de carga -->
                                <div id="loadingIndicator" class="hidden mb-4">
                                    <div class="flex items-center justify-center py-4">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                        <span class="ml-3 text-sm text-gray-600">Cargando página...</span>
                                    </div>
                                </div>

                                <!-- Contenedor de la imagen del PDF -->
                                <div
                                    class="pdf-image-container bg-white rounded-xl shadow-inner p-5 min-h-[600px] max-h-[800px]
                                     overflow-auto border" id="imageContainer">
                                    <div class="flex items-center justify-center min-h-[550px]" id="imageWrapper">
                                        <img id="pdfImage"
                                             src="{{ route('malla.pdf.image', ['id' => $grid->id, 'page' => 1]) }}"
                                             class="max-w-full h-auto object-contain shadow-lg rounded-sm transition-transform duration-200"
                                             oncontextmenu="return false;"
                                             ondragstart="return false;"
                                             onload="hideLoading()"
                                             onerror="showError()"
                                             {{--                                             style="user-select: none; -webkit-user-select: none; -moz-user-select: none; transform: scale(1);--}}
                                             style="user-select: none; -webkit-user-select: none; -moz-user-select: none; transform: scale(1); transform-origin: center; ">
                                    </div>

                                    <!-- Mensaje de error -->
                                    <div id="errorMessage" class="hidden text-center py-12">
                                        <div class="text-red-500 mb-4">
                                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Error al cargar la página</h4>
                                        <p class="text-gray-600 mb-4">No se pudo mostrar la página del PDF</p>
                                        <button onclick="retryLoad()"
                                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-xs">
                                            Reintentar
                                        </button>
                                    </div>
                                </div>

                                <!-- Información adicional -->
                                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        <span>📄 Formato: PDF convertido a imagen</span>
                                        <span>🔍 Zoom: <span id="currentZoom">100%</span></span>
                                    </div>
                                    <div class="text-right">
                                        <p>Última actualización: {{ $grid->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <script>
                                let currentPage = 1;
                                let totalPages = 1;
                                let currentZoom = 1.0;
                                const gridId = {{ $grid->id }};
                                const minZoom = 0.5;
                                const maxZoom = 3.0;
                                const zoomStep = 0.25;

                                // Inicializar al cargar la página
                                document.addEventListener('DOMContentLoaded', function () {
                                    loadPageCount();
                                    updatePageInput();
                                    setupSecurityMeasures();
                                });

                                async function loadPageCount() {
                                    try {
                                        const response = await fetch(`/malla/pdf/${gridId}/pages`);
                                        const data = await response.json();

                                        if (data.total_pages) {
                                            totalPages = data.total_pages;
                                            document.getElementById('totalPages').textContent = totalPages;
                                            document.getElementById('pageInput').max = totalPages;
                                            updateButtons();
                                        }
                                    } catch (error) {
                                        console.error('Error loading page count:', error);
                                        totalPages = 1;
                                    }
                                }

                                function prevPage() {
                                    if (currentPage > 1) {
                                        currentPage--;
                                        updateImage();
                                    }
                                }

                                function nextPage() {
                                    if (currentPage < totalPages) {
                                        currentPage++;
                                        updateImage();
                                    }
                                }

                                function goToPage(page) {
                                    const pageNum = parseInt(page);
                                    if (pageNum >= 1 && pageNum <= totalPages && pageNum !== currentPage) {
                                        currentPage = pageNum;
                                        updateImage();
                                    } else if (pageNum < 1 || pageNum > totalPages) {
                                        showNotification(`Página debe estar entre 1 y ${totalPages}`, 'warning');
                                        document.getElementById('pageInput').value = currentPage;
                                    }
                                }

                                function updateImage() {
                                    showLoading();
                                    const img = document.getElementById('pdfImage');

                                    // Añadir timestamp para evitar caché
                                    const timestamp = new Date().getTime();
                                    img.src = `/malla/pdf/${gridId}/image/${currentPage}?t=${timestamp}`;

                                    document.getElementById('currentPage').textContent = currentPage;
                                    updatePageInput();
                                    updateButtons();
                                }

                                function updatePageInput() {
                                    document.getElementById('pageInput').value = currentPage;
                                }

                                function updateButtons() {
                                    const prevBtn = document.getElementById('prevBtn');
                                    const nextBtn = document.getElementById('nextBtn');

                                    prevBtn.disabled = currentPage <= 1;
                                    nextBtn.disabled = currentPage >= totalPages;
                                }

                                function zoomIn() {
                                    if (currentZoom < maxZoom) {
                                        currentZoom = Math.min(currentZoom + zoomStep, maxZoom);
                                        applyZoom();
                                    }
                                }

                                function zoomOut() {
                                    if (currentZoom > minZoom) {
                                        currentZoom = Math.max(currentZoom - zoomStep, minZoom);
                                        applyZoom();
                                    }
                                }

                                function applyZoom() {
                                    const img = document.getElementById('pdfImage');
                                    const container = document.getElementById('imageContainer');
                                    const wrapper = document.getElementById('imageWrapper');

                                    // Aplicar zoom a la imagen
                                    img.style.transform = `scale(${currentZoom})`;

                                    // Ajustar el tamaño del wrapper para permitir scroll cuando hay zoom
                                    const imgNaturalWidth = img.naturalWidth || img.offsetWidth;
                                    const imgNaturalHeight = img.naturalHeight || img.offsetHeight;

                                    const scaledWidth = imgNaturalWidth * currentZoom;
                                    const scaledHeight = imgNaturalHeight * currentZoom;

                                    // Establecer dimensiones mínimas del wrapper para habilitar scroll
                                    wrapper.style.width = `${Math.max(scaledWidth, container.offsetWidth)}px`;
                                    wrapper.style.height = `${Math.max(scaledHeight, container.offsetHeight)}px`;

                                    const zoomPercent = Math.round(currentZoom * 100);
                                    document.getElementById('zoomLevel').textContent = `${zoomPercent}%`;
                                    document.getElementById('currentZoom').textContent = `${zoomPercent}%`;

                                    // Centrar automáticamente la imagen al hacer zoom
                                    if (currentZoom > 1) {
                                        const containerRect = container.getBoundingClientRect();
                                        const scrollX = (scaledWidth - containerRect.width) / 2;
                                        const scrollY = (scaledHeight - containerRect.height) / 2;

                                        container.scrollLeft = Math.max(0, scrollX);
                                        container.scrollTop = Math.max(0, scrollY);
                                    } else {
                                        // Reset scroll cuando zoom es 100% o menor
                                        container.scrollLeft = 0;
                                        container.scrollTop = 0;
                                        wrapper.style.width = '100%';
                                        wrapper.style.height = 'auto';
                                    }
                                }

                                function showLoading() {
                                    document.getElementById('loadingIndicator').classList.remove('hidden');
                                    document.getElementById('errorMessage').classList.add('hidden');
                                }

                                function hideLoading() {
                                    document.getElementById('loadingIndicator').classList.add('hidden');
                                }

                                function showError() {
                                    document.getElementById('loadingIndicator').classList.add('hidden');
                                    document.getElementById('errorMessage').classList.remove('hidden');
                                    document.getElementById('pdfImage').style.display = 'none';
                                }

                                function retryLoad() {
                                    document.getElementById('errorMessage').classList.add('hidden');
                                    document.getElementById('pdfImage').style.display = 'block';
                                    updateImage();
                                }

                                function showNotification(message, type = 'info') {
                                    const notification = document.createElement('div');
                                    const bgColor = type === 'error' ? 'bg-red-500' :
                                        type === 'warning' ? 'bg-yellow-500' :
                                            type === 'success' ? 'bg-green-500' : 'bg-blue-500';

                                    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 text-white ${bgColor} transform transition-all duration-300`;
                                    notification.textContent = message;

                                    document.body.appendChild(notification);

                                    // Animación de entrada
                                    setTimeout(() => notification.classList.add('translate-y-0'), 100);

                                    setTimeout(() => {
                                        notification.classList.add('-translate-y-full', 'opacity-0');
                                        setTimeout(() => notification.remove(), 300);
                                    }, 3000);
                                }

                                function setupSecurityMeasures() {
                                    const viewer = document.querySelector('.pdf-secure-viewer');

                                    // Deshabilitar clic derecho
                                    viewer.addEventListener('contextmenu', function (e) {
                                        e.preventDefault();
                                        showNotification('El menú contextual está deshabilitado por seguridad', 'warning');
                                    });

                                    // Deshabilitar selección de texto
                                    viewer.addEventListener('selectstart', function (e) {
                                        e.preventDefault();
                                    });

                                    // Deshabilitar arrastrar imagen
                                    viewer.addEventListener('dragstart', function (e) {
                                        e.preventDefault();
                                    });

                                    // Interceptar wheel para zoom con scroll
                                    viewer.addEventListener('wheel', function (e) {
                                        if (e.ctrlKey) {
                                            e.preventDefault();
                                            if (e.deltaY < 0) {
                                                zoomIn();
                                            } else {
                                                zoomOut();
                                            }
                                        }
                                    });

                                    // Habilitar arrastrar para navegación cuando hay zoom
                                    let isDragging = false;
                                    let startX, startY, scrollLeft, scrollTop;

                                    viewer.addEventListener('mousedown', function (e) {
                                        if (currentZoom > 1 && e.target.id === 'pdfImage') {
                                            isDragging = true;
                                            startX = e.pageX - viewer.offsetLeft;
                                            startY = e.pageY - viewer.offsetTop;
                                            const container = document.getElementById('imageContainer');
                                            scrollLeft = container.scrollLeft;
                                            scrollTop = container.scrollTop;
                                            viewer.style.cursor = 'grabbing';
                                            e.preventDefault();
                                        }
                                    });

                                    viewer.addEventListener('mouseleave', function () {
                                        isDragging = false;
                                        viewer.style.cursor = 'default';
                                    });

                                    viewer.addEventListener('mouseup', function () {
                                        isDragging = false;
                                        viewer.style.cursor = currentZoom > 1 ? 'grab' : 'default';
                                    });

                                    viewer.addEventListener('mousemove', function (e) {
                                        if (!isDragging) return;
                                        e.preventDefault();
                                        const container = document.getElementById('imageContainer');
                                        const x = e.pageX - viewer.offsetLeft;
                                        const y = e.pageY - viewer.offsetTop;
                                        const walkX = (x - startX) * 2;
                                        const walkY = (y - startY) * 2;
                                        container.scrollLeft = scrollLeft - walkX;
                                        container.scrollTop = scrollTop - walkY;
                                    });


                                    // Interceptar teclas peligrosas
                                    document.addEventListener('keydown', function (e) {
                                        // Ctrl+P (Imprimir)
                                        if (e.ctrlKey && e.key === 'p') {
                                            e.preventDefault();
                                            showNotification('La impresión está deshabilitada', 'warning');
                                        }
                                        // Ctrl+S (Guardar)
                                        if (e.ctrlKey && e.key === 's') {
                                            e.preventDefault();
                                            showNotification('Guardar está deshabilitado', 'warning');
                                        }
                                        // Ctrl+C (Copiar) dentro del visor
                                        if (e.ctrlKey && e.key === 'c' && e.target.closest('.pdf-secure-viewer')) {
                                            e.preventDefault();
                                            showNotification('Copiar está deshabilitado', 'warning');
                                        }
                                    });

                                    // Navegación con teclas de flecha
                                    document.addEventListener('keydown', function (e) {
                                        if (e.target.closest('.pdf-secure-viewer')) {
                                            if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
                                                e.preventDefault();
                                                prevPage();
                                            } else if (e.key === 'ArrowRight' || e.key === 'PageDown') {
                                                e.preventDefault();
                                                nextPage();
                                            }
                                        }
                                    });
                                }

                                // Detectar intentos de guardar imagen (click derecho, drag, etc.)
                                document.addEventListener('keydown', function (e) {
                                    // Detectar Ctrl+Shift+I (DevTools)
                                    if (e.ctrlKey && e.shiftKey && e.key === 'I') {
                                        // Solo mostrar advertencia, no bloquear completamente
                                        showNotification('Recuerda: Este contenido está protegido', 'info');
                                    }
                                });
                            </script>

                        @else
                            <div class="flex flex-col items-center justify-center py-16">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-6xl text-gray-400 font-bold mb-2">404</p>
                                <p class="text-gray-500 text-lg">NO ENCONTRADO</p>
                                <p class="text-gray-400 text-sm mt-2">No hay ninguna malla de perforaciones cargada</p>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>

        <hr class="text-yellow-main my-4">
        <!-- Drilling parameters -->
        @include('partial.drilling-parameters')

    </x-panels.main>

    <!-- Modal de Edición/Creación -->
    @if($showModal)
        <div class="fixed inset-0 bg-blue-main/90 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <form wire:submit.prevent="save">
                    <!-- Modal Header -->
                    <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $grid ? 'Editar' : 'Nueva' }} Malla de Perforaciones
                            </h3>
                            <button type="button"
                                    wire:click="closeModal"
                                    class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Nombre de la Malla -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre de la Malla <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   wire:model.defer="name"
                                   id="name"
                                   class="w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Malla 2025-08-22 01:47">
                            @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Archivo PDF -->
                        <div>
                            <label for="pdfFile" class="block text-sm font-medium text-gray-700 mb-1">
                                Archivo PDF de la Malla:<span class="text-red-500"> {{ !$grid ? '*' :'' }} </span>
                            </label>
                            <input type="file"
                                   wire:model="pdfFile"
                                   id="pdfFile"
                                   accept=".pdf"
                                   class="w-full rounded-md border-2 p-1 shadow-xs focus:border-indigo-500 bg-gray-200
                                   focus:ring-indigo-500 cursor-pointer">

                            @if($existingPdfFile && !$pdfFile)
                                <p class="text-sm text-gray-500 mt-1">
                                    Archivo actual: {{ basename($existingPdfFile) }}
                                </p>
                            @endif

                            @if ($pdfFile)
                                <p class="text-sm text-green-600 mt-1">
                                    Nuevo archivo seleccionado: {{ $pdfFile->getClientOriginalName() }}
                                </p>
                            @endif

                            <div wire:loading wire:target="pdfFile" class="text-sm text-blue-600 mt-1">
                                Subiendo archivo...
                            </div>

                            @error('pdfFile')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="sticky bottom-0 bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button type="button"
                                    wire:click="closeModal"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                                Cancelar
                            </button>
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">
                                <span wire:loading.remove wire:target="save">
                                    {{ $grid ? 'Actualizar' : 'Guardar' }} Malla
                                </span>
                                <span wire:loading wire:target="save">
                                    Guardando...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal de Confirmación de Eliminación -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-md w-full">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Confirmar Eliminación
                        </h3>
                        <button type="button"
                                wire:click="closeDeleteModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <p class="text-gray-700 mb-4">
                        ¿Estás seguro de que deseas eliminar la malla "<strong>{{ $grid->name }}</strong>"?
                    </p>
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div class="text-sm text-red-700">
                                <p class="font-medium">Esta acción no se puede deshacer.</p>
                                <p class="mt-1">Se eliminará permanentemente la malla y el archivo PDF asociado.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                wire:click="closeDeleteModal"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                            Cancelar
                        </button>
                        <button type="button"
                                wire:click="delete"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span wire:loading.remove wire:target="delete">
                                Eliminar Definitivamente
                            </span>
                            <span wire:loading wire:target="delete">
                                Eliminando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
