<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LabelTech - تسجيل الدخول</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Cairo', 'Arial', sans-serif;
                background-color: #f3f4f6;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            
            .container {
                width: 100%;
                max-width: 28rem;
            }
            
            .logo-section {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .logo-section h1 {
                font-size: 2rem;
                font-weight: 700;
                color: #111827;
                margin-bottom: 0.375rem;
                letter-spacing: -0.025em;
            }
            
            .logo-section p {
                font-size: 0.9375rem;
                color: #6b7280;
                font-weight: 500;
            }
            
            .card {
                background-color: #ffffff;
                border-radius: 0.75rem;
                border: 1px solid #e5e7eb;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                padding: 2.5rem;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-label {
                display: block;
                font-size: 0.9375rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.5rem;
            }
            
            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 2px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 0.9375rem;
                font-family: 'Cairo', 'Arial', sans-serif;
                transition: all 0.2s;
            }
            
            .form-input:focus {
                outline: none;
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }
            
            .btn-primary {
                width: 100%;
                padding: 0.75rem 1rem;
                background-color: #2563eb;
                color: #ffffff;
                font-weight: 600;
                font-size: 0.9375rem;
                border: none;
                border-radius: 0.5rem;
                cursor: pointer;
                font-family: 'Cairo', 'Arial', sans-serif;
                transition: all 0.2s;
            }
            
            .btn-primary:hover {
                background-color: #1d4ed8;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            
            .checkbox-group {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
            }
            
            .checkbox-group input {
                width: 1rem;
                height: 1rem;
                margin-left: 0.5rem;
            }
            
            .checkbox-group label {
                font-size: 0.875rem;
                color: #4b5563;
            }
            
            .forgot-link {
                font-size: 0.875rem;
                color: #2563eb;
                text-decoration: none;
            }
            
            .forgot-link:hover {
                color: #1d4ed8;
            }
            
            .flex-between {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1rem;
            }
            
            .title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #111827;
                margin-bottom: 0.375rem;
                letter-spacing: -0.025em;
            }
            
            .subtitle {
                font-size: 0.9375rem;
                color: #6b7280;
                margin-bottom: 1.5rem;
                font-weight: 500;
            }
            
            h1, h2, h3, h4, h5, h6 {
                font-weight: 700;
                color: #111827;
                line-height: 1.3;
            }
            
            p, span, div, label {
                color: #374151;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Logo Section -->
            <div class="logo-section">
                <h1>LabelTech</h1>
                <p>نظام إدارة الموظفين والعملاء</p>
            </div>

            <!-- Login Card -->
            <div class="card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
