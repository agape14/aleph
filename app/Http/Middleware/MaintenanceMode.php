<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el modo de mantenimiento está activado
        if (env('MAINTENANCE_MODE', false)) {
            // Permitir acceso a rutas específicas durante mantenimiento
            $allowedRoutes = [
                'login',
                'admin.home',
                'admin.configuracion'
            ];

            // Si la ruta actual no está permitida, mostrar página de mantenimiento
            if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                return response()->view('maintenance', [
                    'message' => env('MAINTENANCE_MESSAGE', 'Estamos trabajando para mejorar nuestro servicio. Volveremos pronto.'),
                    'estimatedTime' => env('MAINTENANCE_ESTIMATED_TIME', '4-6 horas'),
                    'contactEmail' => env('MAINTENANCE_CONTACT_EMAIL', 'soporte@aleph.edu'),
                    'contactPhone' => env('MAINTENANCE_CONTACT_PHONE', '+1 (555) 123-4567')
                ], 503);
            }
        }

        return $next($request);
    }
}
