<!DOCTYPE html>
<html lang="es">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>@yield('title', config('app.name'))</title>
      <style>
         body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.5;
            color: #2c3e50;
            max-width: 650px;
            margin: 0 auto;
            padding: 25px;
         }

         .email-container {
            padding: 0;
         }

         .content {
            padding: 0;
            font-size: 16px;
         }

         h1,
         h2,
         h3 {
            color: #34495e;
            margin-top: 0;
            margin-bottom: 16px;
            font-weight: 600;
         }

         h1 {
            font-size: 22px;
            line-height: 1.3;
         }

         h2 {
            font-size: 20px;
            line-height: 1.3;
         }

         h3 {
            font-size: 18px;
            line-height: 1.3;
         }

         p {
            margin: 0 0 16px 0;
            font-size: 16px;
         }

         .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin: 16px 0;
            font-weight: 500;
            font-size: 15px;
         }

         .button:hover {
            background-color: #2980b9;
         }

         .highlight {
            background-color: #f8f9fa;
            padding: 16px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
         }

         .warning {
            background-color: #fef5e7;
            border-left: 4px solid #f39c12;
            padding: 16px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
         }

         .info {
            background-color: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 16px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
         }

         .success {
            background-color: #eafaf1;
            border-left: 4px solid #27ae60;
            padding: 16px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
         }

         .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
            font-size: 14px;
            color: #7f8c8d;
            line-height: 1.4;
         }

         .text-center {
            text-align: center;
         }

         .text-muted {
            color: #7f8c8d;
         }

         .break-all {
            word-break: break-all;
         }

         a {
            color: #3498db;
            text-decoration: none;
         }

         a:hover {
            text-decoration: underline;
         }

         ul,
         ol {
            margin: 0 0 16px 0;
            padding-left: 20px;
         }

         li {
            margin-bottom: 4px;
         }

         @stack('styles')
      </style>
   </head>

   <body>
      <div class="email-container">
         <div class="content">
            @yield('content')
         </div>

         @include('emails.partials.footer_comunicativo')
      </div>
   </body>

</html>
