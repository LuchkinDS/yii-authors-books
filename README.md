Тестовое задание для Php разработчика:
взять Yii2 версия
реализовать сущности авторы и книги 
реализовать админку – CRUD операции для авторов и книг
вывести список книг с обязательным указанием имени автора в списке
вывести список авторов с указанием кол-ва книг
реализовать публичный сайт с отображение авторов и их книг 
совсем простой список, ничего не надо придумывать 

реализовать выдачу данных в формате json по RESTful протоколу отдельным контроллером 

GET /api/v1/books/list получение списка книг с именем автора 
GET /api/v1/books/by-id получение данных книги по id 
POST /api/v1/books/update обновление данных книги 
DELETE /api/v1/books/id удаление записи книги из бд 

(изменил в пользу общепринятого варианта: 
GET /api/v1/books получение списка книг с именем автора 
GET /api/v1/books/<id> получение данных книги по id 
POST /api/v1/books добавление книги 
PUT /api/v1/books обновление данных книги 
DELETE /api/v1/books/<id> удаление записи книги из бд
)

Результат представить  ссылкой на репозиторий. 
