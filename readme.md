# Рубежный контроль

## Схема базы данных
Для дальнейших примеров я создал две таблицы и наполнил их\
![Схема БД](https://sun9-7.userapi.com/impg/AlU02x7ogqTbhw8dY_FmTyY247CTOeeebTf6Ng/VIAzzSFyTUE.jpg?size=300x404&quality=96&sign=da7f44ecea37540c24615df72bfe6a01&type=album)
## CROSS JOIN
CROSS JOIN берет строки из первой таблицы (*lessons*) и складывает их со всеми строками из второй таблицы (*students*)
```sql 
SELECT * FROM lessons 
JOIN students 
```
```sql 
SELECT * FROM lessons 
CROSS JOIN students 
```
![Example](https://sun9-1.userapi.com/impg/D9yYyTg9mLR-fC1xD9lsnN6rgK84wQPDsVp9vQ/iHl0e0J8BnE.jpg?size=909x469&quality=96&sign=348f9e5ea1ae81334bd29269cb5a275b&type=album)
## INNER JOIN
INNER JOIN выводт пересечения двух таблиц по условию\
Следующие примеры являются идентичными:
```sql 
SELECT * FROM lessons 
JOIN students 
ON lessons.student_id = students.id
```
```sql 
SELECT * FROM lessons 
INNER JOIN students 
ON lessons.student_id = students.id
```
```sql 
SELECT * FROM lessons 
CROSS JOIN students 
ON lessons.student_id = students.id
```
INNER
![Example](https://sun9-9.userapi.com/impg/Cdkk7CV8LSsCZbiP5D7NsoUVuVtBhpUJURG8ZA/pSQLEDz_acs.jpg?size=838x356&quality=96&sign=4d0bad1ada9bb2915697f1b4172732f3&type=album)

## Использованные материалы
* https://habr.com/ru/post/448072/