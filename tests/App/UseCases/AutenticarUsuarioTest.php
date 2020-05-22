<?php

namespace MeusFeeds\Usuarios\Tests\App\UseCases;

use MeusFeeds\Usuarios\Tests\TestCase;

use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use MeusFeeds\Usuarios\App\UseCases\AutenticarUsuario;
use MeusFeeds\Usuarios\App\Requests\AutenticarUsuarioRequest;
use MeusFeeds\Usuarios\App\Responses\AutenticarUsuarioResponse;

use MeusFeeds\Usuarios\Tests\TestAdapters\Domain\UsuarioRepositoryFake;
use MeusFeeds\Usuarios\Tests\TestAdapters\Domain\ConsultorDePermissoesFake;

class AutenticarUsuarioTest extends TestCase
{
    protected $usuarioRepositoryFake;

    protected $consultorDePermissoesFake;

    public function setUp() : void
    {
        $this->usuarioRepositoryFake = new UsuarioRepositoryFake();
        $this->consultorDePermissoesFake = new ConsultorDePermissoesFake();
    }

    public function test_Deve_Autenticar_Usuario_Com_Sucesso()
    {
        $autenticarUsuario = new AutenticarUsuario(
            new AutenticarUsuarioRequest(
                'Bruno Viana',
                'brunoviana@gmail.com'
            ),
            $this->usuarioRepositoryFake,
            $this->consultorDePermissoesFake
        );

        $resposta = $autenticarUsuario->executar();

        $this->assertInstanceOf(AutenticarUsuarioResponse::class, $resposta);
        $this->assertInstanceOf(Usuario::class, $resposta->usuario());
        $this->assertEquals(1, $resposta->usuario()->id());
        $this->assertEquals('Bruno Viana', $resposta->usuario()->nome());
        $this->assertEquals('brunoviana@gmail.com', $resposta->usuario()->email());
    }
}
