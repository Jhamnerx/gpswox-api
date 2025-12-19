# GPSWox API PHP Client

Una biblioteca PHP completa para interactuar con la API de GPSWox, un sistema de rastreo GPS.

## 📦 Instalación

```bash
composer require gpswox/api-client
```

## 🚀 Uso Básico

### Inicialización

```php
use Gpswox\Wox;

// Con API hash existente
$client = new Wox('https://tu-dominio-gpswox.com/', 'tu-api-hash');

// O hacer login para obtener el API hash
$client = new Wox('https://tu-dominio-gpswox.com/');
$apiHash = $client->login('tu-email@ejemplo.com', 'tu-contraseña');
```

## 📚 Recursos Disponibles

Este SDK proporciona acceso completo a más de 150 endpoints de la API de GPSWox, organizados en 17 recursos principales:

### 1. Setup (Configuración)

Gestiona la configuración de la cuenta de usuario.

```php
$setup = $client->setup();

// Obtener datos completos de configuración
$setupData = $setup->getEditSetupData();

// Actualizar configuración
$setup->updateSetupData([
    'lang' => 'es',
    'unit_of_distance' => 'km',
    'timezone_id' => '65'
]);

// Obtener datos de usuario
$userData = $setup->getUserData();

// Cambiar contraseña
$setup->changePassword([
    'old_password' => 'contraseña_antigua',
    'new_password' => 'contraseña_nueva'
]);

// Obtener zonas horarias disponibles
$timezones = $setup->getTimezones();
```

// Obtener unidades de distancia
$distanceUnits = $setup->getDistanceUnits();

// Obtener unidades de capacidad
$capacityUnits = $setup->getCapacityUnits();

// Obtener unidades de altitud
$altitudeUnits = $setup->getAltitudeUnits();

// Obtener información del usuario
$userInfo = $setup->getUserInfo();

// Obtener timezone actual del usuario
$currentTimezone = $setup->getCurrentTimezone();
if ($currentTimezone) {
echo "Timezone actual: {$currentTimezone['value']} (ID: {$currentTimezone['id']})";
}

// Obtener opciones de SMS Gateway
$smsOptions = $setup->getSmsGatewayOptions();

// Obtener opciones de horario de verano (DST)
$dstOptions = $setup->getDstOptions();

````

### 2. Device (Dispositivos)

Gestiona dispositivos GPS y sus grupos.

```php
$device = $client->device();

// Listar dispositivos
$devices = $device->listDevices();

// Obtener últimos datos de dispositivos
$latestData = $device->getDevicesLatest();

// Crear dispositivo
$newDevice = $device->createDevice([
    'name' => 'Mi Dispositivo',
    'imei' => '123456789012345'
]);

// Editar dispositivo
$device->editDevice(1, ['name' => 'Dispositivo Actualizado']);

// Gestión de grupos de dispositivos
$groups = $device->getDeviceGroups();
$device->storeDeviceGroup(['name' => 'Flota 1']);

// Media de dispositivos
$media = $device->getDeviceMedia(1);
$file = $device->getDeviceMediaFile(1, 'image.jpg');
````

### 3. History (Historial)

Accede al historial de posiciones y mensajes de dispositivos.

```php
$history = $client->history();

// Obtener historial
$historyData = $history->getHistory(1, '2023-01-01 00:00:00', '2023-01-31 23:59:59');

// Obtener mensajes
$messages = $history->getHistoryMessages(1, '2023-01-01 00:00:00', '2023-01-31 23:59:59');

// Eliminar posiciones
$history->deleteHistoryPositions(1, '2023-01-01 00:00:00', '2023-01-31 23:59:59');
```

### 4. Alert (Alertas)

Gestiona alertas y notificaciones del sistema.

```php
$alert = $client->alert();

// Listar alertas
$alerts = $alert->getAlerts();

// Crear alerta
$alert->addAlert([
    'name' => 'Alerta de Velocidad',
    'type' => 'overspeed',
    'limit' => 120
]);

// Obtener alertas de dispositivo
$deviceAlerts = $alert->getDeviceAlerts(1);

// Configurar período de tiempo para alerta
$alert->setAlertTimePeriod(1, 5, [
    'from' => '08:00',
    'to' => '18:00'
]);

