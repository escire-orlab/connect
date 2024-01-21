<?php

namespace EscireOrlab\Connect\Services;

use EscireOrlab\Connect\Support\Traits\EncryptionTool;
use EscireOrlab\Connect\Helpers\ConfigHelper;
use Illuminate\Foundation\Auth\User;

class CreateConnectionService
{
    use EncryptionTool;

    public static $customCreateConnectCallback;

    public static function createCallback($request)
    {
        $connData = $request->connect_data;

        if (!$connData) {
            abort(403, 'No se ha recibido información de conexión.');
        }

        $connData = self::decrypt($connData, ConfigHelper::connectKey());

        if (!$connData) {
            abort(403, 'No se ha podido decodificar la información de conexión.');
        }

        $connData = json_decode($connData);

        // Primero ver si existe un usuario con el mismo connet_id
        $user = User::where('connect_id', $connData->connect_id)->first();

        if($user) {
            $user->connect_active = true;
            $user->save();
            return $user;
        }

        // Si no existe, ver si hay un usuari con el mismo email
        $user = User::where('email', $connData->email)->first();

        if($user) {
            $user->connect_id = $connData->connect_id;
            $user->connect_origin = $connData->connect_origin;
            $user->connect_active = true;
            $user->save();
            return $user;
        }

        // Si no existe, crear un usuario nuevo
        // Perimeramente se puede personalizar la creación del usuario
        if (self::$customCreateConnectCallback && is_callable(self::$customCreateConnectCallback)) {
            return call_user_func(self::$customCreateConnectCallback, $connData);
        }

        $user = new User();
        $user->name = $connData->name;
        $user->email = $connData->email;
        $user->password = bcrypt(md5($connData->email));
        $user->connect_id = $connData->connect_id;
        $user->connect_origin = $connData->connect_origin;
        $user->connect_active = true;
        $user->save();

        return $user;
    }
}