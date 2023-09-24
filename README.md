## Instruções de Uso

1. Certifique-se de ter o Docker Compose instalado em sua máquina.

2. Clone este repositório para sua máquina local.

3. Abra um terminal e navegue até o diretório raiz do projeto.

4. Execute o seguinte comando para configurar as variáveis de ambiente:

    ````
    cp .env.example .env
    ````

4. Execute o seguinte comando para configurar e iniciar o projeto:

    ````
    docker-compose up -d
    ````

4. Execute o seguinte comando para configurar as dependências:

    ````
    docker exec php composer install
    ````

5. Gere a chave da aplicação:

    ````
    docker exec php php artisan key:generate
    ````
5. Execute as migrations e seeds do Laravel para configurar o banco de dados:

    ````
    docker exec php php artisan migrate --seed
    ````

5. Configure o git para ignorar permissões:

    ````
    git config core.fileMode false
    ````


6. Configure as permissões de arquivo do diretório de armazenamento com o seguinte comando:
    ````
    sudo chmod -R 777 storage
    ````

7. Abra seu navegador e acesse `http://localhost:8001` para visualizar o Laravel aplicativo em ação.

8. Comece a desenvolver! Faça alterações no código-fonte e veja-as refletidas em seu ambiente de desenvolvimento local.

## Contribuição

Sinta-se à vontade para contribuir com este projeto, relatar problemas ou fazer melhorias. Sua colaboração é bem-vinda!

Aproveite o desenvolvimento tranquilo e eficaz com o Laravel e o Docker Compose!

[Laravel](https://laravel.com/docs)
