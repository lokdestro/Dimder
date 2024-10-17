-- Создание нового пользователя
INSERT INTO User (name, email, password, birth_date, gender, interests)
VALUES ('John Doe', 'johndoe@example.com', 'password123', '1990-01-01', 'male', 'reading, traveling');

-- Чтение всех пользователей
SELECT * FROM User;

-- Чтение одного пользователя по id
SELECT * FROM User WHERE id = 1;

-- Обновление данных пользователя
UPDATE User
SET name = 'John Smith', email = 'johnsmith@example.com', interests = 'sports, photography'
WHERE id = 1;

-- Удаление пользователя
DELETE FROM User WHERE id = 1;


-- CRUD операции для таблицы Message

-- Создание нового сообщения
INSERT INTO Message (sen
der_id, receiver_id, content)
VALUES (1, 2, 'Hello! How are you?');

-- Чтение всех сообщений
SELECT * FROM Message;

-- Чтение сообщений от конкретного отправителя
SELECT * FROM Message WHERE sender_id = 1;

-- Чтение сообщений между двумя пользователями
SELECT * FROM Message WHERE sender_id = 1 AND receiver_id = 2;

-- Обновление сообщения
UPDATE Message
SET content = 'Updated message content'
WHERE id = 1;

-- Удаление сообщения
DELETE FROM Message WHERE id = 1;


-- CRUD операции для таблицы Profile

-- Создание нового профиля
INSERT INTO Profile (user_id, photo, bio, location)
VALUES (1, 'profile_photo.jpg', 'Software Engineer at XYZ', 'New York');

-- Чтение всех профилей
SELECT * FROM Profile;

-- Чтение профиля конкретного пользователя
SELECT * FROM Profile WHERE user_id = 1;

-- Обновление профиля пользователя
UPDATE Profile
SET bio = 'Senior Software Engineer at XYZ', location = 'Los Angeles'
WHERE user_id = 1;

-- Удаление профиля
DELETE FROM Profile WHERE id = 1;