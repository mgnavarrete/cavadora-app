# 📑 Esquema de Base de Datos — Plataforma de Gestión de Trabajos

## 1. `users` (Usuarios)

**Propósito:** almacenar credenciales e identidad de los usuarios de la plataforma.

| Atributo          | Tipo / Formato | Descripción    |
| ----------------- | -------------- | -------------- |
| id                | int            | auto_increment |
| name              | varchar(255)   |                |
| email             | varchar(255)   |                |
| email_verified_at | timestamp      |                |
| empresa           | varchar(45)    |                |
| password          | varchar(255)   |                |
| remember_token    | varchar(100)   |                |
| created_at        | timestamp      |                |
| updated_at        | timestamp      |                |

---

## 2. `orders` (Ordenes de Trabajo)

**Propósito:** unidad principal del sistema; incluye snapshot del cliente y detalle del trabajo.

### Datos del cliente

| Atributo         | Tipo / Formato                        | Descripción                       |
| ---------------- | ------------------------------------- | --------------------------------- |
| `id_order`       | INT AUTO_INCREMENT (PK)               | Identificador único del usuario.  |
| `client_name`    | VARCHAR(150)                          | Nombre del cliente.               |
| `cliente_rut`    | VARCHAR(20)                           | RUT o identificación (si aplica). |
| `client_phone`   | VARCHAR(50)                           | Teléfono del cliente.             |
| `cliente_email`  | VARCHAR(150)                          | Correo de contacto.               |
| `client_address` | VARCHAR(255)                          | Dirección del trabajo.            |
| `client_info`    | TEXT                                  | Información adicional o notas.    |
| `work_info`      | TEXT                                  | Detalle/alcance del trabajo.      |
| `estado`         | ENUM('in_progress','done','canceled') | Estado actual de la orden.        |
| `start_date`     | DATE                                  | Fecha planificada de inicio.      |
| `end_date`       | DATE                                  | Fecha planificada de término.     |
| `created_at`     | TIMESTAMP                             | Creación del registro.            |
| `updated_at`     | TIMESTAMP                             | Última actualización.             |

---

## 3. `user_orden` (Visibilidad)

**Propósito:** asignar qué usuarios pueden ver/gestionar cada orden.

| Atributo   | Tipo / Formato        | Descripción                    |
| ---------- | --------------------- | ------------------------------ |
| `id_user`  | INT (FK → users.id)   | Usuario asignado.              |
| `id_orden` | INT (FK → ordenes.id) | Orden visible para el usuario. |

**PK compuesta:** `(id_user, id_orden)`.

---

## 4. `shifts` (Jornadas de Trabajo)

**Propósito:** registrar cada día/turno en que se trabaja sobre una orden.

| Atributo      | Tipo / Formato                                          | Descripción                    |
| ------------- | ------------------------------------------------------- | ------------------------------ |
| `id_shift`    | INT AUTO_INCREMENT (PK)                                 | Identificador de la jornada.   |
| `id_order`    | INT (FK → order.id_order)                               | Orden asociada.                |
| `date`        | DATE                                                    | Día de la jornada.             |
| `start_time`  | TIME                                                    | Hora de inicio.                |
| `end_time`    | TIME                                                    | Hora de término.               |
| `description` | TEXT                                                    | Qué se hará/hizo.              |
| `status`      | ENUM('pending', 'completed', 'canceled', 'rescheduled') | Estado de la jornada.          |
| `responsible` | VARCHAR(150)                                            | Operador asignado (si aplica). |
| `created_at`  | TIMESTAMP                                               | Creación del registro.         |
| `updated_at`  | TIMESTAMP                                               | Última actualización.          |

---

## 5. `payments` (Cobros / Liquidaciones)

**Propósito:** registrar pagos emitidos/cobrados para una orden.

| Atributo          | Tipo / Formato                             | Descripción                |
| ----------------- | ------------------------------------------ | -------------------------- |
| `id_payment`      | INT AUTO_INCREMENT (PK)                    | Identificador del pago.    |
| `id_order`        | INT (FK → ordenes.id)                      | Orden asociada.            |
| `labor_cost`      | INT                                        | Valor mano de obra.        |
| `machine_cost`    | INT                                        | Valor arriendo de máquina. |
| `fuel_expenses`   | INT                                        | Gastos de combustible.     |
| `extra_cost`      | INT                                        | Gastos extras              |
| `info_extra_cost` | VARCHAR(150)                               | infromación de gasto extra |
| `status`          | ENUM('pending', 'overdue', 'paid', 'void') | Estado del pago.           |
| `emission_date`   | DATE, default=CURDATE()                    | Fecha de emisión.          |
| `payment_date`    | DATE                                       | Fecha en que se pagó.      |
| `description`     | TEXT                                       | Notas del cobro.           |
| `created_at`      | TIMESTAMP                                  | Creación del registro.     |
| `updated_at`      | TIMESTAMP                                  | Última actualización.      |
