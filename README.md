# Микросервис эмуляции отправки сообщений в мессенджеры

Прототип микросервиса, обеспечивающий эмуляцию отправки сообщений в популярные сервисы instant messaging (Viber, Telegram, What’s App).

[Полное ТЗ]( SPECIFICATION.md)

# Установка

1 . Распаковать архив

```
tar -zxvf messenger_service.tar.gz
```

2 . Перейти в директорию проекта

```
cd messenger_service
```

3 . Запустить встроенный в Symfony web-сервер

```
php bin/console server:start 127.0.0.1:8000
```

4 . Запустить redis(через docker). Либо установить локально

```
docker run -p 6379:6379 redis
```

# Использование

1 . Приветствие

```
curl -X GET \
  http://127.0.0.1:8100/ \
  -H 'Cache-Control: no-cache' \
  -H 'Postman-Token: 82e221e1-db66-4447-acb7-1c5ed7045049'
```

2 . Добавить сообщение в очередь.
Отправить POST запрс с параметрами в формате json
Пример curl:

```
curl -X POST \
  http://127.0.0.1:8100/message/send \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: ac51ad2e-5f35-4f32-b2d2-186225e8035d' \
  -d '{
  "message": "Еest message",
  "recipients": [
    {
      "transport": "telegram",
      "recipient": "+79119834655"
    },
    {
      "transport": "viber",
      "recipient": "+79119834655"
    },
    {
      "transport": "whatsapp",
      "recipient": "+79119834655"
    }
  ],
  "token": "KpRpTd6MUt9nXruK"
}'
```

3 . Отправить сообщения из очереди(консольная команда, можно запускать по cron)

```
php bin/console app:send-messaged
```

4 . Добавить сообщения, которые не удалось отправить обратно в очередь

```
php bin/console app:update-failed
```

# Пояснения:

- Задание сделал на PHP 7.1, использовал фреймворк Symfony 4.
Symfony - надежный стабильный фреймворк. 4я версия сильно оптимизирована в т.ч. для разработки микросервисов.

- В качестве очереди использовал простое самописное решение на базе redis.

- В рамках одного запрса можно указать любое количество получателей и месенджеров. Но повторы запрещены. Т.е. нельзя 
прислать, к примеру, такие параметры.

{
  "message": "Еest message",
  "recipients": [
    {
      "transport": "whatsapp",
      "recipient": "+79119834655"
    }
    {
      "transport": "whatsapp",
      "recipient": "+79119834655"
    }
  ],
  "token": "KpRpTd6MUt9nXruK"
}

- Реализована простейшая самописная валидация, см ```src/Service/Validation.php```

- Реализована простейшая проверка токена см. ```src/Service/Verification.php```

- Реализована эмуляция ошибок отправки. Для примера сделал Viber Transport сбойным. Каждый 3й запрос возвращает ошибку.
Такие сообщения попадают в отдельную очередь. Позже можно отправить их заново.

- Написаны заглушки классов и методов для юнит-тестов. Сами тесты не успел написать, к сожалению.