// Obtener protocolos y eventos
$protocols = $alert->getProtocols();
$events = $alert->getEventsByProtocol('teltonika');
```

### 5. Sensor (Sensores)

Gestiona sensores de dispositivos.

```php
$sensor = $client->sensor();

// Obtener sensores de un dispositivo
$sensors = $sensor->getSensors(1);

// Crear sensor
$sensor->addSensor([
    'device_id' => 1,
    'name' => 'Sensor de Temperatura',
    'type' => 'temperature'
]);

// Editar sensor
$sensor->editSensor(1, ['name' => 'Temperatura Motor']);

// Eliminar sensor
$sensor->destroySensor(1);
```

### 6. Service (Servicios)

Gestiona servicios de mantenimiento de vehículos.

```php
$service = $client->service();

// Obtener servicios
$services = $service->getServices(1);

// Crear servicio
$service->addService([
    'device_id' => 1,
    'name' => 'Cambio de Aceite',
    'interval' => 5000
]);
```

### 7. Geofence (Geocercas)

Gestiona geocercas (zonas geográficas).

```php
$geofence = $client->geofence();

// Listar geocercas
$geofences = $geofence->getGeofences();

// Crear geocerca
$geofence->addGeofence([
    'name' => 'Zona Centro',
    'coordinates' => '...',
    'polygon_color' => '#FF0000'
]);

// Verificar si un punto está en geocercas
$result = $geofence->pointInGeofences(-34.603722, -58.381592);

// Grupos de geocercas
$groups = $geofence->getGeofenceGroups();
```

### 8. Route (Rutas)

Gestiona rutas predefinidas.

```php
$route = $client->route();

// Listar rutas
$routes = $route->getRoutes();

// Crear ruta
$route->addRoute([
    'name' => 'Ruta Principal',
    'coordinates' => '...'
]);

// Grupos de rutas
$groups = $route->getRouteGroups();
```

### 9. Report (Reportes)

Genera y gestiona reportes.

```php
$report = $client->report();

// Listar reportes
$reports = $report->getReports();

// Tipos de reportes disponibles
$types = $report->getReportTypes();

// Crear reporte
$report->addReport([
    'title' => 'Reporte Mensual',
    'type' => 'general'
]);

// Generar reporte
$data = $report->generateReport(1, [
    'from' => '2023-01-01',
    'to' => '2023-01-31'
]);
```

### 10. Command (Comandos)

Envía comandos GPRS y SMS a dispositivos.

```php
$command = $client->command();

// Obtener datos para comando
$data = $command->sendCommandData(1);

// Enviar comando GPRS
$command->sendGprsCommand(1, [
    'command' => 'getlocation'
]);

// Enviar comando SMS
$command->sendSmsCommand(1, [
    'message' => 'STATUS#'
]);

// Ver comandos enviados
$commands = $command->getDeviceCommands(1);
```

### 11. Event (Eventos)

Gestiona eventos de dispositivos.

```php
$event = $client->event();

// Obtener eventos
$events = $event->getEvents(['device_id' => 1]);

// Eliminar eventos
$event->destroyEvents(1);
```

### 12. Custom Event (Eventos Personalizados)

Gestiona eventos personalizados.

```php
$customEvent = $client->customEvent();

// Listar eventos personalizados
$events = $customEvent->getCustomEvents();

// Crear evento personalizado
$customEvent->addCustomEvent([
    'name' => 'Entrada a Zona',
    'type' => 'geofence_in'
]);
```

### 13. Task (Tareas)

Gestiona tareas y asignaciones.

```php
$task = $client->task();

// Listar tareas
$tasks = $task->getTasks();

// Obtener tarea específica
$taskDetail = $task->getTask(1);

// Crear tarea
$task->addTask([
    'title' => 'Entrega Cliente',
    'device_id' => 1,
    'priority' => 'high'
]);

// Obtener estados y prioridades
$statuses = $task->getTaskStatuses();
$priorities = $task->getTaskPriorities();
```

### 14. Driver (Conductores)

Gestiona información de conductores.

```php
$driver = $client->driver();

// Listar conductores
$drivers = $driver->getUserDrivers();

// Crear conductor
$driver->addUserDriver([
    'name' => 'Juan Pérez',
    'license' => 'ABC123',
    'phone' => '+5491123456789'
]);
```

### 15. Map Icon (Iconos de Mapa)

Gestiona iconos personalizados para el mapa.

```php
$mapIcon = $client->mapIcon();

