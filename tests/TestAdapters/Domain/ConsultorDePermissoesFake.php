<?php

namespace MeusFeeds\Usuarios\Tests\TestAdapters\Domain;

use MeusFeeds\Usuarios\Domain\Interfaces\ConsultorDePermissoesInterface;

class ConsultorDePermissoesFake implements ConsultorDePermissoesInterface
{
    public function usuarioPodeSeAutenticar(string $email) : bool
    {
        if ($email == 'usuario.nao.permitido@gmail.com') {
            return false;
        }

        return true;
    }
}
