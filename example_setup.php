<?php

/**
 * Ejemplo de uso del recurso Setup
 * Este archivo muestra cómo utilizar el recurso Setup para gestionar
 * la configuración de la cuenta.
 */

require_once 'vendor/autoload.php';

use Gpswox\Wox;
use Gpswox\Exceptions\ApiException;
use Gpswox\Exceptions\AuthenticationException;

// Configuración
$baseUri = 'https://your-gpswox-domain.com/';
$apiHash = 'your-api-hash'; // O null si vas a hacer login

try {
    // Crear instancia del cliente
    $client = new Wox($baseUri, $apiHash);

    // Si no tienes API hash, puedes hacer login
    if (!$apiHash) {
        $apiHash = $client->login('your-email@example.com', 'your-password');
        echo "Login exitoso. API Hash: $apiHash\n";
    }

    // Obtener instancia del recurso Setup
    $setup = $client->setup();

    // 1. Obtener datos completos de configuración
    echo "=== Obteniendo datos de configuración ===\n";
    $setupData = $setup->getEditSetupData();
    echo "Usuario ID: " . $setupData['item']['id'] . "\n";
    echo "Email: " . $setupData['item']['email'] . "\n";
    echo "Idioma: " . $setupData['item']['lang'] . "\n";
    echo "Zona horaria: " . $setupData['item']['timezone_id'] . "\n";

    // 2. Obtener solo zonas horarias disponibles
    echo "\n=== Zonas horarias disponibles ===\n";
    $timezones = $setup->getTimezones();
    foreach (array_slice($timezones, 0, 5) as $timezone) {
        echo "ID: {$timezone['id']} - {$timezone['value']}\n";
    }

    // 3. Obtener unidades de distancia
    echo "\n=== Unidades de distancia ===\n";
    $distanceUnits = $setup->getDistanceUnits();
    foreach ($distanceUnits as $unit) {
        echo "ID: {$unit['id']} - {$unit['value']}\n";
    }

    // 4. Obtener unidades de capacidad
    echo "\n=== Unidades de capacidad ===\n";
    $capacityUnits = $setup->getCapacityUnits();
    foreach ($capacityUnits as $unit) {
        echo "ID: {$unit['id']} - {$unit['value']}\n";
    }

    // 5. Obtener unidades de altitud
    echo "\n=== Unidades de altitud ===\n";
    $altitudeUnits = $setup->getAltitudeUnits();
    foreach ($altitudeUnits as $unit) {
        echo "ID: {$unit['id']} - {$unit['value']}\n";
    }

    // 6. Obtener opciones de SMS Gateway
    echo "\n=== Opciones de SMS Gateway ===\n";
    $smsOptions = $setup->getSmsGatewayOptions();
    echo "Métodos de request disponibles:\n";
    foreach ($smsOptions['request_methods'] as $method) {
        echo "  - {$method['id']}: {$method['value']}\n";
    }

    // 7. Obtener información del usuario
    echo "\n=== Información del usuario ===\n";
    $userInfo = $setup->getUserInfo();
    echo "ID: " . $userInfo['id'] . "\n";
    echo "Email: " . $userInfo['email'] . "\n";
    echo "Activo: " . ($userInfo['active'] ? 'Sí' : 'No') . "\n";
    echo "Creado: " . $userInfo['created_at'] . "\n";
    echo "Actualizado: " . $userInfo['updated_at'] . "\n";

    // 8. Obtener timezone actual del usuario
    echo "\n=== Timezone actual del usuario ===\n";
    $currentTimezone = $setup->getCurrentTimezone();
    if ($currentTimezone) {
        echo "ID: " . $currentTimezone['id'] . "\n";
        echo "Valor: " . $currentTimezone['value'] . "\n";
    } else {
        echo "No se encontró timezone configurado\n";
    }

    // 9. Actualizar configuración (ejemplo)
    echo "\n=== Actualizando configuración ===\n";
    $updateData = [
        'lang' => 'es',
        'unit_of_distance' => 'km',
        'unit_of_capacity' => 'lt',
        'unit_of_altitude' => 'mt'
    ];

    // Descomenta la siguiente línea para ejecutar la actualización
    // $updateResponse = $setup->updateSetupData($updateData);
    // echo "Configuración actualizada exitosamente\n";

} catch (AuthenticationException $e) {
    echo "Error de autenticación: " . $e->getMessage() . "\n";
} catch (ApiException $e) {
    echo "Error de API: " . $e->getMessage() . " (Código: " . $e->getCode() . ")\n";
} catch (Exception $e) {
    echo "Error general: " . $e->getMessage() . "\n";
}
