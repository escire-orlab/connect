<?php

namespace EscireOrlab\Connect\Helpers;

use EscireOrlab\Connect\Support\Traits\EncryptionTool;

class ConfigHelper
{
    use EncryptionTool;

    public static $customConnectUrl;

    public static function connectKey()
    {
        $connectKey = config('orlab-connect.connect_key');
        return substr(hash('sha256', "$connectKey", true), 0, 32);
    }

    public static function connectSites()
    {
        return config('orlab-connect.connect_sites');
    }

    public static function connectData()
    {
        if (!auth()->check()) {
            return null;
        }

        if(auth()->user()->connect_id == null) {
            auth()->user()->connect_id = md5(auth()->user()->email);
            auth()->user()->connect_origin = request()->getHost();
            auth()->user()->connect_active = true;
            auth()->user()->save();
        }

        /**
         * En este apartado se puede personalizar la información que se envía a los sitios conectados 
         * con la app actual.
         * Es necesario que en la petición se envíe por lo menos
         *  - email
         *  - connect_id
         *  - connect_origin
         *  - name
         */
        $data = null;
        if (self::$customConnectUrl && is_callable(self::$customConnectUrl)) {
            $data = call_user_func(self::$customConnectUrl, auth()->user());
        }

        return self::encrypt($data ?? auth()->user()->toJson(), self::connectKey());
    }

    public static function createConnectUrl($request)
    {
        $redirectUrl = $request->redirect_url;
        $redirectPath = config('orlab-connect.redirect_path');
        $connectData = self::connectData();
        return "{$redirectUrl}/orlab/connect/create/callback?connect_data={$connectData}&path={$redirectPath}";
    }

}
