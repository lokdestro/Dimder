# Проект: Сайт для знакомств

Добро пожаловать в "Сайт для знакомств"! Это веб-приложение создано для того, чтобы пользователи могли находить новых друзей или партнеров в сети.

## Описание проекта

"Сайт для знакомств" - платформа, которая связывает людей, исходя из их интересов и предпочтений. Пользователи могут создавать профили, просматривать профили других участников и общаться с ними как через систему личных сообщений, так и в чатах.

## Стек используемых технологий

- Backend: Laravel
- Frontend: React
- База данных: MySQL
- Аутентификация: JWT
- Сервер: Nginx

## Пользовательские роли и действия в системе

Диаграмма вариантов использования:

!Use Case Diagram

- Гость
  - Просмотр главной страницы
  - Регистрация
  - Вход в систему

- Пользователь
  - Редактирование профиля
  - Поиск других пользователей
  - Обмен сообщениями
  - Просмотр и лайки профилей

- Администратор
  - Управление пользователями
  - Модерация контента

## Схема БД - ER диаграмма

ER-диаграмма представляет отношения и связи между основными сущностями нашего приложения. 

!ER Diagram

- Пользователь (User)
  - id
  - имя
  - email
  - пароль
- Сообщение (Message)
  - id
  - отправительid
  - получательid
  - содержание
  - датаотправления

- **Профиль (Profile)**
  - id
  - user id
  - фотография
  - биография 
  - местоположение
    - дата рождения
    - пол
    - интересы


## API

### Авторизация

- POST /api/auth/register - Регистрация нового пользователя.
    {
    "name": "string",
    "email": "string",
    "password": "string"
  }
  

- POST /api/auth/login - Вход пользователя.
    {
    "email": "string",
    "password": "string"
  }
  

### Пользователи 

- GET /api/users - Получение списка пользователей.

- GET /api/user/{id} - Получение информации о пользователе.

### Сообщения

-  websocket - Отправка нового сообщения.
    {
    "recipient_id": "integer",
    "body": "string",
    "type": "integer"
  }
- websocket - Получение сообщения
    {
    "sender_id":"integer",
    "name": "string,"
    "body": "string",
    "type": "integer"
    }

### Профили

- GET /api/profile/{userId} - Получение профиля пользователя.

- PUT /api/profile - Обновление профиля.
    {
    "photo": "string",
    "bio": "string",
    "location": "string"
  }
  