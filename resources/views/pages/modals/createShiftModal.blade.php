<!-- Modal Crear Nuevo Turno -->
<div class="modal fade" id="createShiftModal" tabindex="-1" aria-labelledby="createShiftModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="createShiftModalLabel">
          <i class="ri-calendar-event-line me-2"></i>
          Crear Nuevo Turno
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('shifts.store') }}" method="POST" id="createShiftForm">
          @csrf

          <!-- Selección de Orden -->
          <div class="row mb-4">
            <div class="col-12">
              <label for="id_order" class="form-label fw-semibold">
                <i class="ri-file-list-line me-1"></i>Seleccionar Orden
              </label>
              <select class="form-select" id="id_order" name="id_order" required>
                <option value="">-- Selecciona una orden --</option>
                @if(isset($orders) && $orders->count() > 0)
                  @foreach($orders as $order)
                    <option value="{{ $order->id_order }}" 
                            data-client="{{ $order->client_name }}"
                            data-address="{{ $order->client_address }}"
                            data-work="{{ $order->work_info }}">
                      {{ $order->client_name }} - {{ $order->work_info ? Str::limit($order->work_info, 50) : 'Sin descripción' }}
                    </option>
                  @endforeach
                @else
                  <option value="" disabled>No hay órdenes disponibles</option>
                @endif
              </select>
              <div class="form-text text-muted">
                <i class="ri-information-line me-1"></i>
                Selecciona la orden para la cual crearás el turno
              </div>
            </div>
          </div>

          <!-- Información de la Orden Seleccionada -->
          <div class="row mb-4" id="orderInfo" style="display: none;">
            <div class="col-12">
              <div class="card bg-light">
                <div class="card-body">
                  <h6 class="card-title mb-3">
                    <i class="ri-information-line me-2"></i>
                    Información de la Orden
                  </h6>
                  <div id="orderDetails">
                    <!-- Se llenará dinámicamente -->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Fecha del Turno -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="shift_date" class="form-label fw-semibold">
                <i class="ri-calendar-line me-1"></i>Fecha del Turno
              </label>
              <input type="date" class="form-control" id="shift_date" name="shift_date" 
                     value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                     min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
              <div class="form-text text-muted">
                <i class="ri-information-line me-1"></i>
                Fecha en la que se realizará el turno
              </div>
            </div>

            <!-- Estado del Turno -->
            <div class="col-md-6">
              <label for="status" class="form-label fw-semibold">
                <i class="ri-flag-line me-1"></i>Estado del Turno
              </label>
              <select class="form-select" id="status" name="status" required>
                <option value="pending" selected>Pendiente</option>
                <option value="completed">Completado</option>
                <option value="canceled">Cancelado</option>
                <option value="rescheduled">Reprogramado</option>
              </select>
            </div>
          </div>

          <!-- Horarios del Turno -->
          <div class="row mb-3">
            <!-- Hora de Inicio -->
            <div class="col-md-6">
              <label for="start_time" class="form-label fw-semibold">
                <i class="ri-time-line me-1"></i>Hora de Inicio
              </label>
              <input type="time" class="form-control" id="start_time" name="start_time" 
                     value="08:00" required>
            </div>

            <!-- Hora de Fin -->
            <div class="col-md-6">
              <label for="end_time" class="form-label fw-semibold">
                <i class="ri-time-line me-1"></i>Hora de Fin
              </label>
              <input type="time" class="form-control" id="end_time" name="end_time" 
                     value="17:00" required>
              <div class="form-text text-muted">
                <i class="ri-information-line me-1"></i>
                Mínimo 8 horas de duración por turno
              </div>
              <!-- Alerta de validación -->
              <div class="alert alert-danger mt-2 d-none" id="hoursAlert">
                <i class="ri-error-warning-line me-2"></i>
                <strong>Error:</strong> El turno debe tener una duración mínima de 8 horas.
              </div>
            </div>
          </div>

          <!-- Responsable -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="responsible" class="form-label fw-semibold">
                <i class="ri-user-3-line me-1"></i>Responsable/Operador
              </label>
              <input type="text" class="form-control" id="responsible" name="responsible" 
                     placeholder="Nombre del operador asignado">
            </div>
          </div>

          <!-- Descripción -->
          <div class="row mb-3">
            <div class="col-12">
              <label for="description" class="form-label fw-semibold">
                <i class="ri-file-text-line me-1"></i>Descripción del Trabajo
              </label>
              <textarea class="form-control" id="description" name="description" rows="4" 
                        placeholder="Describe las actividades que se realizarán en este turno..."></textarea>
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <div class="spinner-border text-primary d-none" role="status" id="spinnerCreateShift">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i>Cancelar
        </button>
        <button type="button" class="btn btn-success" id="guardarBtnCreateShift" onclick="submitCreateShiftForm()">
          <i class="ri-save-line me-1"></i>Crear Turno
        </button>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Manejar envío de formulario (solo para prevenir envío accidental)
  document.getElementById('createShiftForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // La validación se maneja en submitCreateShiftForm()
  });

  // Mostrar información de la orden seleccionada
  document.getElementById('id_order').addEventListener('change', function() {
    const orderInfo = document.getElementById('orderInfo');
    const orderDetails = document.getElementById('orderDetails');
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
      const clientName = selectedOption.getAttribute('data-client');
      const address = selectedOption.getAttribute('data-address');
      const workInfo = selectedOption.getAttribute('data-work');
      
      orderDetails.innerHTML = `
        <div class="row">
          <div class="col-md-6">
            <p class="fw-semibold mb-2 d-flex align-items-center">
              <i class="ri-user-line fs-16 me-2 text-primary"></i>
              <strong>Cliente:</strong> ${clientName}
            </p>
            <p class="mb-2 d-flex align-items-center">
              <i class="ri-map-pin-line fs-16 me-2 text-info"></i>
              <strong>Dirección:</strong> ${address}
            </p>
          </div>
          <div class="col-md-6">
            <p class="mb-2 d-flex align-items-center">
              <i class="ri-tools-line fs-16 me-2 text-warning"></i>
              <strong>Trabajo:</strong> ${workInfo ? workInfo.substring(0, 100) + (workInfo.length > 100 ? '...' : '') : 'Sin descripción'}
            </p>
          </div>
        </div>
      `;
      orderInfo.style.display = 'block';
    } else {
      orderInfo.style.display = 'none';
    }
  });

  // Auto-calcular hora de fin y validar mínimo 8 horas
  const startTimeInput = document.getElementById('start_time');
  const endTimeInput = document.getElementById('end_time');
  
  // Función para calcular automáticamente la hora de fin (+8 horas)
  function autoCalculateEndTime() {
    const startTime = startTimeInput.value;
    
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
      endTimeInput.value = endTimeFormatted;
      
      // Limpiar cualquier mensaje de validación
      endTimeInput.setCustomValidity('');
    }
  }
  
  // Auto-calcular cuando cambie la hora de inicio
  startTimeInput.addEventListener('change', function() {
    autoCalculateEndTime();
    validateMinimumHours();
  });
  
  // Validar cuando cambie la hora de fin manualmente
  endTimeInput.addEventListener('change', validateMinimumHours);
});

