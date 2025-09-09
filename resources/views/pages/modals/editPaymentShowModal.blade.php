<!-- Modal para Editar Payment en Show -->
<div class="modal fade" id="editPayment{{ $payment->id_payment }}" tabindex="-1" aria-labelledby="editPaymentShowModal{{ $payment->id_payment }}" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="editPaymentShowModal{{ $payment->id_payment }}">
          <i class="ri-edit-line me-2"></i>
          Editar Pago - {{ $payment->order ? $payment->order->client_name : 'Cliente' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('payments.updatePaymentAndOrder', $payment->id_payment) }}" method="POST" class="form-edit-payment-show" data-form-id="{{ $payment->id_payment }}">
          @csrf
          @method('PUT')

          <!-- Pestañas de navegación -->
          <ul class="nav nav-tabs mb-4" id="editPaymentTabs{{ $payment->id_payment }}" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="order-tab{{ $payment->id_payment }}" data-bs-toggle="tab" data-bs-target="#order{{ $payment->id_payment }}" type="button" role="tab">
                <i class="ri-file-text-line me-2"></i>Información de la Orden
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="payment-tab{{ $payment->id_payment }}" data-bs-toggle="tab" data-bs-target="#payment{{ $payment->id_payment }}" type="button" role="tab">
                <i class="ri-money-dollar-circle-line me-2"></i>Información del Pago
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="costs-tab{{ $payment->id_payment }}" data-bs-toggle="tab" data-bs-target="#costs{{ $payment->id_payment }}" type="button" role="tab">
                <i class="ri-calculator-line me-2"></i>Costos
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="shifts-tab{{ $payment->id_payment }}" data-bs-toggle="tab" data-bs-target="#shifts{{ $payment->id_payment }}" type="button" role="tab">
                <i class="ri-time-line me-2"></i>Turnos
              </button>
            </li>
          </ul>

          <div class="tab-content" id="editPaymentTabsContent{{ $payment->id_payment }}">
            
            <!-- Pestaña: Información de la Orden -->
            <div class="tab-pane fade show active" id="order{{ $payment->id_payment }}" role="tabpanel">
              <h6 class="mb-3">
                <i class="ri-file-text-line me-2"></i>Datos de la Orden de Trabajo
              </h6>
              
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="start_date{{ $payment->id_payment }}" class="form-label fw-semibold">Fecha de Inicio:</label>
                  <input type="date" class="form-control" id="start_date{{ $payment->id_payment }}" name="start_date" 
                         value="{{ $payment->order && $payment->order->start_date ? $payment->order->start_date->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-6">
                  <label for="end_date{{ $payment->id_payment }}" class="form-label fw-semibold">Fecha de Fin:</label>
                  <input type="date" class="form-control" id="end_date{{ $payment->id_payment }}" name="end_date" 
                         value="{{ $payment->order && $payment->order->end_date ? $payment->order->end_date->format('Y-m-d') : '' }}">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="work_info{{ $payment->id_payment }}" class="form-label fw-semibold">Descripción del Trabajo:</label>
                  <textarea class="form-control" id="work_info{{ $payment->id_payment }}" name="work_info" rows="4" 
                            placeholder="Descripción detallada del trabajo a realizar...">{{ $payment->order ? $payment->order->work_info : '' }}</textarea>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="card bg-light">
                    <div class="card-body">
                      <h6 class="card-title mb-2">Información del Cliente (Solo lectura)</h6>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1"><strong>Cliente:</strong> {{ $payment->order ? $payment->order->client_name : 'N/A' }}</p>
                          <p class="mb-1"><strong>RUT:</strong> {{ $payment->order ? $payment->order->cliente_rut : 'N/A' }}</p>
                          <p class="mb-1"><strong>Teléfono:</strong> {{ $payment->order ? $payment->order->client_phone : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1"><strong>Email:</strong> {{ $payment->order ? $payment->order->cliente_email : 'N/A' }}</p>
                          <p class="mb-1"><strong>Dirección:</strong> {{ $payment->order ? $payment->order->client_address : 'N/A' }}</p>
                          <p class="mb-1"><strong>Orden:</strong> #{{ $payment->order ? $payment->order->id_order : 'N/A' }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pestaña: Información del Pago -->
            <div class="tab-pane fade" id="payment{{ $payment->id_payment }}" role="tabpanel">
              <h6 class="mb-3">
                <i class="ri-money-dollar-circle-line me-2"></i>Datos del Pago
              </h6>
              
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="emission_date{{ $payment->id_payment }}" class="form-label fw-semibold">Fecha de Emisión:</label>
                  <input type="date" class="form-control" id="emission_date{{ $payment->id_payment }}" name="emission_date" 
                         value="{{ $payment->emission_date ? $payment->emission_date->format('Y-m-d') : '' }}" required>
                </div>
                <div class="col-md-6">
                  <label for="payment_date{{ $payment->id_payment }}" class="form-label fw-semibold">Fecha de Pago:</label>
                  <input type="date" class="form-control" id="payment_date{{ $payment->id_payment }}" name="payment_date" 
                         value="{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '' }}">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="status{{ $payment->id_payment }}" class="form-label fw-semibold">Estado del Pago:</label>
                  <select class="form-select" id="status{{ $payment->id_payment }}" name="status" required>
                    <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Pagado</option>
                    <option value="overdue" {{ $payment->status == 'overdue' ? 'selected' : '' }}>Atrasado</option>
                    <option value="void" {{ $payment->status == 'void' ? 'selected' : '' }}>Anulado</option>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="description{{ $payment->id_payment }}" class="form-label fw-semibold">Descripción/Notas del Pago:</label>
                  <textarea class="form-control" id="description{{ $payment->id_payment }}" name="description" rows="3" 
                            placeholder="Agregar notas sobre el pago...">{{ $payment->description }}</textarea>
                </div>
              </div>
            </div>

            <!-- Pestaña: Costos -->
            <div class="tab-pane fade" id="costs{{ $payment->id_payment }}" role="tabpanel">
              <h6 class="mb-3">
                <i class="ri-calculator-line me-2"></i>Desglose de Costos
              </h6>
              
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="labor_cost{{ $payment->id_payment }}" class="form-label fw-semibold">
                    <i class="ri-user-line me-1 text-primary"></i>Costo de Mano de Obra:
                  </label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control cost-input" id="labor_cost{{ $payment->id_payment }}" name="labor_cost" 
                           value="{{ $payment->labor_cost ?? 0 }}" min="0" step="1000" data-payment-id="{{ $payment->id_payment }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="machine_cost{{ $payment->id_payment }}" class="form-label fw-semibold">
                    <i class="ri-settings-line me-1 text-warning"></i>Costo de Maquinaria:
                  </label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control cost-input" id="machine_cost{{ $payment->id_payment }}" name="machine_cost" 
                           value="{{ $payment->machine_cost ?? 0 }}" min="0" step="1000" data-payment-id="{{ $payment->id_payment }}">
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="fuel_expenses{{ $payment->id_payment }}" class="form-label fw-semibold">
                    <i class="ri-gas-station-line me-1 text-info"></i>Gastos de Combustible:
                  </label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control cost-input" id="fuel_expenses{{ $payment->id_payment }}" name="fuel_expenses" 
                           value="{{ $payment->fuel_expenses ?? 0 }}" min="0" step="1000" data-payment-id="{{ $payment->id_payment }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="extra_cost{{ $payment->id_payment }}" class="form-label fw-semibold">
                    <i class="ri-add-circle-line me-1 text-secondary"></i>Gastos Extras:
                  </label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control cost-input" id="extra_cost{{ $payment->id_payment }}" name="extra_cost" 
                           value="{{ $payment->extra_cost ?? 0 }}" min="0" step="1000" data-payment-id="{{ $payment->id_payment }}">
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="info_extra_cost{{ $payment->id_payment }}" class="form-label fw-semibold">Descripción de Gastos Extras:</label>
                  <textarea class="form-control" id="info_extra_cost{{ $payment->id_payment }}" name="info_extra_cost" rows="2" 
                            placeholder="Detalle de los gastos extras...">{{ $payment->info_extra_cost }}</textarea>
                </div>
              </div>

              <!-- Resumen de Total -->
              <div class="row">
                <div class="col-md-12">
                  <div class="card bg-light">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Total del Pago:</h6>
                        <h5 class="mb-0 text-success" id="totalCost{{ $payment->id_payment }}">${{ number_format($totalPago, 0, ',', '.') }}</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pestaña: Turnos -->
            <div class="tab-pane fade" id="shifts{{ $payment->id_payment }}" role="tabpanel">
              <h6 class="mb-3">
                <i class="ri-time-line me-2"></i>Registro de Turnos de Trabajo
              </h6>
              
              @if($shifts && $shifts->count() > 0)
                <div class="row">
                  @foreach($shifts as $index => $shift)
                    <div class="col-md-6 mb-4">
                      <div class="card border">
                        <div class="card-header bg-light py-2">
                          <h6 class="mb-0">
                            <i class="ri-calendar-line me-1"></i>
                            Turno {{ $index + 1 }} - {{ $shift->shift_date ? $shift->shift_date->format('d/m/Y') : 'Sin fecha' }}
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="row mb-2">
                            <div class="col-md-6">
                              <label class="form-label fw-semibold">Fecha:</label>
                              <input type="date" class="form-control form-control-sm shift-input" 
                                     name="shifts[{{ $shift->id_shift }}][shift_date]" 
                                     value="{{ $shift->shift_date ? $shift->shift_date->format('Y-m-d') : '' }}"
                                     data-shift-id="{{ $shift->id_shift }}">
                            </div>
                            <div class="col-md-6">
                              <label class="form-label fw-semibold">Estado:</label>
                              <select class="form-select form-select-sm shift-input" 
                                      name="shifts[{{ $shift->id_shift }}][status]"
                                      data-shift-id="{{ $shift->id_shift }}">
                                <option value="pending" {{ $shift->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="in_progress" {{ $shift->status == 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completed" {{ $shift->status == 'completed' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelled" {{ $shift->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                              </select>
                            </div>
                          </div>
                          
                          <div class="row mb-2">
                            <div class="col-md-6">
                              <label class="form-label fw-semibold">Hora Inicio:</label>
                              <input type="time" class="form-control form-control-sm shift-input" 
                                     name="shifts[{{ $shift->id_shift }}][start_time]" 
                                     value="{{ $shift->start_time ? \Carbon\Carbon::parse($shift->start_time)->format('H:i') : '' }}"
                                     data-shift-id="{{ $shift->id_shift }}">
                            </div>
                            <div class="col-md-6">
                              <label class="form-label fw-semibold">Hora Fin:</label>
                              <input type="time" class="form-control form-control-sm shift-input" 
                                     name="shifts[{{ $shift->id_shift }}][end_time]" 
                                     value="{{ $shift->end_time ? \Carbon\Carbon::parse($shift->end_time)->format('H:i') : '' }}"
                                     data-shift-id="{{ $shift->id_shift }}">
                            </div>
                          </div>
                          
                          <div class="row mb-2">
                            <div class="col-md-12">
                              <label class="form-label fw-semibold">Responsable:</label>
                              <input type="text" class="form-control form-control-sm shift-input" 
                                     name="shifts[{{ $shift->id_shift }}][responsible]" 
                                     value="{{ $shift->responsible ?? '' }}"
                                     placeholder="Nombre del responsable"
                                     data-shift-id="{{ $shift->id_shift }}">
                            </div>
                          </div>
                          
                          <div class="row mb-2">
                            <div class="col-md-12">
                              <label class="form-label fw-semibold">Descripción:</label>
                              <textarea class="form-control form-control-sm shift-input" 
                                        name="shifts[{{ $shift->id_shift }}][description]" 
                                        rows="2" 
                                        placeholder="Descripción del trabajo realizado..."
                                        data-shift-id="{{ $shift->id_shift }}">{{ $shift->description ?? '' }}</textarea>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col-md-12">
                              <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                  <i class="ri-time-line me-1"></i>
                                  <span id="duration{{ $shift->id_shift }}">
                                    @if($shift->start_time && $shift->end_time)
                                      @php
                                        $start = \Carbon\Carbon::parse($shift->start_time);
                                        $end = \Carbon\Carbon::parse($shift->end_time);
                                        $duration = $start->diffInHours($end, true);
                                      @endphp
                                      {{ number_format($duration, 1) }} horas
                                    @else
                                      0 horas
                                    @endif
                                  </span>
                                </small>
                                <span class="badge 
                                  @if($shift->status === 'completed') bg-success
                                  @elseif($shift->status === 'in_progress') bg-info
                                  @elseif($shift->status === 'pending') bg-warning
                                  @elseif($shift->status === 'cancelled') bg-danger
                                  @else bg-secondary
                                  @endif" id="statusBadge{{ $shift->id_shift }}">
                                  @if($shift->status === 'completed') Completado
                                  @elseif($shift->status === 'in_progress') En Proceso
                                  @elseif($shift->status === 'pending') Pendiente
                                  @elseif($shift->status === 'cancelled') Cancelado
                                  @else {{ ucfirst($shift->status) }}
                                  @endif
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
                
                <div class="alert alert-info mt-3">
                  <i class="ri-information-line me-2"></i>
                  <strong>Nota:</strong> Los cambios en los turnos se guardarán junto con el pago al hacer clic en "Guardar Cambios".
                </div>
              @else
                <div class="text-center py-4">
                  <i class="ri-calendar-line fs-24 text-muted mb-2 d-block"></i>
                  <p class="text-muted mb-0">No hay turnos registrados para esta orden</p>
                </div>
              @endif
            </div>

          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i>Cancelar
        </button>
        <button type="button" id="submitBtn{{ $payment->id_payment }}" class="btn btn-primary">
          <i class="ri-save-line me-1"></i>Guardar Cambios
        </button>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing payment modal {{ $payment->id_payment }}');
    
    const paymentId = '{{ $payment->id_payment }}';
    const form = document.querySelector('.form-edit-payment-show[data-form-id="' + paymentId + '"]');
    const submitBtn = document.getElementById('submitBtn' + paymentId);
    
    if (!form || !submitBtn) {
        console.error('Form or submit button not found');
        return;
    }
    
    console.log('Form found:', form);
    console.log('Submit button found:', submitBtn);
    
    // ===== FUNCIÓN PARA CALCULAR TOTAL =====
    function updateTotal() {
        const laborCost = parseFloat(document.getElementById('labor_cost' + paymentId).value) || 0;
        const machineCost = parseFloat(document.getElementById('machine_cost' + paymentId).value) || 0;
        const fuelExpenses = parseFloat(document.getElementById('fuel_expenses' + paymentId).value) || 0;
        const extraCost = parseFloat(document.getElementById('extra_cost' + paymentId).value) || 0;
        
        const total = laborCost + machineCost + fuelExpenses + extraCost;
        
        // Formatear el total
        const formattedTotal = new Intl.NumberFormat('es-CL', {
            style: 'currency',
            currency: 'CLP',
            minimumFractionDigits: 0
        }).format(total).replace('CLP', '$');
        
        const totalElement = document.getElementById('totalCost' + paymentId);
        if (totalElement) {
            totalElement.textContent = formattedTotal;
            console.log('Total updated to:', formattedTotal);
        }
    }
    
    // ===== EVENT LISTENERS PARA COSTOS =====
    const costInputs = document.querySelectorAll('.cost-input[data-payment-id="' + paymentId + '"]');
    console.log('Cost inputs found:', costInputs.length);
    
    costInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
        input.addEventListener('change', updateTotal);
    });
    
    // ===== FUNCIÓN PARA ENVIAR FORMULARIO =====
    function submitForm() {
        console.log('Submitting form...');
        
        // Validar fechas
        const emissionDate = document.getElementById('emission_date' + paymentId).value;
        const paymentDate = document.getElementById('payment_date' + paymentId).value;
        
        if (paymentDate && emissionDate && paymentDate < emissionDate) {
            alert('La fecha de pago no puede ser anterior a la fecha de emisión');
            return;
        }
        
        const formData = new FormData(form);
        const originalText = submitBtn.innerHTML;
        
        // Debug: mostrar datos que se envían
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(`  ${key}: ${value}`);
        }
        
        // Estado de carga
        submitBtn.innerHTML = '<i class="ri-loader-4-line me-1 spin"></i>Guardando...';
        submitBtn.disabled = true;
        
        console.log('Sending request to:', form.action);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                alert('¡Pago actualizado correctamente!');
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editPayment' + paymentId));
                if (modal) modal.hide();
                
                // Recargar página
                window.location.reload();
            } else {
                // Mostrar errores de validación
                if (data.errors) {
                    let errorMsg = 'Errores de validación:\n';
                    Object.keys(data.errors).forEach(field => {
                        errorMsg += `• ${data.errors[field].join(', ')}\n`;
                    });
                    alert(errorMsg);
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido'));
                }
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
    }
    
    // ===== EVENT LISTENER PARA BOTÓN SUBMIT =====
    submitBtn.addEventListener('click', function(e) {
        console.log('Submit button clicked');
        e.preventDefault();
        submitForm();
    });
    
    // ===== CAMBIO AUTOMÁTICO DE FECHA CUANDO ES PAGADO =====
    const statusSelect = document.getElementById('status' + paymentId);
    const paymentDateInput = document.getElementById('payment_date' + paymentId);
    
    if (statusSelect && paymentDateInput) {
        statusSelect.addEventListener('change', function() {
            if (this.value === 'paid' && !paymentDateInput.value) {
                paymentDateInput.value = new Date().toISOString().split('T')[0];
            } else if (this.value !== 'paid') {
                paymentDateInput.value = '';
            }
        });
    }
    
    // ===== VALIDACIÓN DE FECHAS =====
    const startDateInput = document.getElementById('start_date' + paymentId);
    const endDateInput = document.getElementById('end_date' + paymentId);
    const emissionDateInput = document.getElementById('emission_date' + paymentId);
    
    // Validar fechas de orden
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
    
    // Validar fechas de pago
    if (emissionDateInput && paymentDateInput) {
        emissionDateInput.addEventListener('change', function() {
            if (paymentDateInput.value && this.value > paymentDateInput.value) {
                alert('La fecha de pago no puede ser anterior a la fecha de emisión');
                paymentDateInput.value = '';
            }
        });
        
        paymentDateInput.addEventListener('change', function() {
            if (emissionDateInput.value && this.value < emissionDateInput.value) {
                alert('La fecha de pago no puede ser anterior a la fecha de emisión');
                this.value = '';
            }
        });
    }
    
    // ===== FUNCIONALIDAD PARA TURNOS =====
    
    // Función para calcular duración de un turno
    function calculateShiftDuration(shiftId) {
        const startTimeInput = document.querySelector(`input[name="shifts[${shiftId}][start_time]"]`);
        const endTimeInput = document.querySelector(`input[name="shifts[${shiftId}][end_time]"]`);
        const durationSpan = document.getElementById('duration' + shiftId);
        
        if (startTimeInput && endTimeInput && durationSpan) {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;
            
            if (startTime && endTime) {
                // Crear objetos Date para calcular la diferencia
                const start = new Date(`2000-01-01T${startTime}:00`);
                const end = new Date(`2000-01-01T${endTime}:00`);
                
                // Si la hora de fin es menor que la de inicio, asumimos que es al día siguiente
                if (end < start) {
                    end.setDate(end.getDate() + 1);
                }
                
                const diffInMs = end - start;
                const diffInHours = diffInMs / (1000 * 60 * 60);
                
                durationSpan.textContent = diffInHours.toFixed(1) + ' horas';
            } else {
                durationSpan.textContent = '0 horas';
            }
        }
    }
    
    // Función para actualizar el badge de estado
    function updateStatusBadge(shiftId, newStatus) {
        const badge = document.getElementById('statusBadge' + shiftId);
        if (badge) {
            // Remover clases de color anteriores
            badge.classList.remove('bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary');
            
            // Agregar nueva clase y texto según el estado
            switch(newStatus) {
                case 'completed':
                    badge.classList.add('bg-success');
                    badge.textContent = 'Completado';
                    break;
                case 'in_progress':
                    badge.classList.add('bg-info');
                    badge.textContent = 'En Proceso';
                    break;
                case 'pending':
                    badge.classList.add('bg-warning');
                    badge.textContent = 'Pendiente';
                    break;
                case 'cancelled':
                    badge.classList.add('bg-danger');
                    badge.textContent = 'Cancelado';
                    break;
                default:
                    badge.classList.add('bg-secondary');
                    badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            }
        }
    }
    
    // Event listeners para todos los campos de turnos
    const shiftInputs = document.querySelectorAll('.shift-input');
    console.log('Shift inputs found:', shiftInputs.length);
    
    shiftInputs.forEach(input => {
        const shiftId = input.getAttribute('data-shift-id');
        
        // Para campos de tiempo, calcular duración automáticamente
        if (input.type === 'time') {
            input.addEventListener('change', function() {
                calculateShiftDuration(shiftId);
                console.log('Duration calculated for shift', shiftId);
            });
        }
        
        // Para selects de estado, actualizar badge
        if (input.tagName === 'SELECT' && input.name.includes('[status]')) {
            input.addEventListener('change', function() {
                updateStatusBadge(shiftId, this.value);
                console.log('Status updated for shift', shiftId, 'to', this.value);
            });
        }
        
        // Logging para debugging
        input.addEventListener('change', function() {
            console.log('Shift field changed:', this.name, '=', this.value);
        });
    });
    
    // Validación de horarios (hora fin debe ser mayor que hora inicio)
    function validateShiftTimes(shiftId) {
        const startTimeInput = document.querySelector(`input[name="shifts[${shiftId}][start_time]"]`);
        const endTimeInput = document.querySelector(`input[name="shifts[${shiftId}][end_time]"]`);
        
        if (startTimeInput && endTimeInput && startTimeInput.value && endTimeInput.value) {
            const start = new Date(`2000-01-01T${startTimeInput.value}:00`);
            const end = new Date(`2000-01-01T${endTimeInput.value}:00`);
            
            // Si la hora de fin es menor, no validar (podría ser al día siguiente)
            // Solo mostrar advertencia si es exactamente igual
            if (start.getTime() === end.getTime()) {
                alert('La hora de fin debe ser diferente a la hora de inicio');
                endTimeInput.value = '';
                return false;
            }
        }
        return true;
    }
    
    // Aplicar validación a todos los campos de tiempo
    shiftInputs.forEach(input => {
        if (input.type === 'time') {
            const shiftId = input.getAttribute('data-shift-id');
            input.addEventListener('blur', function() {
                validateShiftTimes(shiftId);
            });
        }
    });
    
    // ===== CALCULAR TOTAL INICIAL =====
    updateTotal();
    
    console.log('Modal initialization complete');
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
