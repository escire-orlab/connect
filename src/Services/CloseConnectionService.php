<?php

namespace EscireOrlab\Connect\Services;

use EscireOrlab\Connect\Support\Traits\EncryptionTool;
use EscireOrlab\Connect\Helpers\ConfigHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Log;

class CloseConnectionService
{
    use EncryptionTool;

    /**
     * Cierra las conexiones con los sitios conectados.
     */
    public static function close()
    {
        $connectedSites = ConfigHelper::connectSites();

        foreach ($connectedSites as $key => $site) {
            try {
                $response = self::closeConnection($site);
                // Considera loguear la respuesta o manejarla según sea necesario
            } catch (\Exception $e) {
                // Aquí deberías manejar la excepción, como loguear el error
                Log::error("Error al cerrar conexión con {$site}: " . $e->getMessage());
            }
        }
    }

    /**
     * Realiza la petición de cierre de conexión a un sitio específico.
     */
    private static function closeConnection($site, $protocol = 'http')
    {
        $url = "{$protocol}://{$site}/orlab/connect/close/callback";
        $token = self::createToken($site);
    
        $maxRetries = 2;
        $attempt = 0;
    
        while ($attempt <= $maxRetries) {
            try {
                $response = Http::post($url, ['token' => $token]);
    
                if ($response->successful()) {
                    return $response->json();
                } else {
                    throw new \Exception("La petición al sitio {$site} no fue exitosa.");
                }
            } catch (\Exception $e) {
                $attempt++;
                Log::warning("Intento {$attempt} fallido al cerrar conexión con {$site}: " . $e->getMessage());
    
                if ($attempt > $maxRetries) {
                    Log::error("Error después de {$maxRetries} intentos al cerrar conexión con {$site}.");
                    break; // Salir del bucle si se alcanza el número máximo de intentos
                }
            }
        }
    }    

    /**
     * Crea un token de seguridad para la petición.
     */
    private static function createToken($site)
    {
        $user = auth()->user();
        $token = "{$user->connect_id}:{$user->connect_origin}";
        return self::encrypt($token, ConfigHelper::connectKey());
    }

    /**
     * Callback para cerrar la conexión.
     */
    public static function closeCallback($token)
    {
        try {
            $user = self::getUserByToken($token);
            if ($user) {
                $user->connect_active = false;
                $user->save();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            // Manejo del error, como loguear o enviar una alerta
            Log::error("Error en closeCallback: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene un usuario a partir de un token.
     */
    private static function getUserByToken($token)
    {
        try {
            $token = self::decrypt($token, ConfigHelper::connectKey());
            $tokenParts = explode(':', $token);

            return User::where('connect_id', $tokenParts[0])->first();
        } catch (\Exception $e) {
            // Manejo del error
            Log::error("Error al desencriptar token: " . $e->getMessage());
            return null;
        }
    }
}
