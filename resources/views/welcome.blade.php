<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Asistencia Universitaria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            text-align: center;
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-icon {
            font-size: 80px;
            color: #667eea;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .welcome-title {
            color: #2d3748;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .welcome-subtitle {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        .btn-custom {
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-register {
            background: white;
            border: 3px solid #667eea;
            color: #667eea;
        }
        .btn-register:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .features {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e2e8f0;
        }
        .feature-item {
            display: inline-block;
            margin: 0 15px;
            color: #718096;
            font-size: 0.9rem;
        }
        .feature-item i {
            color: #667eea;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="logo-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <h1 class="welcome-title">Sistema de Asistencia</h1>
        <p class="welcome-subtitle">Control y Gestión de Asistencia Universitaria</p>

        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center">
            <a href="{{ route('login') }}" class="btn btn-custom btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="btn btn-custom btn-register">
                <i class="fas fa-user-plus me-2"></i>Registrarse
            </a>
        </div>

        <div class="features">
            <div class="feature-item">
                <i class="fas fa-clock"></i>
                <span>Registro en Tiempo Real</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-line"></i>
                <span>Reportes Detallados</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-mobile-alt"></i>
                <span>Acceso Móvil</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
