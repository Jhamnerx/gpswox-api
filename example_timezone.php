<?php

/**
 * Ejemplo específico para el método getCurrentTimezone()
 * Muestra cómo obtener el timezone actual del usuario
 */

require_once 'vendor/autoload.php';

use Gpswox\Wox;
use Gpswox\Exceptions\ApiException;
use Gpswox\Exceptions\AuthenticationException;

try {
    // Inicializar cliente
    $client = new Wox('https://your-gpswox-domain.com/', 'your-api-hash');

    // Obtener recurso Setup
    $setup = $client->setup();

    // Obtener timezone actual del usuario
    echo "=== Timezone Actual del Usuario ===\n";

    $currentTimezone = $setup->getCurrentTimezone();

    if ($currentTimezone) {
        echo "✅ Timezone encontrado:\n";
        echo "   ID: " . $currentTimezone['id'] . "\n";
        echo "   Valor: " . $currentTimezone['value'] . "\n";
        echo "   Ejemplo de uso: Usuario configurado con timezone '{$currentTimezone['value']}'\n";
    } else {
        echo "❌ No se encontró timezone configurado para el usuario\n";
        echo "   Posibles causas:\n";
        echo "   - El usuario no tiene timezone_id definido\n";
        echo "   - El timezone_id no existe en la lista de timezones disponibles\n";
    }

    // Información adicional del usuario
    echo "\n=== Información Relacionada ===\n";

    $userInfo = $setup->getUserInfo();
    echo "Usuario ID: " . ($userInfo['id'] ?? 'N/A') . "\n";
    echo "Email: " . ($userInfo['email'] ?? 'N/A') . "\n";
    echo "Timezone ID configurado: " . ($userInfo['timezone_id'] ?? 'No configurado') . "\n";

    // Mostrar algunos timezones disponibles
    echo "\n=== Timezones Disponibles (primeros 5) ===\n";
    $timezones = $setup->getTimezones();
    foreach (array_slice($timezones, 0, 5) as $timezone) {
        $marker = ($currentTimezone && $timezone['id'] == $currentTimezone['id']) ? '👉 ' : '   ';
        echo "{$marker}ID: {$timezone['id']} - {$timezone['value']}\n";
    }

    echo "\n=== Ejemplo de Cambio de Timezone ===\n";
    echo "Para cambiar el timezone del usuario, usar:\n";
    echo '$setup->updateSetupData([' . "\n";
    echo '    "timezone_id" => "65"  // ID del nuevo timezone' . "\n";
    echo ']);' . "\n";
} catch (AuthenticationException $e) {
    echo "❌ Error de autenticación: " . $e->getMessage() . "\n";
} catch (ApiException $e) {
    echo "❌ Error de API: " . $e->getMessage() . " (Código: " . $e->getCode() . ")\n";
} catch (Exception $e) {
    echo "❌ Error general: " . $e->getMessage() . "\n";
}
