<?php

namespace MeusFeeds\Usuarios\Domain\Interfaces;

interface ListaDeConvitesInterface
{
    public function emailExisteNaLista(string $email) : bool;
}
