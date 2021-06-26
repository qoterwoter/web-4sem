# Рубежный контроль
## Схема базы данных
Для дальнейших примеров я создал две таблицы и наполнил их\
![Схема БД](https://sun9-75.userapi.com/impg/ggr41vjNXUpEZmrJiEFzuqKK2VodwH1SUp5D7Q/isHkxVk2b8Y.jpg?size=309x507&quality=96&sign=a861ff8321bf775448ef3813d9c581e0&type=album)
### Таблица _lessons_
![табилца lessons](https://sun9-65.userapi.com/impg/lVf5mW3qWxDghunT_BTNDlMxlnwBiV9WbW_9lg/556Ede2G1Vg.jpg?size=489x244&quality=96&sign=075b8363df683b576898b60cef197e21&type=album)
### Таблица _students_
![табилца students](https://sun9-57.userapi.com/impg/o5TRl5Fr9qF1dzWd9J1XDDOEiWlynXhJdVaSUg/tAct4YMIArk.jpg?size=368x146&quality=96&sign=73f1903b92aed9ee881d59a4e2e38712&type=album)
## CROSS JOIN
__CROSS JOIN__ берет строки из первой таблицы (*lessons*) и складывает их со всеми строками из второй таблицы (*students*)
```sql 
SELECT * FROM lessons 
JOIN students 
```
```sql 
SELECT * FROM lessons 
CROSS JOIN students 
```
Результат:
![Example](https://sun9-66.userapi.com/impg/wH8tWRbJWqlD-Itt5RPgXii8dkhKqofZB9POmg/NhDpYsYwYpg.jpg?size=898x402&quality=96&sign=be5e064c30751c462fa7c2608798c3df&type=album)

## INNER JOIN
__INNER JOIN__ выводит пересечения двух таблиц по условию (в отличии от __CROSS__, который выводит все возможные комбинации).\
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
Результат:
![Example](https://sun9-11.userapi.com/impg/bwZR5aS8lIALAUBgosMX_Hl5ibrS3RAguapLlw/68kKGnrS2pM.jpg?size=818x196&quality=96&sign=138a1d23225f0e6d4f5eb262bb47766d&type=album)

## LEFT JOIN
__LEFT JOIN__ выводит все строки из _первой_ таблицы и строки из _второй_ таблицы, которые пересекаются с _первой_ таблицей по условию\
Следующие примеры являются идентичными:
```sql 
SELECT * FROM lessons 
LEFT JOIN students 
ON lessons.student_id = students.id
```
Поскольку не для всех строк из таблицы *lessons* есть соответствующие строки из таблицы *students*, то в оставшиеся столбцы попало значение *null*.\
Результат:
![Example](https://sun9-19.userapi.com/impg/XY-G8nLwyFjdPRzbFY3K-YMfpTO2Uikb2lu47w/rlZxJC33b30.jpg?size=830x231&quality=96&sign=f20f01cdb6b385c3f05c21db1f6a2a50&type=album)

## RIGHT JOIN
__RIGHT JOIN__ выводит все строки из _второй_ таблицы и строки из _первой_ таблицы, которые пересекаются с _первой_ таблицей по условию.\
в __LEFT JOIN__ _первая_ таблица является основной, к которой уже добавляется _вторая_, а в __RIGHT JOIN__ наоборот.
Следующие примеры являются идентичными:
```sql 
SELECT * FROM lessons 
RIGHT JOIN students 
ON lessons.student_id = students.id
```
Поскольку не для всех строк из таблицы *students* есть соответствующие строки из таблицы *lessons*, то в оставшиеся столбцы попало значение *null*.\
Результат:
![Example](https://sun9-41.userapi.com/impg/6b1R_0JWS3CETV_KiIYZuoAe6s-6t_M4dxC3fg/3OGsNxlztMw.jpg?size=814x219&quality=96&sign=8a32233cbe9af620677bea4986a29ae2&type=album)

## Вывод
__CROSS__ и __INNER JOIN__ отличаются тем, что __CROSS__ выводит все возможные комбинации двух таблиц,
а __INNER__ выводит только комбинации по указанному *условию*.\
__LEFT__ и __RIGHT JOIN__ отличаются тем, что __LEFT__ выводит все строки из *первой* таблицы и строки из *второй* таблицы,
которые имеют пересечения с *первой* таблицей по указанному *условию*.\
__RIGHT__ выводит все строки из *второй* таблицы и строки из *первой*, которые имеют пересечения со *второй* таблицей по указанному *условию*.
# Выполнил Цалапов Александр 191-322
## Использованные материалы
* https://habr.com/ru/post/448072/
* https://ru.wikipedia.org/wiki/Join_(SQL)