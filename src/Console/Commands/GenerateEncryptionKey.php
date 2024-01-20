<?php

namespace EscireOrlab\Connect\Console\Commands;

use Illuminate\Console\Command;

class GenerateEncryptionKey extends Command
{
    protected $signature = 'connect:key';

    protected $description = 'Genera una clave de encriptación segura para el uso en la encriptación AES-256-CBC';

    public function handle()
    {
        $key = base64_encode(random_bytes(32)); // AES-256-CBC espera una clave de 32 bytes
        $this->info("Clave de encriptación: {$key}");
    }
}
