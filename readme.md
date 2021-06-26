# Рубежный контроль

## Схема базы данных
Для дальнейших примеров я создал две таблицы и наполнил их\
![Схема БД](https://sun9-7.userapi.com/impg/AlU02x7ogqTbhw8dY_FmTyY247CTOeeebTf6Ng/VIAzzSFyTUE.jpg?size=300x404&quality=96&sign=da7f44ecea37540c24615df72bfe6a01&type=album)

## CROSS JOIN
_CROSS JOIN_ берет строки из первой таблицы (*lessons*) и складывает их со всеми строками из второй таблицы (*students*)
```sql 
SELECT * FROM lessons 
JOIN students 
```
```sql 
SELECT * FROM lessons 
CROSS JOIN students 
```
![Example](https://sun9-66.userapi.com/impg/wH8tWRbJWqlD-Itt5RPgXii8dkhKqofZB9POmg/NhDpYsYwYpg.jpg?size=898x402&quality=96&sign=be5e064c30751c462fa7c2608798c3df&type=album)

## INNER JOIN
_INNER JOIN_ выводит пересечения двух таблиц по условию (в отличии от _CROSS_, который выводит все возможные комбинации)\
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
![Example](https://sun9-11.userapi.com/impg/bwZR5aS8lIALAUBgosMX_Hl5ibrS3RAguapLlw/68kKGnrS2pM.jpg?size=818x196&quality=96&sign=138a1d23225f0e6d4f5eb262bb47766d&type=album)

## LEFT JOIN
_LEFT JOIN_ выводит все строки из первой таблицы и строки из второй таблицы, которые пересекаются с первой таблицой по условию\
Следующие примеры являются идентичными:
```sql 
SELECT * FROM lessons 
LEFT JOIN students 
ON lessons.student_id = students.id
```
Поскольку не для всех строк из таблицы *lessons* есть соответствующие строки из таблицы *students*, то в оставшиеся столбцы попало значение *null*
![Example](https://sun9-19.userapi.com/impg/XY-G8nLwyFjdPRzbFY3K-YMfpTO2Uikb2lu47w/rlZxJC33b30.jpg?size=830x231&quality=96&sign=f20f01cdb6b385c3f05c21db1f6a2a50&type=album)

## Использованные материалы
* https://habr.com/ru/post/448072/
* https://ru.wikipedia.org/wiki/Join_(SQL)