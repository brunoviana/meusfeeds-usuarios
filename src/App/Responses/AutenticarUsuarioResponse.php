<?php

namespace MeusFeeds\Usuarios\App\Responses;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;

class AutenticarUsuarioResponse
{
    private Usuario $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function usuario()
    {
        return $this->usuario;
    }
}
