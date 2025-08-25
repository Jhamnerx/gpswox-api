# GPSWox API PHP Client

Una biblioteca PHP para interactuar con la API de GPSWox, un sistema de rastreo GPS.

## Instalación

```bash
composer require gpswox/api-client
```

## Uso Básico

### Inicialización

```php
use Gpswox\Wox;

// Con API hash existente
$client = new Wox('https://tu-dominio-gpswox.com/', 'tu-api-hash');

// O hacer login para obtener el API hash
$client = new Wox('https://tu-dominio-gpswox.com/');
$apiHash = $client->login('tu-email@ejemplo.com', 'tu-contraseña');
```

## Recursos Disponibles

### Setup (Configuración)

El recurso Setup permite gestionar la configuración de la cuenta de usuario.

```php
$setup = $client->setup();

// Obtener datos completos de configuración
$setupData = $setup->getEditSetupData();

// Obtener datos con idioma específico
$setupData = $setup->getEditSetupData('es');

// Actualizar configuración
$setup->updateSetupData([
    'lang' => 'es',
    'unit_of_distance' => 'km',
    'unit_of_capacity' => 'lt',
    'timezone_id' => '65'
]);

// Obtener solo zonas horarias
$timezones = $setup->getTimezones();

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
```

### Device (Dispositivos)

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
$device->editDevice(1, [
    'name' => 'Dispositivo Actualizado'
]);

// Eliminar dispositivo
$device->destroyDevice(1);
```

### History (Historial)

```php
$history = $client->history();

// Obtener historial de un dispositivo
$historyData = $history->getHistory(
    1, // device_id
    '2023-01-01 00:00:00', // from
    '2023-01-31 23:59:59'  // to
);

// Obtener mensajes del historial
$messages = $history->getHistoryMessages(
    1, // device_id
    '2023-01-01 00:00:00', // from
    '2023-01-31 23:59:59'  // to
);

// Eliminar posiciones del historial
$history->deleteHistoryPositions(
    1, // device_id
    '2023-01-01 00:00:00', // from
    '2023-01-31 23:59:59', // to
    false // all
);
```

## Manejo de Errores

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
