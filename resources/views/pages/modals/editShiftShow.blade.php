@foreach($turnosMesActual as $shift)
<!-- Modal Editar Turno -->
<div class="modal fade" id="editShift{{ $shift->id_shift }}" tabindex="-1" aria-labelledby="editShiftModal{{ $shift->id_shift }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="editShiftModal{{ $shift->id_shift }}">
          <i class="ri-calendar-event-line me-2"></i>
          Editar Turno - {{ optional($shift->order)->client_name ?? 'Cliente' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('shifts.updateStatus', $shift->id_shift) }}" method="POST" class="form-edit-shift" data-form-id="{{ $shift->id_shift }}">
          @csrf
          @method('PUT')

          @php
            // Preferimos accessors start_at/end_at (Carbon) si existen:
            $startAt = method_exists($shift, 'getStartAtAttribute') ? $shift->start_at : null;
            $endAt   = method_exists($shift, 'getEndAtAttribute')   ? $shift->end_at   : null;

            // Fallback defensivo (por si aún no tienes los accessors):
            if (!$startAt) {
              $dateStr = $shift->shift_date instanceof \Carbon\Carbon ? $shift->shift_date->format('Y-m-d') : (string)$shift->shift_date;
              $timeStr = (string)($shift->start_time ?? '00:00:00');
              if (preg_match('/\b(\d{2}:\d{2}(?::\d{2})?)\b/', $timeStr, $m)) {
                $timeStr = strlen($m[1]) === 5 ? $m[1].':00' : $m[1];
              } else {
                $timeStr = '00:00:00';
              }
              try {
                $startAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateStr.' '.$timeStr, config('app.timezone','America/Santiago'));
              } catch (\Exception $e) { $startAt = null; }
            }
            if (!$endAt && $shift->end_time) {
              $dateStr = $shift->shift_date instanceof \Carbon\Carbon ? $shift->shift_date->format('Y-m-d') : (string)$shift->shift_date;
              $timeStr = (string)($shift->end_time ?? '00:00:00');
              if (preg_match('/\b(\d{2}:\d{2}(?::\d{2})?)\b/', $timeStr, $m)) {
                $timeStr = strlen($m[1]) === 5 ? $m[1].':00' : $m[1];
              } else {
                $timeStr = '00:00:00';
              }
              try {
                $endAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateStr.' '.$timeStr, config('app.timezone','America/Santiago'));
              } catch (\Exception $e) { $endAt = null; }
            }
          @endphp

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
                    <div class="col-md-8">
                      <p class="fw-semibold mb-2 d-flex align-items-center">
                        <i class="ri-bookmark-fill fs-16 me-2 text-primary"></i>
                        @if($startAt)
                          {{ ucfirst($startAt->translatedFormat('l')) }}
                          {{ $startAt->format('j') }}
                          de {{ ucfirst($startAt->translatedFormat('F')) }}
                          a las {{ $startAt->format('H:i') }}
                          @if($endAt) a {{ $endAt->format('H:i') }} @endif
                        @else
                          {{ \Carbon\Carbon::parse($shift->shift_date)->translatedFormat('d M Y') }}
                          {{ $shift->start_time }} @if($shift->end_time) - {{ $shift->end_time }} @endif
                        @endif
                      </p>
                    </div>
                    <div class="col-md-4 text-end">
                      <span class="badge bg-secondary fs-12">ID: {{ $shift->id_shift }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Campos Editables -->
          <div class="row">
            <div class="col-12">
              <h6 class="fw-semibold mb-3">
                <i class="ri-edit-line me-2"></i>
                Editar Información
              </h6>
            </div>
          </div>

          <div class="row">
            <!-- Estado del Turno -->
            <div class="col-md-6 mb-3">
              <label for="status{{ $shift->id_shift }}" class="form-label fw-semibold">
                <i class="ri-flag-line me-1"></i>Estado del Turno
              </label>
              <select class="form-select" id="status{{ $shift->id_shift }}" name="status" required>
                <option value="pending" {{ $shift->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="completed" {{ $shift->status === 'completed' ? 'selected' : '' }}>Completado</option>
                <option value="canceled" {{ $shift->status === 'canceled' ? 'selected' : '' }}>Cancelado</option>
                <option value="rescheduled" {{ $shift->status === 'rescheduled' ? 'selected' : '' }}>Reprogramado</option>
              </select>
            </div>

            <!-- Responsable -->
            <div class="col-md-6 mb-3">
              <label for="responsible{{ $shift->id_shift }}" class="form-label fw-semibold">
                <i class="ri-user-3-line me-1"></i>Responsable/Operador
              </label>
              <input type="text" class="form-control" id="responsible{{ $shift->id_shift }}" name="responsible" 
                     value="{{ old('responsible', $shift->responsible) }}" placeholder="Nombre del operador asignado">
            </div>
          </div>

          <div class="row">
            <!-- Fecha del Turno -->
            <div class="col-md-4 mb-3">
              <label for="shift_date{{ $shift->id_shift }}" class="form-label fw-semibold">
                <i class="ri-calendar-line me-1"></i>Fecha del Turno
              </label>
              <input type="date" class="form-control" id="shift_date{{ $shift->id_shift }}" name="shift_date" 
                     value="{{ $shift->shift_date ? \Carbon\Carbon::parse($shift->shift_date)->format('Y-m-d') : '' }}" required>
            </div>

            <!-- Hora Inicio -->
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold" for="start_time{{ $shift->id_shift }}">
                <i class="ri-time-line me-1"></i>Hora Inicio
              </label>
              <input type="time" class="form-control" id="start_time{{ $shift->id_shift }}" name="start_time" 
                     value="{{ $shift->start_time ? \Illuminate\Support\Str::of((string)$shift->start_time)->limit(5,'') : '' }}" required>
            </div>

            <!-- Hora Término -->
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold" for="end_time{{ $shift->id_shift }}">
                <i class="ri-time-line me-1"></i>Hora Término
              </label>
              <input type="time" class="form-control" id="end_time{{ $shift->id_shift }}" name="end_time" 
                     value="{{ $shift->end_time ? \Illuminate\Support\Str::of((string)$shift->end_time)->limit(5,'') : '' }}">
            </div>
          </div>

          <!-- Descripción -->
          <div class="row mb-3">
            <div class="col-12">
              <label for="description{{ $shift->id_shift }}" class="form-label fw-semibold">
                <i class="ri-file-text-line me-1"></i>Descripción del Trabajo
              </label>
              <textarea class="form-control" id="description{{ $shift->id_shift }}" name="description" rows="4" 
                        placeholder="Describe las actividades realizadas o por realizar en este turno...">{{ old('description', $shift->description) }}</textarea>
            </div>
          </div>

          <!-- Información Adicional -->
          <div class="row">
            <div class="col-12">
              <div class="alert alert-info">
                <i class="ri-information-line me-2"></i>
                <strong>Nota:</strong> Los cambios se guardarán automáticamente y se actualizará el estado del turno.
              </div>
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <div class="spinner-border text-primary d-none" role="status" id="spinnerEditShift{{ $shift->id_shift }}">
          <span class="visually-hidden">Cargando...</span>
        </div>
        
        <div class="d-flex justify-content-between w-100">
          <!-- Botón de eliminar a la izquierda -->
          <div>
            <button type="button" class="btn btn-outline-danger" onclick="confirmDeleteShift({{ $shift->id_shift }}, '{{ $shift->shift_date ? $shift->shift_date->format('d/m/Y') : 'Sin fecha' }}', '{{ optional($shift->order)->client_name ?? 'Cliente' }}')">
              <i class="ri-delete-bin-line me-1"></i>Eliminar Turno
            </button>
          </div>
          
          <!-- Botones de acción a la derecha -->
          <div>
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i>Cancelar
            </button>
            <button type="submit" class="btn btn-success" id="guardarBtnEditShift{{ $shift->id_shift }}" onclick="document.querySelector('.form-edit-shift[data-form-id=&quot;{{ $shift->id_shift }}&quot;]').submit()">
              <i class="ri-save-line me-1"></i>Guardar Cambios
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endforeach

{{-- Script para todos los formularios del loop --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Manejar envío de formularios
  document.querySelectorAll('.form-edit-shift').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const id = this.getAttribute('data-form-id');
      const btn = document.getElementById('guardarBtnEditShift' + id);
      const spin = document.getElementById('spinnerEditShift' + id);
      
      if (btn && spin) {
        btn.classList.add('d-none');
        spin.classList.remove('d-none');
      }
      
      // Enviar formulario
      this.submit();
    });
  });

  // Validación de horas en tiempo real
  document.querySelectorAll('input[name="start_time"]').forEach(function(startTimeInput) {
    startTimeInput.addEventListener('change', function() {
      const formId = this.id.replace('start_time', '');
      const endTimeInput = document.getElementById('end_time' + formId);
      
      if (endTimeInput && endTimeInput.value && this.value) {
        if (this.value >= endTimeInput.value) {
          endTimeInput.setCustomValidity('La hora de término debe ser posterior a la hora de inicio');
        } else {
          endTimeInput.setCustomValidity('');
        }
      }
    });
  });

  document.querySelectorAll('input[name="end_time"]').forEach(function(endTimeInput) {
    endTimeInput.addEventListener('change', function() {
      const formId = this.id.replace('end_time', '');
      const startTimeInput = document.getElementById('start_time' + formId);
      
      if (startTimeInput && startTimeInput.value && this.value) {
        if (startTimeInput.value >= this.value) {
          this.setCustomValidity('La hora de término debe ser posterior a la hora de inicio');
        } else {
          this.setCustomValidity('');
        }
      }
    });
  });

  // Establecer fecha mínima como hoy
  document.querySelectorAll('input[name="shift_date"]').forEach(function(dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
  });
});

// Función para confirmar eliminación de turno
function confirmDeleteShift(shiftId, shiftDate, clientName) {
  const message = `¿Estás seguro de que deseas eliminar el turno del ${shiftDate} para ${clientName}?\n\nEsta acción no se puede deshacer.`;
  
  if (confirm(message)) {
    // Crear formulario para DELETE con mejor manejo del CSRF
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('/shifts') }}/${shiftId}`;
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
    
    // Agregar al DOM, enviar y limpiar
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
  }
}
</script>