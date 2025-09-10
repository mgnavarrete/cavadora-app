<!-- Modal para Editar Turno desde Calendario -->
<div class="modal fade" id="editShiftCalendarModal" tabindex="-1" aria-labelledby="editShiftCalendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editShiftCalendarModalLabel">
                    <i class="ri-calendar-event-line me-2"></i>
                    Editar Turno de Trabajo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <div class="modal-body">
                <form id="editShiftCalendarForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Información del Turno -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Información del Turno
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Cliente:</strong> <span id="modal-client-name">-</span></p>
                                            <p class="mb-2"><strong>Orden:</strong> #<span id="modal-order-id">-</span></p>
                                            <p class="mb-2"><strong>Fecha:</strong> <span id="modal-shift-date">-</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Horario:</strong> <span id="modal-shift-time">-</span></p>
                                            <p class="mb-2"><strong>Duración:</strong> <span id="modal-shift-duration">-</span></p>
                                            <p class="mb-2"><strong>Estado Actual:</strong> <span id="modal-current-status" class="badge">-</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos Editables -->
                    <div class="row">
                        <!-- Estado del Turno -->
                        <div class="col-md-4 mb-3">
                            <label for="modal-status" class="form-label fw-semibold">
                                <i class="ri-flag-line me-1"></i>Estado del Turno
                            </label>
                            <select class="form-select" id="modal-status" name="status" required>
                                <option value="pending">Pendiente</option>
                                <option value="completed">Completado</option>
                                <option value="canceled">Cancelado</option>
                                <option value="rescheduled">Reprogramado</option>
                            </select>
                        </div>

                        <!-- Responsable/Operador -->
                        <div class="col-md-8 mb-3">
                            <label for="modal-responsible" class="form-label fw-semibold">
                                <i class="ri-user-3-line me-1"></i>Responsable/Operador
                            </label>
                            <input type="text" class="form-control" id="modal-responsible" name="responsible" 
                                   placeholder="Nombre del responsable del turno">
                        </div>
                    </div>

                    <!-- Horarios del Turno -->
                    <div class="row">
                        <!-- Hora de Inicio -->
                        <div class="col-md-6 mb-3">
                            <label for="modal-start-time" class="form-label fw-semibold">
                                <i class="ri-time-line me-1"></i>Hora de Inicio
                            </label>
                            <input type="time" class="form-control" id="modal-start-time" name="start_time" required>
                        </div>

                        <!-- Hora de Fin -->
                        <div class="col-md-6 mb-3">
                            <label for="modal-end-time" class="form-label fw-semibold">
                                <i class="ri-time-line me-1"></i>Hora de Fin
                            </label>
                            <input type="time" class="form-control" id="modal-end-time" name="end_time" required>
                            <div class="form-text text-muted">
                                <i class="ri-information-line me-1"></i>
                                Mínimo 8 horas de duración por turno
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="modal-description" class="form-label fw-semibold">
                                <i class="ri-file-text-line me-1"></i>Descripción del Trabajo
                            </label>
                            <textarea class="form-control" id="modal-description" name="description" rows="4" 
                                      placeholder="Describe las actividades realizadas en este turno..."></textarea>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> Los cambios se guardarán automáticamente y se reflejarán en el calendario. Para editar horarios, todos los turnos deben tener una duración mínima de 8 horas.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveShiftChanges">
                    <i class="ri-save-line me-1"></i>Guardar Cambios
                </button>
                <button type="button" class="btn btn-primary" id="viewOrderDetails">
                    <i class="ri-external-link-line me-1"></i>Ver Detalles
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentShiftId = null;
    let currentOrderId = null;

    // Función para abrir el modal con datos del turno
    window.openShiftModal = function(shiftData) {
        currentShiftId = shiftData.id;
        currentOrderId = shiftData.orderId;
        
        // Rellenar información del turno
        document.getElementById('modal-client-name').textContent = shiftData.clientName || 'N/A';
        document.getElementById('modal-order-id').textContent = shiftData.orderId || 'N/A';
        document.getElementById('modal-shift-date').textContent = shiftData.date || 'N/A';
        document.getElementById('modal-shift-time').textContent = shiftData.time || 'N/A';
        document.getElementById('modal-shift-duration').textContent = shiftData.duration || 'N/A';
        
        // Estado actual con badge
        const statusBadge = document.getElementById('modal-current-status');
        statusBadge.textContent = shiftData.statusText || 'N/A';
        statusBadge.className = 'badge ' + getStatusBadgeClass(shiftData.status);
        
        // Rellenar campos editables
        document.getElementById('modal-status').value = shiftData.status || 'pending';
        document.getElementById('modal-responsible').value = shiftData.responsible || '';
        document.getElementById('modal-description').value = shiftData.description || '';
        
        // Rellenar campos de tiempo si están disponibles
        if (shiftData.startTime) document.getElementById('modal-start-time').value = shiftData.startTime;
        if (shiftData.endTime) document.getElementById('modal-end-time').value = shiftData.endTime;
        
        // Configurar formulario
        const form = document.getElementById('editShiftCalendarForm');
        form.action = `/shifts/${currentShiftId}/status`;
        
        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('editShiftCalendarModal'));
        modal.show();
    };

    // Función para obtener clase CSS del badge según estado
    function getStatusBadgeClass(status) {
        switch(status) {
            case 'completed': return 'bg-success';
            case 'pending': return 'bg-secondary';
            case 'canceled': return 'bg-danger';
            case 'rescheduled': return 'bg-warning';
            default: return 'bg-secondary';
        }
    }

    // Función para obtener texto del estado
    function getStatusText(status) {
        switch(status) {
            case 'completed': return 'Completado';
            case 'pending': return 'Pendiente';
            case 'canceled': return 'Cancelado';
            case 'rescheduled': return 'Reprogramado';
            default: return 'Pendiente';
        }
    }

    // Guardar cambios
    document.getElementById('saveShiftChanges').addEventListener('click', function() {
        const form = document.getElementById('editShiftCalendarForm');
        const formData = new FormData(form);
        
        // Agregar el método PUT y token CSRF
        formData.append('_method', 'PUT');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');
        
        const submitBtn = this;
        const originalText = submitBtn.innerHTML;
        
        // Estado de carga
        submitBtn.innerHTML = '<i class="ri-loader-4-line me-1 spin"></i>Guardando...';
        submitBtn.disabled = true;
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                alert('Turno actualizado correctamente');
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editShiftCalendarModal'));
                modal.hide();
                
                // Recargar calendario
                if (typeof calendar !== 'undefined') {
                    calendar.refetchEvents();
                } else {
                    location.reload();
                }
            } else {
                alert('Error al actualizar el turno: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión: ' + error.message);
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Ver detalles completos de la orden
    document.getElementById('viewOrderDetails').addEventListener('click', function() {
        if (currentOrderId) {
            window.open('/orders/' + currentOrderId, '_blank');
        }
    });

    // Auto-calcular hora de fin y validar mínimo 8 horas
    const modalStartTimeInput = document.getElementById('modal-start-time');
    const modalEndTimeInput = document.getElementById('modal-end-time');
    
    if (modalStartTimeInput && modalEndTimeInput) {
        // Función para calcular automáticamente la hora de fin (+8 horas)
        function autoCalculateModalEndTime() {
            const startTime = modalStartTimeInput.value;
            
            if (startTime) {
                // Crear fecha base para cálculos
                const startDate = new Date(`2000-01-01 ${startTime}`);
                
                // Agregar 8 horas
                const endDate = new Date(startDate.getTime() + (8 * 60 * 60 * 1000));
                
                // Formatear la hora de fin
                const hours = endDate.getHours().toString().padStart(2, '0');
                const minutes = endDate.getMinutes().toString().padStart(2, '0');
                const endTimeFormatted = `${hours}:${minutes}`;
                
                // Establecer la hora de fin calculada
                modalEndTimeInput.value = endTimeFormatted;
                
                // Limpiar cualquier mensaje de validación
                modalEndTimeInput.setCustomValidity('');
            }
        }

        // Función para validar que el turno tenga mínimo 8 horas
        function validateModalMinimumHours() {
            const startTime = modalStartTimeInput.value;
            const endTime = modalEndTimeInput.value;
            
            if (startTime && endTime) {
                // Crear objetos Date para calcular la diferencia
                const startDate = new Date(`2000-01-01 ${startTime}`);
                const endDate = new Date(`2000-01-01 ${endTime}`);
                
                // Si la hora de fin es menor, asumimos que es al día siguiente
                if (endDate <= startDate) {
                    endDate.setDate(endDate.getDate() + 1);
                }
                
                // Calcular diferencia en horas
                const diffInMs = endDate - startDate;
                const diffInHours = diffInMs / (1000 * 60 * 60);
                
                if (diffInHours < 8) {
                    modalEndTimeInput.setCustomValidity('El turno debe tener una duración mínima de 8 horas');
                    return false;
                } else {
                    modalEndTimeInput.setCustomValidity('');
                    return true;
                }
            }
            return false;
        }
        
        // Auto-calcular cuando cambie la hora de inicio
        modalStartTimeInput.addEventListener('change', function() {
            autoCalculateModalEndTime();
            validateModalMinimumHours();
        });
        
        // Validar cuando cambie la hora de fin manualmente
        modalEndTimeInput.addEventListener('change', validateModalMinimumHours);
    }
});
</script>

<style>
.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
