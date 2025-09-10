<!-- Modal para Editar Información del Cliente/Orden -->
<div class="modal fade" id="editOrder" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">
                    <i class="ri-user-settings-line me-2"></i>Editar Información del Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('orders.update', $order->id_order) }}" method="POST" id="editOrderForm">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <!-- Información del Cliente -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Información Actual
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Orden ID:</strong> #{{ $order->id_order }}</p>
                                            <p class="mb-2"><strong>Estado:</strong> 
                                                <span class="badge {{ $estadoColor }}">{{ $estadoTexto }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Fecha Creación:</strong> 
                                                {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}
                                            </p>
                                            <p class="mb-2"><strong>Última Actualización:</strong> 
                                                {{ $order->updated_at ? $order->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Cliente -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-user-line me-2"></i>
                                Datos del Cliente
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Nombre del Cliente -->
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label fw-semibold">
                                <i class="ri-user-3-line me-1"></i>Nombre del Cliente <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="client_name" name="client_name" 
                                   value="{{ old('client_name', $order->client_name) }}" required maxlength="100">
                        </div>

                        <!-- RUT del Cliente -->
                        <div class="col-md-6 mb-3">
                            <label for="cliente_rut" class="form-label fw-semibold">
                                <i class="ri-id-card-line me-1"></i>RUT del Cliente
                            </label>
                            <input type="text" class="form-control" id="cliente_rut" name="cliente_rut" 
                                   value="{{ old('cliente_rut', $order->cliente_rut) }}" placeholder="12.345.678-9" maxlength="12">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <label for="client_phone" class="form-label fw-semibold">
                                <i class="ri-phone-line me-1"></i>Teléfono
                            </label>
                            <input type="tel" class="form-control" id="client_phone" name="client_phone" 
                                   value="{{ old('client_phone', $order->client_phone) }}" placeholder="+56 9 1234 5678" maxlength="15">
                        </div>

                        <!-- Estado del Trabajo -->
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label fw-semibold">
                                <i class="ri-flag-line me-1"></i>Estado del Trabajo <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="confirmed" {{ $order->estado === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                <option value="in_progress" {{ $order->estado === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                <option value="done" {{ $order->estado === 'done' ? 'selected' : '' }}>Completado</option>
                                <option value="canceled" {{ $order->estado === 'canceled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="client_address" class="form-label fw-semibold">
                                <i class="ri-map-pin-line me-1"></i>Dirección del Cliente
                            </label>
                            <textarea class="form-control" id="client_address" name="client_address" rows="2" 
                                      placeholder="Dirección completa del cliente" maxlength="255">{{ old('client_address', $order->client_address) }}</textarea>
                        </div>
                    </div>

                    <!-- Información del Trabajo -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-tools-line me-2"></i>
                                Información del Trabajo
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Descripción del Trabajo -->
                        <div class="col-12 mb-3">
                            <label for="work_info" class="form-label fw-semibold">
                                <i class="ri-file-text-line me-1"></i>Descripción del Trabajo <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="work_info" name="work_info" rows="4" 
                                      placeholder="Describe detalladamente el trabajo a realizar..." required maxlength="500">{{ old('work_info', $order->work_info) }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Fecha de Inicio -->
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label fw-semibold">
                                <i class="ri-calendar-line me-1"></i>Fecha de Inicio
                            </label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ old('start_date', $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('Y-m-d') : '') }}">
                        </div>

                        <!-- Fecha de Fin -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label fw-semibold">
                                <i class="ri-calendar-check-line me-1"></i>Fecha de Fin
                            </label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ old('end_date', $order->end_date ? \Carbon\Carbon::parse($order->end_date)->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <!-- Costos -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-money-dollar-circle-line me-2"></i>
                                Información de Costos
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Costo por Hora -->
                        <div class="col-md-6 mb-3">
                            <label for="hour_cost" class="form-label fw-semibold">
                                <i class="ri-time-line me-1"></i>Costo por Hora
                            </label>
                            <input type="text" class="form-control" id="hour_cost" name="hour_cost" 
                                   value="{{ old('hour_cost', $order->hour_cost) }}" placeholder="18750" oninput="formatCurrency(this)">
                        </div>

                        <!-- Costo Extra -->
                        <div class="col-md-6 mb-3">
                            <label for="extra_cost" class="form-label fw-semibold">
                                <i class="ri-add-circle-line me-1"></i>Costo Extra
                            </label>
                            <input type="text" class="form-control" id="extra_cost" name="extra_cost" 
                                   value="{{ old('extra_cost', $order->extra_cost) }}" placeholder="0" oninput="formatCurrency(this)">
                        </div>
                    </div>

                    <!-- Zona de Peligro -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-error-warning-line me-2"></i>
                                        Zona de Peligro
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">
                                        <strong>¡Atención!</strong> Eliminar este cliente borrará permanentemente:
                                    </p>
                                    <ul class="text-muted mb-3">
                                        <li>Toda la información del cliente y orden de trabajo</li>
                                        <li>Todas las sesiones de trabajo programadas y completadas</li>
                                        <li>Todos los pagos y registros financieros</li>
                                        <li>Todas las relaciones de usuario asociadas</li>
                                    </ul>
                                    <p class="text-danger fw-semibold mb-3">Esta acción no se puede deshacer.</p>
                                    
                                    <button type="button" class="btn btn-outline-danger" onclick="confirmDeleteOrder({{ $order->id_order }}, '{{ $order->client_name }}')">
                                        <i class="ri-delete-bin-line me-1"></i>Eliminar Cliente y Toda su Información
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <span class="text-muted small">* Campos obligatorios</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="updateOrderBtn">
                                <i class="ri-save-line me-1"></i>Guardar Cambios
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formatear campos de moneda (función global para los inputs)
    window.formatCurrency = function(input) {
        let value = input.value.replace(/\D/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('es-CL');
        }
        input.value = value;
    };

    // Manejar envío del formulario
    const editOrderForm = document.getElementById('editOrderForm');
    if (editOrderForm) {
        editOrderForm.addEventListener('submit', function() {
            const submitBtn = document.getElementById('updateOrderBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Guardando...';
            }
        });
    }

    // Validar fechas
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && this.value > endDateInput.value) {
                alert('La fecha de inicio no puede ser posterior a la fecha de fin');
                this.value = '';
            }
        });
        
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                alert('La fecha de fin no puede ser anterior a la fecha de inicio');
                this.value = '';
            }
        });
    }
});

// Función para confirmar eliminación completa
function confirmDeleteOrder(orderId, clientName) {
    const message = `¿Estás completamente seguro de que deseas eliminar toda la información de "${clientName}"?\n\n` +
                   `Esta acción eliminará PERMANENTEMENTE:\n` +
                   `• El cliente y su orden de trabajo\n` +
                   `• Todas las sesiones de trabajo\n` +
                   `• Todos los pagos registrados\n` +
                   `• Todas las relaciones de usuario\n\n` +
                   `ESTA ACCIÓN NO SE PUEDE DESHACER.\n\n` +
                   `Escribe "ELIMINAR" para confirmar:`;
    
    const confirmation = prompt(message);
    
    if (confirmation === 'ELIMINAR') {
        // Crear formulario para DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/orders') }}/${orderId}/complete-delete`;
        form.style.display = 'none';
        
        // Agregar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        // Agregar método DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Enviar formulario
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    } else if (confirmation !== null) {
        alert('Confirmación incorrecta. La eliminación ha sido cancelada.');
    }
}
</script>
