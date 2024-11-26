<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            margin: 0 0 10px;
        }
        .content p {
            margin: 10px 0;
        }
        .content .details {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Comprobante de Pago</h1>
        </div>
        <div class="content">
            <h2>¡Gracias por tu compra!</h2>
            <p>Hemos recibido tu pago exitosamente. Aquí tienes los detalles de tu transacción:</p>
            <div class="details">
                <p><strong>Compra tipo:</strong> Especial</p>
                <p><strong>Número de transacción:</strong> #{{ $id_compra }}</p>
                <p><strong>Fecha:</strong> {{ $compra->fecha }}</p>
                <p><strong>Total pagado:</strong> {{ $compra->total }}</p>
                <p><strong>Cod Autotizacion:</strong> {{ $transbank->authorizationCode }}</p>
                {{-- <p><strong>Método de pago:</strong> {{ $tipo_tarjeta }}</p> --}}
                @if($transbank->installmentsNumber != 0)
                    <p><strong>Cuotas:</strong> {{ $transbank->installmentsNumber }}</p>
                @endif
                @if($transbank->installmentsAmount != 0)
                    <p><strong>Val Cuotas:</strong> {{ $transbank->installmentsAmount }}</p>
                @endif
                <p><strong>Método de pago:</strong> {{ $transbank->cardNumber }}</p>
                <p><strong>Direccion:</strong> {{ $compra->direccion }}</p>
                <p><strong>Nota:</strong> {{ $compra->nota }}</p>

            </div>
            <p>Si tienes alguna pregunta, no dudes en ponerte en contacto con nosotros.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ $year }} Neumachile. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
