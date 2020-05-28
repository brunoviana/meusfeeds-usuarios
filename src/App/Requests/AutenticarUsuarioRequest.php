<?php

namespace MeusFeeds\Usuarios\App\Requests;

class AutenticarUsuarioRequest
{
    private string $nome;

    private string $email;

    private string $foto;

    public function __construct(string $nome, string $email, string $foto = '')
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->foto = $foto;
    }

    public function nome()
    {
        return $this->nome;
    }

    public function email()
    {
        return $this->email;
    }

    public function foto()
    {
        return $this->foto;
    }
}
