# Запуск проекта
```
git clone https://github.com/agleevtimur/novex_test.git
docker-compose up -d --build
```
# Запуск тестов
```
docker exec -t -i php /bin/bash
vendor/bin/phpunit
```
## Эндпоинты

+ POST user/ - создание
+ PUT  user/{id} - изменение
+ DELETE user/{id} - удаление
+ GET user/{id} - получение
+ GET user - получение всего списка

Пример json для PUT /user/ (изменение пользователя)
```
{
    "name": "test1",
    "email": "test6@gmail.com",
    "phone": "+79995552234",
    "sex": "male",
    "age": 20,
    "birthday": "2001-01-01"
}
```
Если упустить какой-либо параметр, то изменения для этого параметра применятся со значением null
