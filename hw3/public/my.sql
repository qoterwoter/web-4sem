SELECT name as'Имя', surname as 'Фамилия', 
lessons.title 'Предмет', lessons.description 'Описание ',
diploma_date.diploma_date 'Дата получения диплома' FROM students
join lessons_students on students.id = lessons_students.student_id
join lessons on lessons.id = lessons_students.lesson_id
join diploma_date on students.id = diploma_date.student_id
where students.id = 1