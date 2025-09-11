<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Trabajo - La Cavadora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #EE7B12;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .info-section {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #EE7B12;
        }
        .info-section h3 {
            color: #EE7B12;
            margin-top: 0;
        }
        .info-item {
            margin: 10px 0;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .cta-button {
            display: inline-block;
            background-color: #EE7B12;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔨 Nueva Solicitud de Trabajo</h1>
        <p>La Cavadora - Servicios de Excavación</p>
    </div>
    
    <div class="content">
        <p>Hola,</p>
        <p>Se ha recibido una nueva solicitud de trabajo a través del formulario web de La Cavadora.</p>
        
        <div class="info-section">
            <h3>👤 Información del Cliente</h3>
            <div class="info-item">
                <span class="info-label">Nombre:</span> {{ $solicitud->client_name }}
            </div>
            @if($solicitud->cliente_rut)
            <div class="info-item">
                <span class="info-label">RUT:</span> {{ $solicitud->cliente_rut }}
            </div>
            @endif
            @if($solicitud->client_phone)
            <div class="info-item">
                <span class="info-label">Teléfono:</span> {{ $solicitud->client_phone }}
            </div>
            @endif
            @if($solicitud->cliente_email)
            <div class="info-item">
                <span class="info-label">Email:</span> {{ $solicitud->cliente_email }}
            </div>
            @endif
            <div class="info-item">
                <span class="info-label">Dirección del Trabajo:</span> {{ $solicitud->client_address }}
            </div>
        </div>
        
        <div class="info-section">
            <h3>🔧 Descripción del Trabajo</h3>
            <div class="info-item">
                <span class="info-label">Detalles:</span><br>
                {{ $solicitud->work_info }}
            </div>
        </div>
        
        <div class="info-section">
            <h3>💰 Información de Costos</h3>
            <div class="info-item">
                <span class="info-label">Costo por hora:</span> $18.750
            </div>
            <div class="info-item">
                <span class="info-label">Duración mínima:</span> 8 horas por turno
            </div>
            <div class="info-item">
                <span class="info-label">Nota:</span> Pueden existir costos adicionales que no dependen de las horas trabajadas
            </div>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="https://lacavadora.cl/login" class="cta-button">
                🔗 Revisar en el Panel de Administración
            </a>
        </div>
        
        <p><strong>Próximos pasos:</strong></p>
        <ul>
            <li>Revisar la solicitud en el panel de administración</li>
            <li>Contactar al cliente para coordinar detalles adicionales</li>
            <li>Programar la fecha y hora del trabajo</li>
        </ul>
    </div>
    
    <div class="footer">
        <p>Este email fue enviado automáticamente desde el sistema de La Cavadora</p>
        <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
