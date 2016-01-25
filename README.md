restTwitter
===========

projeto para avaliação SocialBase
---------------------------------
**framework symfony**
    - [Symfony](https://symfony.com)

**fazer clone do repositorio**
```
    git clone https://github.com/eerison/restTwitter.git && cd restTwitter
```

**Atualizar bower**
```
    bower update
```

**Atualizar composer**
```
    composer update
```

**criar banco de dados**
```
    php app/console doctrine:database:create
```

**criar tabela**
```
    php app/console doctrine:schema:update --force
```

**iniciar servidor de desenvolvimento**
```
    php app/console server:run
```

**acessar pagina**
```
    http://127.0.0.1:8000/twitter.html
```






