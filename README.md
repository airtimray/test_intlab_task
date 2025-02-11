# REST API Пользователей

## Доступные методы

### Регистрация пользователя
**POST** `/register`  
**Тело запроса (JSON):**
```json
{
  "username": "example",
  "password": "password123",
  "email": "example@example.com"
}
```
**Ответ:**
```json
{
  "message": "User created successfully"
}
```

### Авторизация пользователя
**POST** `/login`  
**Тело запроса (JSON):**
```json
{
  "username": "example",
  "password": "password123"
}
```
**Ответ:**
```json
{
  "message": "Login successful",
  "user": { "id": 1, "username": "example", "email": "example@example.com" }
}
```

### Получение информации о пользователе
**GET** `/user/{id}`  
**Ответ:**
```json
{
  "id": 1,
  "username": "example",
  "email": "example@example.com"
}
```

### Обновление информации пользователя
**PUT** `/user/{id}`  
**Тело запроса (JSON):**
```json
{
  "username": "newname",
  "email": "new@example.com"
}
```
**Ответ:**
```json
{
  "message": "User updated successfully"
}
```

### Удаление пользователя
**DELETE** `/user/{id}`  
**Ответ:**
```json
{
  "message": "User deleted successfully"
}
```
