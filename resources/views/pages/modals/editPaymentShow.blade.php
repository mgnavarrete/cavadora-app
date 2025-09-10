@foreach($pagosOrden as $payment)
<!-- Modal Editar Pago -->
<div class="modal fade" id="editPayment{{ $payment->id_payment }}" tabindex="-1" aria-labelledby="editPaymentModal{{ $payment->id_payment }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="editPaymentModal{{ $payment->id_payment }}">
          <i class="ri-money-dollar-circle-line me-2"></i>
          Editar Pago - {{ optional($payment->order)->client_name ?? 'Cliente' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('payments.updateStatus', $payment->id_payment) }}" method="POST" class="form-edit-payment" data-form-id="{{ $payment->id_payment }}">
          @csrf
          @method('PUT')

          @php
            $totalPago = ($payment->labor_cost + $payment->machine_cost + $payment->fuel_expenses + $payment->extra_cost);
            $emissionDate = $payment->emission_date;
            if ($emissionDate instanceof \Carbon\Carbon) {
                $emissionDateFormatted = $emissionDate->translatedFormat('d M Y');
            } else {
                try {
                    $emissionDateFormatted = \Carbon\Carbon::parse($emissionDate)->translatedFormat('d M Y');
                } catch (\Exception $e) {
                    $emissionDateFormatted = $emissionDate;
                }
            }
          @endphp

          <!-- Información del Pago -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card bg-light">
                <div class="card-body">
                  <h6 class="card-title mb-3">
                    <i class="ri-information-line me-2"></i>
                    Información del Pago
                  </h6>
                  <div class="row">
                    <div class="col-md-6">
                      <p class="mb-2"><strong>Cliente:</strong> {{ optional($payment->order)->client_name ?? 'N/A' }}</p>
                      <p class="mb-2"><strong>Fecha Emisión:</strong> {{ $emissionDateFormatted }}</p>
                    </div>
                    <div class="col-md-6">
                      <p class="mb-2"><strong>Total del Pago:</strong> 
                        <span class="fs-18 fw-bold text-success">${{ number_format($totalPago, 0, ',', '.') }}</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Desglose de Costos -->
          <div class="row mb-4">
            <div class="col-12">
              <h6 class="fw-semibold mb-3">
                <i class="ri-calculator-line me-2"></i>
                Desglose de Costos
              </h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-muted">Costo Laboral:</label>
                  <p class="mb-0 fs-16">${{ number_format($payment->labor_cost, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-muted">Costo Maquinaria:</label>
                  <p class="mb-0 fs-16">${{ number_format($payment->machine_cost, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-muted">Combustible:</label>
                  <p class="mb-0 fs-16">${{ number_format($payment->fuel_expenses, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold text-muted">Costos Extra:</label>
                  <p class="mb-0 fs-16">${{ number_format($payment->extra_cost, 0, ',', '.') }}</p>
                </div>
              </div>
            </div>
          </div>

          <hr class="my-4">

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
            <!-- Estado del Pago -->
            <div class="col-md-6 mb-3">
              <label for="status{{ $payment->id_payment }}" class="form-label fw-semibold">
                <i class="ri-flag-line me-1"></i>Estado del Pago
              </label>
              <select class="form-select" id="status{{ $payment->id_payment }}" name="status" required>
                <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Pagado</option>
                <option value="overdue" {{ $payment->status === 'overdue' ? 'selected' : '' }}>Atrasado</option>
                <option value="void" {{ $payment->status === 'void' ? 'selected' : '' }}>Anulado</option>
              </select>
            </div>

            <!-- Fecha de Pago -->
            <div class="col-md-6 mb-3" id="paymentDateContainer{{ $payment->id_payment }}" style="display: none;">
              <label for="payment_date{{ $payment->id_payment }}" class="form-label fw-semibold">
                <i class="ri-calendar-check-line me-1"></i>Fecha de Pago
              </label>
              <input type="date" class="form-control" id="payment_date{{ $payment->id_payment }}" name="payment_date" 
                     value="{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '' }}">
            </div>
          </div>

          <!-- Notas / Observaciones -->
          <div class="row mb-3">
            <div class="col-12">
              <label for="notes{{ $payment->id_payment }}" class="form-label fw-semibold">
                <i class="ri-file-text-line me-1"></i>Notas / Observaciones
              </label>
              <textarea class="form-control" id="notes{{ $payment->id_payment }}" name="notes" rows="4" 
                        placeholder="Agregar notas sobre el pago...">{{ old('description', $payment->description ?? '') }}</textarea>
            </div>
          </div>

          <!-- Información Adicional -->
          <div class="row">
            <div class="col-12">
              <div class="alert alert-info">
                <i class="ri-information-line me-2"></i>
                <strong>Nota:</strong> Los cambios se guardarán automáticamente y se actualizará el estado del pago.
              </div>
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <div class="spinner-border text-primary d-none" role="status" id="spinnerEditPayment{{ $payment->id_payment }}">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-success" id="guardarBtnEditPayment{{ $payment->id_payment }}" onclick="document.querySelector('.form-edit-payment[data-form-id=&quot;{{ $payment->id_payment }}&quot;]').submit()">
          <i class="ri-save-line me-1"></i>Guardar Cambios
        </button>
      </div>

    </div>
  </div>
</div>
@endforeach

{{-- Script para manejar los formularios de pago --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Manejar cambio de estado para mostrar/ocultar fecha de pago
  document.querySelectorAll('select[name="status"]').forEach(function(select) {
    const paymentId = select.id.replace('status', '');
    const paymentDateContainer = document.getElementById('paymentDateContainer' + paymentId);
    
    // Función para mostrar/ocultar fecha de pago
    function togglePaymentDate() {
      if (select.value === 'paid') {
        paymentDateContainer.style.display = 'block';
        document.getElementById('payment_date' + paymentId).required = true;
      } else {
        paymentDateContainer.style.display = 'none';
        document.getElementById('payment_date' + paymentId).required = false;
      }
    }
    
    // Ejecutar al cargar y al cambiar
    togglePaymentDate();
    select.addEventListener('change', togglePaymentDate);
  });

  // Manejar envío de formularios
  document.querySelectorAll('.form-edit-payment').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const id = this.getAttribute('data-form-id');
      const btn = document.getElementById('guardarBtnEditPayment' + id);
      const spin = document.getElementById('spinnerEditPayment' + id);
      
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