# Рубежный контроль

## Схема базы данных
Для дальнейших примеров я создал две таблицы и наполнил их\
![Схема БД](https://sun9-7.userapi.com/impg/AlU02x7ogqTbhw8dY_FmTyY247CTOeeebTf6Ng/VIAzzSFyTUE.jpg?size=300x404&quality=96&sign=da7f44ecea37540c24615df72bfe6a01&type=album)
## CROSS JOIN
Создает все возможные комбинации из двух таблиц \
```sql 
SELECT * FROM lessons 
CROSS JOIN students 
```
![Example](https://sun9-30.userapi.com/impg/q--ZEPhXtqwexHXcF67rsrdgGtZOTODrmIP7zA/wTG43g-3ES0.jpg?size=829x737&quality=96&sign=f93dd05501dd7aa084728334b9a89758&type=album)
## INNER JOIN
Создает все возможные комбинации из двух таблиц \
```sql 
SELECT * FROM lessons 
CROSS JOIN students 
WHERE lessons.student_id = students.id
```
![Example](https://sun9-9.userapi.com/impg/Cdkk7CV8LSsCZbiP5D7NsoUVuVtBhpUJURG8ZA/pSQLEDz_acs.jpg?size=838x356&quality=96&sign=4d0bad1ada9bb2915697f1b4172732f3&type=album)