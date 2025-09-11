<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Solicitud - La Cavadora</title>
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
            padding: 30px;
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
        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .next-steps {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            color: #004085;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .contact-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            color: #EE7B12;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔨 ¡Solicitud Recibida!</h1>
        <p>La Cavadora - Servicios de Excavación</p>
    </div>
    
    <div class="content">
        <p>Hola <strong>{{ $solicitud->client_name }}</strong>,</p>
        
        <div class="success-message">
            <h2>✅ ¡Gracias por tu solicitud!</h2>
            <p>Hemos recibido tu solicitud de servicio y nuestro equipo se pondrá en contacto contigo pronto.</p>
        </div>
        
        <div class="info-section">
            <h3>📋 Resumen de tu Solicitud</h3>
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
        
        <div class="next-steps">
            <h3>🚀 Próximos Pasos</h3>
            <ul>
                <li><strong>Revisión:</strong> Nuestro equipo revisará tu solicitud en las próximas 24 horas</li>
                <li><strong>Contacto:</strong> Te contactaremos para coordinar detalles adicionales</li>
                <li><strong>Cotización:</strong> Te enviaremos una cotización detallada</li>
                <li><strong>Programación:</strong> Coordinaremos la fecha y hora del trabajo</li>
            </ul>
        </div>
        
        <div class="contact-info">
            <h3>📞 Información de Contacto</h3>
            <p><strong>Teléfono:</strong> +56 9 5193 903</p>
            <p><strong>Email:</strong> info@lacavadora.cl</p>
            <p><strong>Horario de Atención:</strong> Lunes a Viernes de 8:00 a 18:00 hrs</p>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <p><strong>¿Tienes alguna pregunta?</strong></p>
            <p>No dudes en contactarnos si necesitas aclarar algo sobre tu solicitud.</p>
        </div>
    </div>
    
    <div class="footer">
        <p>Este email fue enviado automáticamente desde el sistema de La Cavadora</p>
        <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>
        <p>Gracias por confiar en nuestros servicios de excavación</p>
    </div>
</body>
</html>
