<?php

namespace MeusFeeds\Usuarios\Domain\Interfaces;

interface ConsultorDePermissoesInterface
{
    public function usuarioPodeSeAutenticar(string $email) : bool;
}
