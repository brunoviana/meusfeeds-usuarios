<?php

namespace MeusFeeds\Usuarios\App\UseCases;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use MeusFeeds\Usuarios\App\Requests\AutenticarUsuarioRequest;
use MeusFeeds\Usuarios\App\Responses\AutenticarUsuarioResponse;

use MeusFeeds\Usuarios\Domain\Interfaces\ListaDeConvitesInterface;
use MeusFeeds\Usuarios\App\Exceptions\UsuarioNaoAutenticadoException;
use MeusFeeds\Usuarios\Domain\Repositories\UsuarioRepositoryInterface;

class AutenticarUsuario
{
    private $request;

    private $listaDeConvites;

    private $usuarioRepository;

    public function __construct(
        AutenticarUsuarioRequest $request,
        UsuarioRepositoryInterface $usuarioRepository,
        ListaDeConvitesInterface $listaDeConvites
    ) {
        $this->request = $request;
        $this->usuarioRepository = $usuarioRepository;
        $this->listaDeConvites = $listaDeConvites;
    }

    public function executar()
    {
        $nome = $this->request->nome();
        $email = $this->request->email();

        $usuario = $this->usuarioRepository->buscarPeloEmail($email);

        if ($usuario) {
            return $this->responder($usuario);
        }

        if (!$this->listaDeConvites->emailExisteNaLista($email)) {
            throw new UsuarioNaoAutenticadoException('Usuário não tem permissão para acessar');
        }

        $usuario = new Usuario($nome, $email);

        $this->usuarioRepository->salvar($usuario);

        return $this->responder($usuario);
    }

    public function responder(Usuario $usuario)
    {
        return new AutenticarUsuarioResponse($usuario);
    }
}
