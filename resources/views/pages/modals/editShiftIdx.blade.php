@foreach($proximosTurnos as $shift)
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
                <strong>Nota:</strong> Los cambios se guardarán automáticamente. Para editar horarios, utiliza el modal completo desde la página de detalles.
              </div>
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <div class="spinner-border text-primary d-none" role="status" id="spinnerEditShift{{ $shift->id_shift }}">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i>Cancelar
        </button>
        <button type="submit" form="form-edit-shift-{{ $shift->id_shift }}" class="btn btn-success" id="guardarBtnEditShift{{ $shift->id_shift }}">
          <i class="ri-save-line me-1"></i>Guardar Cambios
        </button>
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
});
</script>