// Listar iconos de usuario
$icons = $mapIcon->getUserMapIcons();

// Crear icono personalizado
$mapIcon->addMapIcon([
    'name' => 'Mi Icono',
    'icon' => fopen('/path/to/icon.png', 'r')
]);

// Grupos de POIs
$pois = $mapIcon->getPoisGroups();
```

### 16. GPRS Template (Plantillas GPRS)

Gestiona plantillas de comandos GPRS.

```php
$gprs = $client->gprsTemplate();

// Listar plantillas
$templates = $gprs->getUserGprsTemplates();

// Crear plantilla
$gprs->addUserGprsTemplate([
    'name' => 'Obtener Ubicación',
    'message' => 'getlocation'
]);
```

### 17. SMS Template (Plantillas SMS)

Gestiona plantillas de mensajes SMS.

```php
$sms = $client->smsTemplate();

// Listar plantillas
$templates = $sms->getUserSmsTemplates();

// Crear plantilla
$sms->addUserSmsTemplate([
    'name' => 'Estado',
    'message' => 'STATUS#'
]);
```

## 🔧 Manejo de Errores

La biblioteca incluye manejo específico de errores:

```php
use Gpswox\Exceptions\ApiException;
use Gpswox\Exceptions\AuthenticationException;

try {
    $setup = $client->setup();
    $data = $setup->getEditSetupData();
} catch (AuthenticationException $e) {
    // Error de autenticación (401)
    echo "Error de autenticación: " . $e->getMessage();
} catch (ApiException $e) {
    // Otros errores de API
    echo "Error de API: " . $e->getMessage() . " (Código: " . $e->getCode() . ")";
}
```

## Desarrollo

### Ejecutar Tests

```bash
./vendor/bin/phpunit tests/
```

### Estructura del Proyecto

```
src/
├── Wox.php                    # Cliente principal
├── Resources/                 # Recursos de la API
│   ├── Setup.php             # Configuración de cuenta
│   ├── Device.php            # Gestión de dispositivos
│   └── History.php           # Historial de dispositivos
└── Exceptions/               # Excepciones personalizadas
    ├── ApiException.php
    ├── AuthenticationException.php
    └── ResourceNotFoundException.php
```

## API de Setup

### Métodos Disponibles

#### `getEditSetupData(string $lang = null, array $additionalParams = [])`

Obtiene todos los datos de configuración de la cuenta.

**Parámetros:**

- `$lang` (opcional): Código de idioma (ej: 'es', 'en')
- `$additionalParams` (opcional): Parámetros adicionales

**Retorna:** Array con datos completos de configuración incluyendo:

- `item`: Información del usuario
- `timezones`: Zonas horarias disponibles
- `units_of_distance`: Unidades de distancia (km, mi)
- `units_of_capacity`: Unidades de capacidad (lt, gl)
- `units_of_altitude`: Unidades de altitud (mt, ft)
- `groups`: Grupos del usuario
- `sms_queue_count`: Cantidad de SMS en cola
- Opciones de configuración de SMS Gateway
- Opciones de horario de verano (DST)

#### `updateSetupData(array $data)`

Actualiza la configuración de la cuenta.

**Parámetros:**

- `$data`: Array con los datos a actualizar

#### `getCurrentTimezone()`

Obtiene el timezone actualmente seleccionado por el usuario.

**Retorna:** Array con `id` y `value` del timezone actual, o `null` si no se encuentra

**Ejemplo:**

```php
$currentTimezone = $setup->getCurrentTimezone();
if ($currentTimezone) {
    echo "Timezone: {$currentTimezone['value']} (ID: {$currentTimezone['id']})";
    // Ejemplo: "Timezone: UTC +01:00 (ID: 65)"
}
```

#### Métodos de Conveniencia

- `getTimezones()`: Solo zonas horarias
- `getDistanceUnits()`: Solo unidades de distancia
- `getCapacityUnits()`: Solo unidades de capacidad
- `getAltitudeUnits()`: Solo unidades de altitud
- `getUserInfo()`: Solo información del usuario
- `getCurrentTimezone()`: Timezone actual del usuario (id y value)
- `getSmsGatewayOptions()`: Solo opciones de SMS Gateway
- `getDstOptions()`: Solo opciones de horario de verano

## Licencia

MIT License

## Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request
