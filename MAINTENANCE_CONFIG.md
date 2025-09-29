# Configuración de Modo de Mantenimiento

## Variables de Entorno

Agrega las siguientes variables a tu archivo `.env`:

```env
# Para activar el modo de mantenimiento, cambia MAINTENANCE_MODE a true
MAINTENANCE_MODE=false

# Mensaje personalizado para la página de mantenimiento
MAINTENANCE_MESSAGE="Estamos trabajando para mejorar nuestro servicio. Volveremos pronto."

# Tiempo estimado de mantenimiento
MAINTENANCE_ESTIMATED_TIME="2-4 horas"

# Información de contacto durante el mantenimiento
MAINTENANCE_CONTACT_EMAIL="soporte@aleph.edu"
MAINTENANCE_CONTACT_PHONE="+1 (555) 123-4567"
```

## Cómo Usar

1. **Activar modo de mantenimiento:**
   ```env
   MAINTENANCE_MODE=true
   ```

2. **Desactivar modo de mantenimiento:**
   ```env
   MAINTENANCE_MODE=false
   ```

3. **Personalizar el mensaje:**
   ```env
   MAINTENANCE_MESSAGE="Tu mensaje personalizado aquí"
   ```

## Características

- ✅ Diseño corporativo moderno
- ✅ Responsive (móvil y desktop)
- ✅ Animaciones suaves
- ✅ Auto-refresh cada 30 segundos
- ✅ Información de contacto
- ✅ Tiempo estimado de finalización
- ✅ Rutas específicas permitidas durante mantenimiento
- ✅ Logo corporativo
- ✅ Mensajes personalizables

## Rutas Permitidas Durante Mantenimiento

- `/login` - Para que los administradores puedan acceder
- `/admin/home` - Panel de administración
- `/admin/configuracion` - Configuración del sistema
