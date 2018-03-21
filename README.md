################################################################################
##  Фреймворк и CMS.MNBV-8
################################################################################

Рады представить Вам наш продукт, который состоит из фреймворка и системы
управления контентом (далее CMS). 

При разработке, мы не претендовали на гениальность и уникальность. Мы создавали
решение, которое было бы полезно и удобно нам и близким к нам по подходам
разработчикам. Мы признаем ценность и обоснованность иных решений, которые
нравятся и помогают в работе использующим их специалистам и позволяют создавать
им продукты, качественно выполняющие свое назначение. Мы готовы к критике
и будем благодарны за отзывы о нашей системе, которые безусловно будут
способствовать ее развитию и возможно - смене каких-то наших взглядов.


Идеи, которые закладывались при проектировании системы:

1. Простота и легкость, попытка избежать конструкций из большого количества
вложенных файлов. Типовое построение всех модулей системы с целью упростить
восприятие кода.

2. Скорость исполнения кода обычно является ключевым критерием при выборе того 
или иного решения. 

3. Архитектура, спроектированная с возможностью использования в проектах
систем контроля версий (GIT...). В папке "app" может быть реализована структура 
модулей, повторяющая структуру модулей системы, в которой вы создаете файлы:
либо выполняемые поверх соответствующих файлов, находящихся под системой
контроля версий (конфиги), либо выполняемые вместо этих файлов. Такая схема
позволяет с большим комфортом вести разработку и внедрение.

4. Работа с базами данных ведется через систему хранилищ, обслуживаемых 
библиотекой статических методов работы с ними. Методы этой библиотеки принимают
запросы разного вида и уже далее, в зависимости от типа базы, привязанной к
соответствующему хранилищу, работают с ней. Библиотека работы с хранилищами
реализует все основные запросы к базам данных, включая использующие join,
алиасы различных видов и т.п. Схема чем-то функционально схожа с PDO, но 
имеет ряд отличий. Основное отличие - использование функционального подхода,
хотя естественно на более низком уровне для поддержания линков и т.п. работа
с базой ведется на уровне объектов.

5. CMS позволяет создавать взаимосвязанные информационные структуры на уровне
работы с конфигурацией хранилищ, при этом автоматически формируется интерфейс
работы с этой информационной структурой. Такая схема позволяет ускорить
разработку, сосредоточившись на фронтенде и каких-то важных внутренних процессах.

6. Система мультисайтовая, позволяет проводить индивидуальную настройку обработки
различных доменов, привязку их к одной или нескольким информационным структурам,
привязку их к разным шаблонам дизайна.

7. Шаблоны дизайна минималистичные как на примере фронтенда, так и в админке. 
Это сделано для того, чтоб вы при интеграции своих шаблонов максимально быстро
идентифицировали элементы шаблонов и использовали их. Система построена на основе
паттерна MVC, что делает интеграцию и использование нескольких альтернативных
шаблонов - простой задачей. Шаблоны дизайна представляют собой html код с 
незначительными включениями php, связанными с выводами массива данных, передаваемых
в шаблон.

8. Система позволяет управлять выводом (html, text, json). Также есть возможность
работать с консолью, используя параметры из вызова скрипта по аналогии с GET
параметрами. Все это позволяет гибко управлять выводом и используя одни и те же
механизмы организовывать при необходимости и API и html выдачу и консольные операции.

9. Вся маршрутизация ведется в маршрутизаторах системы, на уровне Web сервера идет
только переадресация на точку входа "modules/core/core.php" для дальнейшей обработки.
Это позволяет с легкостью внедрять систему на разных Web серверах.

10. Система задумывалась и реализовывается как мультиязычная, однако полноценная 
поддержка ведется параллельно для 2х языков. Весь вывод в шаблоны и т.п. ведется
с использованием подключаемых словарей. В админке есть возможность редактировать
двуязычные поля, переключаясь между языками. Полноценное переключение между языками
есть как на уровне интерфейсов, так и на уровне структур данных. 

11. В системе заложено логирование ее работы на всех этапах, в том числе возможность
подключения модуля аудита расхода различными потоками ресурсов системы в том числе
в динамике, что позволит быстро выявить узкие места в нагруженном режиме.

