# Módulo de Usuários | Meus Feeds


![CircleCI](https://img.shields.io/circleci/build/github/brunoviana/meusfeeds-usuarios/master)
[![codecov](https://codecov.io/gh/brunoviana/meusfeeds-usuarios/branch/master/graph/badge.svg)](https://codecov.io/gh/brunoviana/meusfeeds-usuarios)
![Version](https://img.shields.io/github/v/release/brunoviana/meusfeeds-usuarios)

Este pacote é a implementação de todo o domínio e dos casos de uso referentes ao contexto de `Usuários` do [Meus Feeds](https://github.com/brunoviana/meusfeeds-laravel).

## Casos de Uso

* [x] Autenticar usuário
  * [x] Criar usuário não registrado se ele tiver convite
* [ ] Enviar convite para email

## Especificações

### Autenticar usuário

Usuários fazem login via OAuth de serviços externos como emails Google, login Facebook, etc. Essa responsabilidade será da camada de [Framework](https://github.com/brunoviana/meusfeeds-laravel) que conversará com os serviços e passará para a camada de [Aplicação](/src/App) os dados do usuário que fez login.

Caso o email informado já exista no Meus Feeds o usuário é autenticado, caso contrário é necessário ter um convite para o email que está tentando acessar.

Se o convite existir o usuário desse email é criado e autenticado, caso contrário a autenticação irá falhar.

### Enviar convite para email

*Em desenvolvimento*

