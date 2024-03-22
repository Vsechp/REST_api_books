# Описание

REST API Books - это простое веб-приложение на PHP, предоставляющее API для работы с книгами. Приложение позволяет пользователям регистрироваться, входить в систему, аутентифицироваться и получать доступ к книгам.

## Как работает приложение

Приложение использует базу данных PostgreSQL для хранения пользовательских данных и информации о книгах. Для регистрации и аутентификации пользователей используется JWT (JSON Web Token). При успешной аутентификации пользователю выдается токен, который затем используется для доступа к защищенным ресурсам, таким как список книг.

## Как запустить приложение

1. Склонируйте репозиторий на свой компьютер:

    ```
    git clone https://github.com/Vsechp/REST_api_books.git
    ```

2. Перейдите в директорию проекта:

    ```
    cd REST_api_books
    ```

3. Соберите Docker образ из Dockerfile:

    ```
    docker build -t my-php-app .
    ```

4. Запустите Docker контейнер:

    ```
    docker run -d -p 8000:80 my-php-app
    ```

5. Работающее приложение будет доступно по адресу [http://localhost:8000](http://localhost:8000)
