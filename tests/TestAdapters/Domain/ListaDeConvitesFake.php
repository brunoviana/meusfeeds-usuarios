<?php

namespace MeusFeeds\Usuarios\Tests\TestAdapters\Domain;

use MeusFeeds\Usuarios\Domain\Interfaces\ListaDeConvitesInterface;

class ListaDeConvitesFake implements ListaDeConvitesInterface
{
    private $emails = [];

    public function colocarEmailNaLista(string $email)
    {
        $this->emails[] = $email;
    }

    public function emailExisteNaLista(string $email) : bool
    {
        foreach ($this->emails as $emailNaLista) {
            if ($emailNaLista == $email) {
                return true;
            }
        }

        return false;
    }
}
