# 🚜 Cavadora App - Sistema de Gestión de Trabajos de Excavación

## 📋 Descripción General

**Cavadora App** es una aplicación web desarrollada en Laravel para la gestión integral de trabajos de excavación y servicios de maquinaria pesada. El sistema permite administrar órdenes de trabajo, programar turnos, gestionar pagos y generar reportes financieros.

## 🎯 Funcionalidades Principales

### 🏠 **Panel Principal (Dashboard)**

- **Resumen financiero**: Visualización de ingresos del mes actual, anterior y ante-anterior
- **Estadísticas de trabajo**: Total de órdenes, turnos completados y pendientes
- **Próximos turnos**: Vista de las sesiones de trabajo programadas para la semana
- **Pagos pendientes**: Lista de facturas por cobrar y atrasadas
- **Indicadores de rendimiento**: Comparativas mensuales y tendencias

### 📋 **Gestión de Órdenes de Trabajo**

- **Crear nuevas órdenes**: Registro completo de clientes y detalles del trabajo
- **Información del cliente**: Nombre, RUT, teléfono, email, dirección
- **Detalles del trabajo**: Descripción del servicio, fechas de inicio y fin
- **Estados de orden**: En progreso, completado, cancelado
- **Búsqueda y filtrado**: Localizar órdenes por cliente, teléfono, dirección, etc.
- **Edición completa**: Modificar información de cliente y trabajo
- **Eliminación segura**: Borrado completo con confirmación

### ⏰ **Gestión de Turnos/Sesiones**

- **Programación de turnos**: Agendar sesiones de trabajo por fecha y hora
- **Duración mínima**: Validación de 8 horas mínimo por turno
- **Estados de turno**: Pendiente, completado, cancelado, reprogramado
- **Responsable asignado**: Asignación de operador por turno
- **Descripción de trabajo**: Detalles específicos de cada sesión
- **Edición en tiempo real**: Actualización de horarios y estados
- **Eliminación de turnos**: Cancelación de sesiones programadas

### 💰 **Gestión de Pagos y Facturación**

- **Cálculo automático**: Total basado en horas trabajadas y costos extras
- **Estados de pago**: Pendiente, pagado, atrasado, anulado
- **Fechas de emisión y pago**: Control temporal de facturación
- **Costos por hora**: Tarifa de mano de obra configurable
- **Gastos extras**: Costos adicionales con descripción
- **Generación de PDF**: Facturas imprimibles
- **Actualización de estados**: Cambio de estado de pagos
- **Filtros por mes**: Visualización de pagos por período

### 📅 **Calendario de Trabajos**

- **Vista mensual**: Visualización de todas las órdenes y turnos
- **Fechas de inicio y fin**: Marcado de períodos de trabajo
- **Turnos programados**: Sesiones de trabajo en el calendario
- **Navegación temporal**: Movimiento entre meses
- **Información detallada**: Acceso rápido a detalles de órdenes

## 🚀 Cómo Usar la Aplicación

### 1. **Acceso al Sistema**

- Visita la página principal
- Si no tienes cuenta, regístrate con tus datos
- Inicia sesión con email y contraseña

### 2. **Crear una Nueva Orden de Trabajo**

1. Ve a **"Trabajos"** en el menú principal
2. Haz clic en **"Nuevo Trabajo"**
3. Completa la información del cliente:
   - Nombre completo
   - RUT (opcional)
   - Teléfono y email
   - Dirección del trabajo
4. Describe el trabajo a realizar
5. Establece fechas de inicio y fin
6. Define el costo por hora y gastos extras
7. Guarda la orden

### 3. **Programar Turnos de Trabajo**

1. Ve a los detalles de una orden
2. Haz clic en **"Agendar Turno"**
3. Selecciona la fecha del turno
4. Establece horario de inicio y fin (mínimo 8 horas)
5. Asigna un responsable
6. Añade descripción del trabajo
7. Guarda el turno

