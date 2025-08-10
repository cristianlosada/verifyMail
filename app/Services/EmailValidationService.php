<?php

namespace App\Services;

class EmailValidationService
{
    public function validate(string $email): array
    {
        // 1) Formato (ya lo valida el Request, pero por si usas este servicio aparte)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['is_valid' => false, 'reason' => 'invalid_format', 'meta' => null];
        }

        // 2) DNS MX
        $domain = substr(strrchr($email, "@"), 1);
        $hasMx = $domain && checkdnsrr($domain, 'MX');

        if (!$hasMx) {
            return ['is_valid' => false, 'reason' => 'no_mx', 'meta' => ['domain' => $domain]];
        }

        // 3) (Opcional) SMTP handshake — pendiente/experimental
        // Aquí podrías intentar conexión SMTP para RCPT TO (requiere manejo cuidadoso).

        return ['is_valid' => true, 'reason' => null, 'meta' => ['domain' => $domain, 'mx_checked' => true]];
    }
}
