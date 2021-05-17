SELECT name as'Имя', surname as 'Фамилия', 
lessons.title 'Предмет', lessons.description 'Описание ',
diploma_date.diploma_date 'Дата получения диплома' FROM students
join lessons_students on students.id = lessons_students.student_id
join lessons on lessons.id = lessons_students.lesson_id
join diploma_date on students.id = diploma_date.student_id
where students.id = 1

/* 
Для всех таблиц первой колонкой является ID с типом данных INT, которая является первичным ключом.
        в таблице STUDENTS был вабран тип данных varchar для столбцов NAME, SURNAME, чтобы ограничить возможные данные
        в таблице LESSONS для колонки TITLE также был выбран тип данных varchar с целью ограничения длинны названия предмета, 
    а для колонки DESCRIPTION был выбран типа данных TEXT, поскольку описание может быть очень большим
        в таблице DEPLOMA_DATE для колонки DIPLOMA_DATE был выбран типа данных DATE, чтобы указанная дата являлась соответствующим типом данных,
    для колонки STUDENT_ID тип данных INT, поскольку эта колонка отсылается к таблице STUDENTS, указывая дату диплома для соответсвующего студента
        в таблице LESSONS_STUDENTS у всех столбцов тип данных выбран INT, чтобы
 */

 
/*
        Как я понял EXPLAIN нужен для отладки и оптимизации SQL запроса, с его помощью можно увидеть какие таблицы были использованны.
    какой тип выбора был использован(select_type), какие табилцы были подключены(table), тип объединения таблиц(type), список индексов и название(possible_keys, key), размер ключей в байтах (key_len) и количество строк (rows)

        я продемонстрировал работу EXPLAIN на примере объединения трех таблиц.
    В моём запросе на видео видно, какие таблицы подключены(LESSONS, LESSONS_STUDENTS, STUDENTS), список индексов (ID,LESSON_ID,STUDENT_ID), размер ключей (4 и 5 байтов) и т.п.
        
*/