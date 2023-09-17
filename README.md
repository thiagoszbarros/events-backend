## Instruções de Uso

1. Certifique-se de ter o Docker Compose instalado em sua máquina.

2. Clone este repositório para sua máquina local.

3. Abra um terminal e navegue até o diretório raiz do projeto.

4. Execute o seguinte comando para configurar e iniciar o projeto:

    ````
    docker-compose up -d
    ````
    Isso criará um ambiente de desenvolvimento contido em contêineres Docker.

5. Execute migrações e sementes do Laravel para configurar o banco de dados:

    ````
    docker exec php php artisan migrate --seed
    ````

    Isso criará tabelas no banco de dados e preencherá com dados de teste.

6. Configure as permissões de arquivo do diretório de armazenamento com o seguinte comando:
    ````
    sudo chmod -R 770 storage
    ````

    Isso garantirá que o Laravel tenha as permissões corretas para acessar o diretório de armazenamento.

7. Agora, seu aplicativo Laravel está pronto para ser acessado. Abra seu navegador e acesse `http://localhost:8001` para visualizar seu aplicativo em ação.

8. Comece a desenvolver! Faça alterações no código-fonte e veja-as refletidas em seu ambiente de desenvolvimento local.

## Contribuição

Sinta-se à vontade para contribuir com este projeto, relatar problemas ou fazer melhorias. Sua colaboração é bem-vinda!

Aproveite o desenvolvimento tranquilo e eficaz com o Laravel e o Docker Compose!

[Laravel](https://laravel.com/docs)
