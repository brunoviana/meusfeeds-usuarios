<?php

namespace MeusFeeds\Usuarios\Tests\App\UseCases;

use MeusFeeds\Usuarios\Tests\TestCase;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use MeusFeeds\Usuarios\App\UseCases\AutenticarUsuario;
use MeusFeeds\Usuarios\App\Requests\AutenticarUsuarioRequest;
use MeusFeeds\Usuarios\App\Responses\AutenticarUsuarioResponse;
use MeusFeeds\Usuarios\App\Exceptions\UsuarioNaoAutenticadoException;

use MeusFeeds\Usuarios\Tests\TestAdapters\Domain\UsuarioRepositoryFake;
use MeusFeeds\Usuarios\Tests\TestAdapters\Domain\ListaDeConvitesFake;

class AutenticarUsuarioTest extends TestCase
{
    protected $usuarioRepositoryFake;

    protected $listaDeConvitesFake;

    public function setUp() : void
    {
        $this->usuarioRepositoryFake = new UsuarioRepositoryFake();
        $this->listaDeConvitesFake = new ListaDeConvitesFake();
    }

    public function test_Deve_Autenticar_Usuario_Existente_Com_Sucesso()
    {
        $this->usuarioRepositoryFake->salvar(
            new Usuario('Bruno Viana', 'brunoviana@gmail.com')
        );

        $autenticarUsuario = new AutenticarUsuario(
            new AutenticarUsuarioRequest(
                'Bruno Viana',
                'brunoviana@gmail.com'
            ),
            $this->usuarioRepositoryFake,
            $this->listaDeConvitesFake
        );

        $resposta = $autenticarUsuario->executar();

        $this->assertInstanceOf(AutenticarUsuarioResponse::class, $resposta);
        $this->assertInstanceOf(Usuario::class, $resposta->usuario());
        $this->assertEquals(1, $resposta->usuario()->id());
        $this->assertEquals('Bruno Viana', $resposta->usuario()->nome());
        $this->assertEquals('brunoviana@gmail.com', $resposta->usuario()->email());
    }

    public function test_Deve_Autenticar_Usuario_Que_Foi_Convidado_Com_Sucesso()
    {
        $this->listaDeConvitesFake->colocarEmailNaLista('brunoviana@gmail.com');

        $autenticarUsuario = new AutenticarUsuario(
            new AutenticarUsuarioRequest(
                'Bruno Viana',
                'brunoviana@gmail.com'
            ),
            $this->usuarioRepositoryFake,
            $this->listaDeConvitesFake
        );

        $resposta = $autenticarUsuario->executar();

        $this->assertInstanceOf(AutenticarUsuarioResponse::class, $resposta);
        $this->assertInstanceOf(Usuario::class, $resposta->usuario());
        $this->assertEquals(1, $resposta->usuario()->id());
        $this->assertEquals('Bruno Viana', $resposta->usuario()->nome());
        $this->assertEquals('brunoviana@gmail.com', $resposta->usuario()->email());
    }

    public function test_Deve_Falhar_Caso_Usuario_Nao_Existe_E_Nao_Foi_Convidado()
    {
        $this->expectException(UsuarioNaoAutenticadoException::class);
        $this->expectExceptionMessage('Usuário não tem permissão para acessar');

        $autenticarUsuario = new AutenticarUsuario(
            new AutenticarUsuarioRequest(
                'Bruno Viana',
                'brunoviana@gmail.com'
            ),
            $this->usuarioRepositoryFake,
            $this->listaDeConvitesFake
        );

        $autenticarUsuario->executar();
    }
}