12. Мы планировали использование данной системы при разработке высоконагруженных 
систем, что влечет за собой возможность масштабирования, распределения нагрузки и
другие подобные вещи. Поэтому изначально закладывалась возможность хранения 
приложенных файлов различного вида на различных серверах. При формировании ответа
не происходит опрос файловой системы с целью поиска файлов для вывода.

13. Возможность работы с системой различными пользователями с различными уровнями
доступа к разным объектам, включая (при необходимости) и приложенные файлы.

14. Распространение системы под максимально открытой лицензией BSD позволяет
использовать ее как основу для коммерческих решений.

15. В системе закладывается функционал работы со служебными скриптами, которые могут
запускаться в ручном режиме, по расписанию (аналог cron) и в бесконечном цикле.
Для этого создан удобный интерфейс работы с подобными процессами (роботами).
Запуск процессов осуществляется в режиме "демонов", есть возможность наблюдать
консоль работы скрипта, управлять им. Отдельно есть система мониторинга и перезапуска
внезапно остановившихся скриптов (обычно работающих в бесконечных циклах) для 
обеспечения бесперебойной их работы.


################################################################################
##  Установка системы CMS.MNBV-8
################################################################################

1. Склонируйте из GIT систему в каталог.

2. Скопируйте и при необходимости скорректируйте файлы:
	console.default.php
	start_robot.default.php
	www/index_default.php
удалив default на конце.

3. Перейдите в папку "www/tmp" и создайте там символическую ссылку "imgeditor" на
"tmp/imgeditor". В Windows можно так "mklink /j ссылка назначение". 

4. Перейдите в папку "www/data" и создайте там символические ссылки на папки из 
"data/storage_files" с названиями, соответствующими хранилищам из которых вы 
хотите отображать приложенные файлы без проверки прав доступа.
Для демо инсталяции зайдите в корневую папку, где вы создаете линк и выполните 
команды Windows:
```
Для папки www/tmp:
mklink /j imgeditor D:\OSPanel\domains\mnbv\tmp\imgeditor

Для папки www/data:
mklink /j site D:\OSPanel\domains\mnbv\data\storage_files\site
mklink /j news D:\OSPanel\domains\mnbv\data\storage_files\news
mklink /j articles D:\OSPanel\domains\mnbv\data\storage_files\articles
mklink /j products D:\OSPanel\domains\mnbv\data\storage_files\products
mklink /j actions D:\OSPanel\domains\mnbv\data\storage_files\actions
```

5. Создайте базу данных базовая кодировка utf-8, сравнение utf8_general_ci
По-умолчанию для базы используется название mnbv8. При локальных тестах она
запускается под пользователем root без пароля. При таких настройках дополнительной
конфигурации БД перед запуском не потребуется. Дефолтовый дамп базы лежит
в "data/storage_dumps/mnbv8.sql".

6. По-умолчанию в конфиге настроены доступы к Mysql базе mnbv8 для пользователя 
root без пароля. Если в вашем случае это другие доступы, то создайте файл 
"app/modules/mnbv/config/config.php"  по образцу:

```php
<?php
//Переменные работы с Базами и хранилищами данных-----------------------
//Установка доступов к БД
SysStorage::setDb('mysql1',array(
	'host' => 'Хост БД, если локальный, то лучше 127.0.0.1',
	'database' => 'Название БД',
	'user' => 'Пользователь БД',
	'password' => 'Пароль к БД'
));
//Конец файла, не закрывать его тегом закрытия скрипта ------------------
```

7. Настройте Web сервер на запуск вашего домена из директории "web" системы.
Индексы директорий index.html, index.php.

8. Откройте ваш домен в браузере по http://ВАШ-ДОМЕН, проверьте 
работоспособность.

9. Для перехода в панель администрирования системы используйте:
http://ВАШ-ДОМЕН/intranet (login: admin / passwd: admin). 
Вы сможете управлять настройками пользователей в соответствующем хранилище.

10. Желаем Вам приятного пользования системой!!! 
