<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# Organizador de Times de Jogadores

## Descrição

Este é um componente em um sistema de gerenciamento de times e jogadores. A função "shuffle" desempenha um papel importante na organização dos jogadores em times de forma justa e equilibrada. Abaixo, explicaremos o que esta função faz, passo a passo, sem usar termos técnicos:

## Como Funciona

**Passo 1:** Primeiro, ela remove todos os jogadores dos times existentes. Ou seja, começa do zero.

**Passo 2:** Em seguida, ela pega informações sobre todos os times e todos os jogadores disponíveis no sistema.

**Passo 3:** Ela verifica quantos jogadores cabem em cada time. Todos os times têm um número máximo de jogadores que podem ter.

**Passo 4:** Ela verifica quantos jogadores estão prontos para jogar. Se houver muito poucos jogadores prontos, não será possível continuar.

**Passo 5:** Agora, ela começa a organizar os jogadores nos times. Ela faz isso seguindo algumas regras:

- Primeiro, ela verifica se um time já tem um goleiro (o jogador que protege o gol). Se tiver, ela não adiciona outro goleiro a esse time.

- Ela também verifica se um jogador já foi adicionado a outro time. Um jogador não pode jogar em mais de um time ao mesmo tempo.

- Ela organiza os jogadores por habilidade, tentando equilibrar a habilidade dos jogadores em cada time.

**Passo 6:** Depois de seguir essas regras, ela embaralha aleatoriamente a ordem dos jogadores.

**Passo 7:** Agora, ela começa a adicionar jogadores aos times. Ela pega os primeiros jogadores da lista embaralhada e os adiciona a um time.

**Passo 8:** Ela continua fazendo isso até que todos os times tenham o número certo de jogadores e seguindo as regras estabelecidas.

**Passo 9:** Se ainda houver jogadores disponíveis depois disso, ela cria novos times para esses jogadores. Ela dá nomes especiais a esses times, como "Time dos Remanescentes", e garante que eles também sigam as regras.

**Passo 10:** Finalmente, quando todos os jogadores estão em times e tudo está organizado, ela redireciona você para uma página onde você pode ver como os jogadores foram distribuídos nos times.

## Como Usar

Para utilizar esta função, você pode acessá-la através da interface do sistema. Normalmente, você encontrará um botão ou link que diz "Organizar Times" ou algo similar. Depois de clicar nele, o sistema executará automaticamente a função "shuffle" para você.

Lembre-se de que esta função é projetada para tornar a distribuição de jogadores em times o mais justa possível, seguindo regras específicas. Portanto, não se preocupe com os detalhes técnicos; basta usar e desfrutar!

Sistema disponível em ambiente AWS utilizando serviços:

- Route 53
- EC2
- RDS

Disponível em 

http://www.devlira.com.br

---


# Guia de Instalação do Projeto

Este guia descreve como baixar e executar o Sistema XYZ em seu ambiente local usando Docker.

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes pré-requisitos instalados em sua máquina:

- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/)

## Passo 1: Clone o Repositório

1. Abra um terminal ou prompt de comando.

2. Navegue até o diretório onde você deseja clonar o repositório.

3. Execute o seguinte comando para clonar o repositório do GitHub:

   ```shell
   git clone https://github.com/nome-do-usuario/nome-do-repositorio.git

## Passo 2: Entre no Diretório do Projeto

1. Navegue para o diretório recém-clonado usando o seguinte comando:

   ```shell
   cd nome-do-repositorio

## Passo 3: Configuração do Docker

1. Verifique se o Docker está em execução em sua máquina.

## Passo 4: Crie e Execute os Contêineres Docker

1. Use o seguinte comando para criar e executar os contêineres Docker com base nas configurações do projeto:

   ```shell
   docker-compose up -d

- Isso criará e executará todos os contêineres definidos no arquivo docker-compose.yml.

2. Aguarde até que todos os contêineres sejam baixados e iniciados. Você verá mensagens no terminal indicando o progresso.

## Passo 5: Acesse o shell do contêiner Docker

1. Abra o terminal no seu sistema operacional (Linux, Windows ou macOS).
2. Navegue até o diretório do projeto onde os arquivos Docker estão localizados usando o comando cd. Por exemplo:
   ```shell
   cd /caminho/para/o/diretorio/do/projeto

Substitua /caminho/para/o/diretorio/do/projeto pelo caminho real para o diretório do seu projeto.

3. Execute o seguinte comando para acessar o shell do contêiner Docker:
    ```shell
   docker exec -it dream-team-php-1 bash

Você pode também substituir `dream-team-php-1` pelo nome ou ID do seu contêiner Docker, conforme necessário. Esse comando abrirá uma sessão interativa no contêiner, permitindo que você execute comandos e realize tarefas dentro do ambiente Docker.

Agora você está dentro do shell do contêiner Docker e pode interagir com o ambiente como se estivesse dentro de uma máquina virtual isolada. Isso pode ser útil para executar comandos específicos, verificar o estado do sistema e realizar tarefas de manutenção quando necessário. Quando terminar, você pode sair do shell do contêiner com o comando `exit`

## Passo 6: Instalar dependencias do projeto
Após os passos acima dentro do shell do docker EX: `lira@86dfe6374784:/var/www$`

1. Execute o seguinte comando:

   ```shell
   composer install

## Passo 7: Rodando migrations das tabelas do Banco de Dados
Após os passos acima dentro do shell do docker EX: `lira@86dfe6374784:/var/www$`

1. Execute o seguinte comando:

   ```shell
   php artisan migrate

## Passo 8: Acesse o Sistema

1. Após a conclusão da criação dos contêineres, você poderá acessar o sistema em seu navegador.
2. Abra um navegador da web e vá para o seguinte endereço:

   ```shell
   http://localhost

- A porta configurada está padrão :80.


## Passo 9: Encerre e Remova os Contêineres (Opcional)
Se você precisar interromper e remover os contêineres Docker mais tarde, siga estas etapas:

1. Navegue até o diretório do projeto no terminal.
2. Execute o seguinte comando:

   ```shell
   docker-compose down

Isso encerrará e removerá todos os contêineres associados a este projeto.

Agora você instalou e executou a aplicação a partir do GitHub usando o Docker. Lembre-se de que as instruções podem variar dependendo do projeto, por isso é importante consultar a documentação específica do projeto, se disponível, para obter informações adicionais sobre a configuração e o uso.
