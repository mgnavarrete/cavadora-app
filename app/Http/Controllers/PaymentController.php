<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Shift;

class PaymentController extends Controller
{
    /**
     * Mostrar listado de pagos.
     */
    public function index(Request $request)
    {
        $query = Payment::with('order');

        // Filtro por búsqueda (nombre del cliente)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('order', function ($q) use ($search) {
                $q->where('client_name', 'LIKE', '%' . $search . '%');
            });
        }

        // Filtro por fecha (mes específico)
        if ($request->filled('month_filter') && $request->month_filter !== 'todos') {
            $date = Carbon::parse($request->month_filter);
            $query->whereMonth('emission_date', $date->month)
                ->whereYear('emission_date', $date->year);
        }

        // Obtener todos los pagos
        $pagos = $query->orderBy('emission_date', 'desc')->get();

        // Separar por estado
        $pendientes = $pagos->where('status', 'pending');
        $atrasados = $pagos->where('status', 'overdue');
        $pagados = $pagos->where('status', 'paid');

        return view('pages.Payments.index', compact('pagos', 'pendientes', 'atrasados', 'pagados'));
    }

    public function form() {}

    public function create(Request $request) {}

    public function show($id)
    {
        $payment = Payment::with(['order.shifts', 'order.users'])
            ->findOrFail($id);

        // Obtener los turnos relacionados con la orden del pago
        $shifts = $payment->order ? $payment->order->shifts()->orderBy('shift_date', 'asc')->get() : collect();

        // Obtener los usuarios asignados a la orden
        $users = $payment->order ? $payment->order->users : collect();

        // Calcular el total del pago
        $totalPago = $payment->labor_cost + $payment->machine_cost + $payment->fuel_expenses + $payment->extra_cost;

        return view('pages.Payments.show', compact('payment', 'shifts', 'users', 'totalPago'));
    }

    /**
     * Generar PDF del pago para impresión.
     */
    public function generatePDF($id)
    {
        $payment = Payment::with(['order.shifts', 'order.users'])
            ->findOrFail($id);

        // Obtener los turnos relacionados con la orden del pago
        $shifts = $payment->order ? $payment->order->shifts()->orderBy('shift_date', 'asc')->get() : collect();

        // Calcular el total del pago
        $totalPago = $payment->labor_cost + $payment->machine_cost + $payment->fuel_expenses + $payment->extra_cost;

        return view('pages.pdf.pago', compact('payment', 'shifts', 'totalPago'));
    }

    /**
     * Actualizar pago y orden desde el modal de edición.
     */
    public function updatePaymentAndOrder(Request $request, Payment $payment)
    {
        try {
            Log::info('updatePaymentAndOrder called', [
                'payment_id' => $payment->id_payment,
                'request_data' => $request->all()
            ]);

            // Validación de datos
            $validatedData = $request->validate([
                // Campos del pago
                'status' => 'required|in:pending,paid,overdue,void',
                'emission_date' => 'required|date',
                'payment_date' => 'nullable|date|after_or_equal:emission_date',
                'description' => 'nullable|string|max:1000',
                'labor_cost' => 'nullable|numeric|min:0',
                'machine_cost' => 'nullable|numeric|min:0',
                'fuel_expenses' => 'nullable|numeric|min:0',
                'extra_cost' => 'nullable|numeric|min:0',
                'info_extra_cost' => 'nullable|string|max:500',

                // Campos de la orden
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'work_info' => 'nullable|string|max:2000',

                // Campos de los turnos
                'shifts' => 'nullable|array',
                'shifts.*.shift_date' => 'nullable|date',
                'shifts.*.start_time' => 'nullable|date_format:H:i',
                'shifts.*.end_time' => 'nullable|date_format:H:i',
                'shifts.*.status' => 'nullable|in:pending,in_progress,completed,cancelled',
                'shifts.*.responsible' => 'nullable|string|max:255',
                'shifts.*.description' => 'nullable|string|max:1000',
            ], [
                'payment_date.after_or_equal' => 'La fecha de pago debe ser igual o posterior a la fecha de emisión.',
                'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
                'shifts.*.start_time.date_format' => 'El formato de hora de inicio debe ser HH:MM.',
                'shifts.*.end_time.date_format' => 'El formato de hora de fin debe ser HH:MM.',
            ]);

            // Procesar fecha de pago según el estado
            if ($validatedData['status'] === 'paid' && empty($validatedData['payment_date'])) {
                $validatedData['payment_date'] = now()->toDateString();
            } elseif ($validatedData['status'] !== 'paid') {
                $validatedData['payment_date'] = null;
            }

            // Actualizar datos del pago
            $paymentUpdateData = [
                'status' => $validatedData['status'],
                'emission_date' => $validatedData['emission_date'],
                'payment_date' => $validatedData['payment_date'],
                'description' => $validatedData['description'],
                'labor_cost' => $validatedData['labor_cost'] ?? 0,
                'machine_cost' => $validatedData['machine_cost'] ?? 0,
                'fuel_expenses' => $validatedData['fuel_expenses'] ?? 0,
                'extra_cost' => $validatedData['extra_cost'] ?? 0,
                'info_extra_cost' => $validatedData['info_extra_cost'],
            ];

            $payment->update($paymentUpdateData);
            Log::info('Payment updated successfully', ['payment_data' => $paymentUpdateData]);

            // Actualizar datos de la orden si existe
            if ($payment->order) {
                $orderUpdateData = [];

                if (!empty($validatedData['start_date'])) {
                    $orderUpdateData['start_date'] = $validatedData['start_date'];
                }
                if (!empty($validatedData['end_date'])) {
                    $orderUpdateData['end_date'] = $validatedData['end_date'];
                }
                if (!empty($validatedData['work_info'])) {
                    $orderUpdateData['work_info'] = $validatedData['work_info'];
                }

                if (!empty($orderUpdateData)) {
                    $payment->order->update($orderUpdateData);
                    Log::info('Order updated successfully', ['order_data' => $orderUpdateData]);
                }
            }

            // Actualizar turnos si se enviaron datos
            if (isset($validatedData['shifts']) && $payment->order) {
                $shiftsUpdated = 0;

                foreach ($validatedData['shifts'] as $shiftId => $shiftData) {
                    // Buscar el turno
                    $shift = Shift::where('id_shift', $shiftId)
                        ->where('id_order', $payment->order->id_order)
                        ->first();

                    if ($shift) {
                        $shiftUpdateData = [];

                        // Solo actualizar campos que tienen valores
                        if (!empty($shiftData['shift_date'])) {
                            $shiftUpdateData['shift_date'] = $shiftData['shift_date'];
                        }
                        if (!empty($shiftData['start_time'])) {
                            $shiftUpdateData['start_time'] = $shiftData['start_time'];
                        }
                        if (!empty($shiftData['end_time'])) {
                            $shiftUpdateData['end_time'] = $shiftData['end_time'];
                        }
                        if (!empty($shiftData['status'])) {
                            $shiftUpdateData['status'] = $shiftData['status'];
                        }
                        if (isset($shiftData['responsible'])) {
                            $shiftUpdateData['responsible'] = $shiftData['responsible'];
                        }
                        if (isset($shiftData['description'])) {
                            $shiftUpdateData['description'] = $shiftData['description'];
                        }

                        if (!empty($shiftUpdateData)) {
                            $shift->update($shiftUpdateData);
                            $shiftsUpdated++;
                            Log::info('Shift updated successfully', [
                                'shift_id' => $shiftId,
                                'shift_data' => $shiftUpdateData
                            ]);
                        }
                    }
                }

                Log::info('Shifts update completed', ['shifts_updated' => $shiftsUpdated]);
            }

            // Calcular nuevo total
            $newTotal = $payment->labor_cost + $payment->machine_cost + $payment->fuel_expenses + $payment->extra_cost;

            return response()->json([
                'success' => true,
                'message' => 'Pago y orden actualizados correctamente.',
                'data' => [
                    'payment' => $payment->fresh(['order']),
                    'total' => $newTotal
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);

            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating payment and order', [
                'payment_id' => $payment->id_payment,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar el estado de un pago.
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        try {
            // Debug: Log de datos recibidos
            Log::info('PaymentController updateStatus called', [
                'payment_id' => $payment->id_payment,
                'request_data' => $request->all()
            ]);

            // Validar todos los campos del pago y la orden
            $data = $request->validate([
                // Campos del pago
                'status' => 'required|in:pending,paid,overdue,void',
                'payment_date' => 'nullable|date|after_or_equal:emission_date',
                'emission_date' => 'required|date',
                'description' => 'nullable|string|max:1000',
                'labor_cost' => 'nullable|numeric|min:0',
                'machine_cost' => 'nullable|numeric|min:0',
                'fuel_expenses' => 'nullable|numeric|min:0',
                'extra_cost' => 'nullable|numeric|min:0',
                'info_extra_cost' => 'nullable|string|max:500',

                // Campos de la orden
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'work_info' => 'nullable|string|max:2000',
            ], [
                'payment_date.after_or_equal' => 'La fecha de pago debe ser igual o posterior a la fecha de emisión.',
                'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            ]);

            // Si el estado es 'paid', asegurar que tenga fecha de pago
            if ($data['status'] === 'paid') {
                if (empty($data['payment_date'])) {
                    $data['payment_date'] = Carbon::now()->toDateString();
                }
            } else {
                // Si no está pagado, limpiar la fecha de pago
                $data['payment_date'] = null;
            }

            // Separar datos del pago y de la orden
            $paymentData = [
                'status' => $data['status'],
                'payment_date' => $data['payment_date'],
                'emission_date' => $data['emission_date'],
                'description' => $data['description'],
                'labor_cost' => $data['labor_cost'] ?? 0,
                'machine_cost' => $data['machine_cost'] ?? 0,
                'fuel_expenses' => $data['fuel_expenses'] ?? 0,
                'extra_cost' => $data['extra_cost'] ?? 0,
                'info_extra_cost' => $data['info_extra_cost'],
            ];

            $orderData = [
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'work_info' => $data['work_info'],
            ];

            // Actualizar el pago
            $payment->fill($paymentData)->save();
            Log::info('Payment updated', ['payment_data' => $paymentData]);

            // Actualizar la orden si existe
            if ($payment->order) {
                // Filtrar campos nulos para no sobrescribir datos existentes
                $orderDataFiltered = array_filter($orderData, function ($value) {
                    return $value !== null && $value !== '';
                });

                if (!empty($orderDataFiltered)) {
                    $payment->order->fill($orderDataFiltered)->save();
                    Log::info('Order updated', ['order_data' => $orderDataFiltered]);
                }
            }

            // Si es una petición AJAX, retornar JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pago y orden actualizados correctamente.',
                    'payment' => $payment->fresh(['order']),
                    'total' => $payment->labor_cost + $payment->machine_cost + $payment->fuel_expenses + $payment->extra_cost
                ]);
            }

            return back()->with('success', 'Pago y orden actualizados correctamente.');
        } catch (\Exception $e) {
            Log::error('Error updating payment', [
                'payment_id' => $payment->id_payment,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualizar el pago: ' . $e->getMessage()]);
        }
    }
}
