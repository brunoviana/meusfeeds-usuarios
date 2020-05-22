<?php

namespace MeusFeeds\Usuarios\App\UseCases;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use MeusFeeds\Usuarios\Domain\Services\UsuarioService;
use MeusFeeds\Usuarios\App\Requests\AutenticarUsuarioRequest;
use MeusFeeds\Usuarios\App\Responses\AutenticarUsuarioResponse;

use MeusFeeds\Usuarios\Domain\Repositories\UsuarioRepositoryInterface;
use MeusFeeds\Usuarios\Domain\Interfaces\ConsultorDePermissoesInterface;

class AutenticarUsuario
{
    private $request;

    private $consultorDePermissoes;

    private $usuarioRepository;

    public function __construct(
        AutenticarUsuarioRequest $request,
        UsuarioRepositoryInterface $usuarioRepository,
        ConsultorDePermissoesInterface $consultorDePermissoes
    ) {
        $this->request = $request;
        $this->usuarioRepository = $usuarioRepository;
        $this->consultorDePermissoes = $consultorDePermissoes;
    }

    public function executar()
    {
        $usuario = $this->autenticar();

        return $this->responder($usuario);
    }

    public function autenticar()
    {
        $usuarioService = new UsuarioService();

        $usuarioService->setUsuarioRepository($this->usuarioRepository);
        $usuarioService->setConsultorDePermissoes($this->consultorDePermissoes);

        return $usuarioService->autenticaOuCriaUsuario(
            $this->request->nome(),
            $this->request->email()
        );
    }

    public function responder(Usuario $usuario)
    {
        return new AutenticarUsuarioResponse($usuario);
    }
}