// Función global para validar horas mínimas
function validateMinimumHours() {
  const startTimeInput = document.getElementById('start_time');
  const endTimeInput = document.getElementById('end_time');
  const alertDiv = document.getElementById('hoursAlert');
  
  const startTime = startTimeInput.value;
  const endTime = endTimeInput.value;
  
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
      // Mostrar alerta visual
      if (alertDiv) {
        alertDiv.classList.remove('d-none');
      }
      
      // Resaltar campos con error
      startTimeInput.classList.add('is-invalid');
      endTimeInput.classList.add('is-invalid');
      
      endTimeInput.setCustomValidity('El turno debe tener una duración mínima de 8 horas');
      return false;
    } else {
      // Ocultar alerta visual
      if (alertDiv) {
        alertDiv.classList.add('d-none');
      }
      
      // Quitar resaltado de error
      startTimeInput.classList.remove('is-invalid');
      endTimeInput.classList.remove('is-invalid');
      
      endTimeInput.setCustomValidity('');
      return true;
    }
  }
  return false;
}

// Función para enviar formulario con validación
function submitCreateShiftForm() {
  const form = document.getElementById('createShiftForm');
  const startTimeInput = document.getElementById('start_time');
  const endTimeInput = document.getElementById('end_time');
  const alertDiv = document.getElementById('hoursAlert');
  
  if (!form || !startTimeInput || !endTimeInput) {
    console.error('Elementos del formulario no encontrados');
    return;
  }
  
  // Validar que se haya seleccionado una orden
  const orderSelect = document.getElementById('id_order');
  if (!orderSelect.value) {
    alert('Error: Debes seleccionar una orden.');
    orderSelect.focus();
    return false;
  }
  
  // Validar horas antes de enviar
  if (!validateMinimumHours()) {
    // Mostrar alerta del navegador
    alert('Error: El turno debe tener una duración mínima de 8 horas.');
    return false; // No enviar formulario
  }
  
  // Si la validación es correcta, proceder con el envío
  const btn = document.getElementById('guardarBtnCreateShift');
  const spin = document.getElementById('spinnerCreateShift');
  
  if (btn && spin) {
    btn.classList.add('d-none');
    spin.classList.remove('d-none');
  }
  
  // Enviar formulario
  form.submit();
}
</script>
