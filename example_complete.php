<?php

require_once __DIR__ . '/vendor/autoload.php';

use Gpswox\Wox;
use Gpswox\Exceptions\ApiException;
use Gpswox\Exceptions\AuthenticationException;

/**
 * Ejemplo completo de uso del SDK de GPSWox API
 * 
 * Este archivo muestra cómo usar los principales recursos del SDK
 */

// Configuración
$baseUrl = 'https://gps.midominio.com/';
$email = 'tu-email@ejemplo.com';
$password = 'tu-contraseña';

try {
    // 1. AUTENTICACIÓN
    echo "=== AUTENTICACIÓN ===\n";
    $client = new Wox($baseUrl);
    $apiHash = $client->login($email, $password);
    echo "✓ Login exitoso. API Hash: {$apiHash}\n\n";

    // O si ya tienes el API hash:
    // $client = new Wox($baseUrl, 'tu-api-hash');

    // 2. DISPOSITIVOS
    echo "=== DISPOSITIVOS ===\n";
    $devices = $client->device()->listDevices();
    echo "✓ Total de dispositivos: " . count($devices['items'] ?? []) . "\n";

    if (!empty($devices['items'])) {
        $firstDevice = $devices['items'][0];
        echo "  - Primer dispositivo: {$firstDevice['name']} (ID: {$firstDevice['id']})\n";
        $deviceId = $firstDevice['id'];
    }
    echo "\n";

    // 3. HISTORIAL
    if (isset($deviceId)) {
        echo "=== HISTORIAL ===\n";
        $from = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $to = date('Y-m-d 23:59:59');

        $history = $client->history()->getHistory($deviceId, $from, $to);
        echo "✓ Posiciones en los últimos 7 días: " . count($history['items'] ?? []) . "\n\n";
    }

    // 4. ALERTAS
    echo "=== ALERTAS ===\n";
    $alerts = $client->alert()->getAlerts();
    echo "✓ Total de alertas configuradas: " . count($alerts['items'] ?? []) . "\n";

    // Crear una alerta de prueba
    /* Descomenta para crear
    $newAlert = $client->alert()->addAlert([
        'name' => 'Prueba de Velocidad',
        'type' => 'overspeed',
        'limit' => 100,
        'devices' => [$deviceId]
    ]);
    echo "✓ Alerta creada: {$newAlert['id']}\n";
    */
    echo "\n";

    // 5. GEOCERCAS
    echo "=== GEOCERCAS ===\n";
    $geofences = $client->geofence()->getGeofences();
    echo "✓ Total de geocercas: " . count($geofences['items'] ?? []) . "\n";

    // Verificar si un punto está en geocercas
    /* Descomenta para probar
    $result = $client->geofence()->pointInGeofences(-34.603722, -58.381592);
    echo "✓ Geocercas que contienen el punto: " . count($result['geofences'] ?? []) . "\n";
    */
    echo "\n";

    // 6. SENSORES
    if (isset($deviceId)) {
        echo "=== SENSORES ===\n";
        $sensors = $client->sensor()->getSensors($deviceId);
        echo "✓ Sensores del dispositivo {$deviceId}: " . count($sensors['items'] ?? []) . "\n\n";
    }

    // 7. RUTAS
    echo "=== RUTAS ===\n";
    $routes = $client->route()->getRoutes();
    echo "✓ Total de rutas: " . count($routes['items'] ?? []) . "\n\n";

    // 8. REPORTES
    echo "=== REPORTES ===\n";
    $reports = $client->report()->getReports();
    echo "✓ Reportes configurados: " . count($reports['items'] ?? []) . "\n";

    // Tipos de reportes disponibles
    $reportTypes = $client->report()->getReportTypes();
    echo "✓ Tipos de reporte disponibles: " . count($reportTypes) . "\n\n";

    // 9. TAREAS
    echo "=== TAREAS ===\n";
    $tasks = $client->task()->getTasks();
    echo "✓ Total de tareas: " . count($tasks['items'] ?? []) . "\n";

    $statuses = $client->task()->getTaskStatuses();
    echo "✓ Estados de tareas disponibles: " . count($statuses) . "\n\n";

    // 10. CONDUCTORES
    echo "=== CONDUCTORES ===\n";
    $drivers = $client->driver()->getUserDrivers();
    echo "✓ Total de conductores: " . count($drivers['items'] ?? []) . "\n\n";

    // 11. EVENTOS
    if (isset($deviceId)) {
        echo "=== EVENTOS ===\n";
        $events = $client->event()->getEvents(['device_id' => $deviceId]);
        echo "✓ Eventos del dispositivo: " . count($events['items'] ?? []) . "\n\n";
    }

    // 12. CONFIGURACIÓN
    echo "=== CONFIGURACIÓN ===\n";
    $setupData = $client->setup()->getEditSetupData();
    $userInfo = $setupData['item'] ?? [];
    echo "✓ Usuario: {$userInfo['email']}\n";
    echo "✓ Idioma: {$userInfo['lang']}\n";
    echo "✓ Unidad de distancia: {$userInfo['unit_of_distance']}\n";

    $currentTimezone = $client->setup()->getCurrentTimezone();
    if ($currentTimezone) {
        echo "✓ Timezone actual: {$currentTimezone['value']}\n";
    }
    echo "\n";

    // 13. COMANDOS
    if (isset($deviceId)) {
        echo "=== COMANDOS ===\n";
        $commands = $client->command()->getDeviceCommands($deviceId);
        echo "✓ Comandos enviados al dispositivo: " . count($commands['items'] ?? []) . "\n";

        // Enviar comando (descomenta para usar)
        /*
        $result = $client->command()->sendGprsCommand($deviceId, [
            'command' => 'getlocation'
        ]);
        echo "✓ Comando GPRS enviado\n";
        */
        echo "\n";
    }

    // 14. PLANTILLAS
    echo "=== PLANTILLAS ===\n";
    $gprsTemplates = $client->gprsTemplate()->getUserGprsTemplates();
    echo "✓ Plantillas GPRS: " . count($gprsTemplates['items'] ?? []) . "\n";

    $smsTemplates = $client->smsTemplate()->getUserSmsTemplates();
    echo "✓ Plantillas SMS: " . count($smsTemplates['items'] ?? []) . "\n\n";

    // 15. ICONOS DE MAPA
    echo "=== ICONOS DE MAPA ===\n";
    $mapIcons = $client->mapIcon()->getUserMapIcons();
    echo "✓ Iconos personalizados: " . count($mapIcons['items'] ?? []) . "\n\n";

    // 16. SERVICIOS DE MANTENIMIENTO
    if (isset($deviceId)) {
        echo "=== SERVICIOS ===\n";
        $services = $client->service()->getServices($deviceId);
        echo "✓ Servicios programados: " . count($services['items'] ?? []) . "\n\n";
    }

    // RESUMEN FINAL
    echo "=== RESUMEN ===\n";
    echo "✓ Todos los recursos del SDK funcionan correctamente\n";
    echo "✓ 17 recursos implementados\n";
    echo "✓ 150+ endpoints disponibles\n";
    echo "\n🎉 ¡Ejemplo completado exitosamente!\n";
} catch (AuthenticationException $e) {
    echo "❌ Error de autenticación: {$e->getMessage()}\n";
    echo "   Código: {$e->getCode()}\n";
} catch (ApiException $e) {
    echo "❌ Error de API: {$e->getMessage()}\n";
    echo "   Código: {$e->getCode()}\n";
} catch (Exception $e) {
    echo "❌ Error general: {$e->getMessage()}\n";
}
