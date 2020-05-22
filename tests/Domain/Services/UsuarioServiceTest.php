<?php

namespace MeusFeeds\Usuarios\Tests\Domain\Services;

use MeusFeeds\Usuarios\Tests\TestCase;
use MeusFeeds\Usuarios\Domain\Entities\Usuario;
use MeusFeeds\Usuarios\Domain\Services\UsuarioService;
use MeusFeeds\Usuarios\Domain\Exceptions\EmailNaoPermitidoExcetion;
use MeusFeeds\Usuarios\Tests\TestAdapters\Domain\UsuarioRepositoryFake;
use MeusFeeds\Usuarios\Tests\TestAdapters\Domain\ConsultorDePermissoesFake;

class UsuarioServiceTest extends TestCase
{
    protected $usuarioRepositoryFake;

    protected $consultorDePermissoesFake;

    public function setUp() : void
    {
        $this->usuarioRepositoryFake = new UsuarioRepositoryFake();
        $this->consultorDePermissoesFake = new ConsultorDePermissoesFake();
    }

    public function test_Deve_Cadastrar_Usuario_Com_Sucesso()
    {
        $usuarioService = new UsuarioService();

        $usuarioService->setUsuarioRepository($this->usuarioRepositoryFake);
        $usuarioService->setConsultorDePermissoes($this->consultorDePermissoesFake);

        $usuario = $usuarioService->autenticaOuCriaUsuario(
            'Bruno Viana Arruda',
            'brunoviana@gmail.com'
        );

        $this->assertInstanceOf(Usuario::class, $usuario);
        $this->assertEquals(1, $usuario->id());
        $this->assertEquals('Bruno Viana Arruda', $usuario->nome());
        $this->assertEquals('brunoviana@gmail.com', $usuario->email());
    }

    public function test_Deve_Retornar_Usuario_Ja_Existente()
    {
        $usuarioService = new UsuarioService();

        $usuarioService->setUsuarioRepository($this->usuarioRepositoryFake);
        $usuarioService->setConsultorDePermissoes($this->consultorDePermissoesFake);

        $usuarioService->autenticaOuCriaUsuario(
            'Bruno Viana Arruda',
            'brunoviana@gmail.com'
        );

        $usuario = $usuarioService->autenticaOuCriaUsuario(
            'Bruno Viana Arruda',
            'brunoviana@gmail.com'
        );

        $this->assertInstanceOf(Usuario::class, $usuario);
        $this->assertEquals(1, $usuario->id());
        $this->assertEquals('Bruno Viana Arruda', $usuario->nome());
        $this->assertEquals('brunoviana@gmail.com', $usuario->email());

        $this->assertEquals(
            2,
            $this->usuarioRepositoryFake->qtdChamadasDeMetodo('buscarPeloEmail')
        );

        $this->assertEquals(
            1,
            $this->usuarioRepositoryFake->qtdChamadasDeMetodo('salvar')
        );
    }

    public function test_Deve_Falhar_Se_Usuario_Nao_Tiver_Permissao()
    {
        $this->expectException(EmailNaoPermitidoExcetion::class);
        $this->expectExceptionMessage('Email do usuário não tem permissão para fazer login.');

        $usuarioService = new UsuarioService();

        $usuarioService->setUsuarioRepository($this->usuarioRepositoryFake);
        $usuarioService->setConsultorDePermissoes($this->consultorDePermissoesFake);

        $usuarioService->autenticaOuCriaUsuario(
            'Usuário Não Permitido',
            'usuario.nao.permitido@gmail.com'
        );
    }
    // falhar se usuario não tiver permissão
}