### 4. **Gestionar Pagos**

1. Ve a **"Pagos"** en el menú
2. Visualiza todos los pagos por estado:
   - **Pendientes**: Facturas emitidas sin pagar
   - **Atrasados**: Pagos vencidos
   - **Pagados**: Facturas cobradas
3. Para actualizar un pago:
   - Haz clic en el pago
   - Modifica el estado, fechas o montos
   - Guarda los cambios
4. Genera PDF para imprimir facturas

### 5. **Usar el Calendario**

1. Ve a **"Calendario"** en el menú
2. Navega entre meses usando las flechas
3. Visualiza:
   - Órdenes activas (períodos de trabajo)
   - Turnos programados (sesiones específicas)
4. Haz clic en cualquier elemento para ver detalles

### 6. **Monitorear el Dashboard**

- **Ingresos**: Compara ganancias entre meses
- **Trabajos**: Ve el total de órdenes activas
- **Turnos**: Revisa sesiones pendientes de la semana
- **Pagos**: Controla facturas por cobrar

## 📊 Estados y Flujos de Trabajo

### **Estados de Órdenes**

- **En Progreso**: Trabajo activo
- **Completado**: Trabajo finalizado
- **Cancelado**: Trabajo cancelado

### **Estados de Turnos**

- **Pendiente**: Programado para ejecutar
- **Completado**: Sesión finalizada
- **Cancelado**: Sesión cancelada
- **Reprogramado**: Fecha/hora modificada

### **Estados de Pagos**

- **Pendiente**: Factura emitida, sin pagar
- **Pagado**: Factura cobrada
- **Atrasado**: Pago vencido (automático después de 2 meses)
- **Anulado**: Factura cancelada

## 🔧 Características Técnicas

- **Framework**: Laravel 10
- **Base de datos**: MySQL
- **Autenticación**: Sistema de usuarios con roles
- **PDF**: Generación de facturas con DomPDF
- **Interfaz**: Bootstrap con diseño responsivo
- **Zona horaria**: Chile (America/Santiago)

## 📱 Responsive Design

La aplicación está optimizada para:

- **Desktop**: Experiencia completa con todas las funcionalidades
- **Tablet**: Navegación adaptada para pantallas medianas
- **Mobile**: Interfaz simplificada para dispositivos móviles

## 🎨 Interfaz de Usuario

- **Dashboard intuitivo**: Métricas clave en tarjetas visuales
- **Navegación clara**: Menú lateral con acceso rápido
- **Formularios organizados**: Campos agrupados lógicamente
- **Feedback visual**: Mensajes de éxito y error
- **Iconografía consistente**: Iconos para cada funcionalidad

## 📈 Reportes y Análisis

- **Ingresos mensuales**: Comparativas automáticas
- **Productividad**: Turnos completados vs pendientes
- **Facturación**: Estados de pagos y montos
- **Calendario**: Vista temporal de todos los trabajos

## 🔒 Seguridad

- **Autenticación requerida**: Acceso solo para usuarios registrados
- **Validación de datos**: Verificación de formularios
- **Transacciones seguras**: Operaciones atómicas en base de datos
- **Sanitización**: Limpieza de datos de entrada

---

## 💡 Consejos de Uso

1. **Organiza tus trabajos**: Usa fechas realistas para inicio y fin
2. **Programa turnos con anticipación**: Evita conflictos de horarios
3. **Actualiza estados regularmente**: Mantén la información actualizada
4. **Revisa el dashboard diariamente**: Monitorea tu productividad
5. **Genera PDFs para clientes**: Usa las facturas para cobranza
6. **Usa el calendario**: Visualiza tu agenda de trabajo

---

_Esta aplicación está diseñada para optimizar la gestión de trabajos de excavación, proporcionando herramientas completas para el control de clientes, programación de turnos y seguimiento financiero._
