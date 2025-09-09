<!-- Modal para Crear Nueva Sesión -->
<div class="modal fade" id="createShiftModal" tabindex="-1" aria-labelledby="createShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createShiftModalLabel">
                    <i class="ri-calendar-todo-line me-2"></i>Agendar Nueva Sesión de Trabajo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('shifts.store') }}" method="POST" id="createShiftForm">
                @csrf
                <input type="hidden" name="id_order" value="{{ $order->id_order }}">
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Información del Trabajo -->
                        <div class="col-12 mb-3">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Trabajo:</strong> {{ $order->client_name }} - {{ $order->work_info }}
                            </div>
                        </div>

                        <!-- Fecha de la Sesión -->
                        <div class="col-md-6 mb-3">
                            <label for="shift_date" class="form-label text-default">Fecha de la Sesión <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                                    <input type="text" class="form-control" id="shift_date" name="shift_date" placeholder="Seleccionar fecha" required>
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label text-default">Estado <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Seleccionar estado</option>
                                <option value="pending" selected>Pendiente</option>
                                <option value="completed">Completado</option>
                                <option value="canceled">Cancelado</option>
                                <option value="rescheduled">Reagendado</option>
                            </select>
                        </div>

                        <!-- Hora de Inicio -->
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label text-default">Hora de Inicio <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"><i class="ri-time-line"></i></div>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>
                            </div>
                        </div>

                        <!-- Hora de Fin -->
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label text-default">Hora de Fin <span class="text-muted">(Opcional)</span></label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"><i class="ri-time-line"></i></div>
                                    <input type="time" class="form-control" id="end_time" name="end_time">
                                </div>
                            </div>
                        </div>

                        <!-- Responsable -->
                        <div class="col-12 mb-3">
                            <label for="responsible" class="form-label text-default">Responsable <span class="text-muted">(Opcional)</span></label>
                            <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Nombre del responsable de la sesión" maxlength="150">
                        </div>

                        <!-- Descripción -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label text-default">Descripción <span class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Descripción de las actividades a realizar en esta sesión"></textarea>
                        </div>

                        <!-- Información adicional -->
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> Una vez creada la sesión, podrás editarla haciendo clic sobre ella en la pestaña "Sesiones de Trabajo".
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
                            <button type="submit" class="btn btn-primary" id="createShiftBtn">
                                <i class="ri-calendar-todo-line me-1"></i>Agendar Sesión
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
    // Inicializar flatpickr para la fecha
    if (document.getElementById('shift_date')) {
        flatpickr("#shift_date", {
            locale: "es",
            dateFormat: "Y-m-d",
            minDate: "today", // No permitir fechas pasadas
        });
    }

    // Validar que la hora de fin sea posterior a la de inicio
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    if (startTimeInput && endTimeInput) {
        function validateTimes() {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;
            
            if (startTime && endTime && endTime <= startTime) {
                endTimeInput.setCustomValidity('La hora de fin debe ser posterior a la hora de inicio');
            } else {
                endTimeInput.setCustomValidity('');
            }
        }
        
        startTimeInput.addEventListener('change', validateTimes);
        endTimeInput.addEventListener('change', validateTimes);
    }

    // Manejar envío del formulario
    const createShiftForm = document.getElementById('createShiftForm');
    if (createShiftForm) {
        createShiftForm.addEventListener('submit', function() {
            const submitBtn = document.getElementById('createShiftBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Agendando...';
            }
        });
    }

    // Reset form when modal is closed
    const createShiftModal = document.getElementById('createShiftModal');
    if (createShiftModal) {
        createShiftModal.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('createShiftForm');
            const submitBtn = document.getElementById('createShiftBtn');
            
            if (form) {
                form.reset();
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-calendar-todo-line me-1"></i>Agendar Sesión';
            }
        });
    }
});
</script>
