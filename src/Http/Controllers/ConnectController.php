<?php

namespace EscireOrlab\Connect\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use EscireOrlab\Connect\Helpers\ConfigHelper;
use EscireOrlab\Connect\Services\CreateConnectionService;
use EscireOrlab\Connect\Services\CloseConnectionService;

class ConnectController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->only('create');   
    }

    public function create(Request $request)
    {
        return Redirect::to(ConfigHelper::createConnectUrl($request));
    }

    public function createCallback(Request $request)
    {
        try {
            $user = CreateConnectionService::createCallback($request);
            auth()->login($user);
            return redirect($request->path ?? '/');
        } catch(\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function close(Request $request)
    {
        CloseConnectionService::close();
        auth()->user()->connect_active = false;
        auth()->user()->save();
        auth()->logout();
        return redirect('/');
    }

    public function closeCallback(Request $request)
    {
        try {
            CloseConnectionService::closeCallback($request->token);
            return response()->json(['message' => 'Conexión cerrada correctamente']);
        } catch(\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

}
