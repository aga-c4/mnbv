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

1. Простота и легкость, попытка избежать излишне сложных конструкций из 
большого количества вложенных файлов, бесконечных наследований. Типовое построение 
всех модулей системы позволяет упростить восприятие кода и упростить ознакомление
с ним.

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

10. Для подключения онлайн текстового редактора, необходимо выбрать его в
файле "modules/mnbv/config/config.php" и закачать файлы с сайта производителя 
в папку сайта, как это описано в конфиге (Поиск по "def_text_editor").


################################################################################
##  На что обратить внимание при изучении.
################################################################################

В настоящий момент мы имеем код фреймворка + CMS достаточно хорошо документированный,
чтобы в нем разобраться, однако еще не написано полноценное описание. В связи с этим,
есть необходимость указать места, на которые необходимо обратить внимание на
первых этапах. Итак, поехали.

## Точки входа, контроллеры, маршрутизация, типовое построение модуля, загрузка классов
У фрейворка и соответственно у всего остального есть основная точка входа
"modules/core/core.php". При этом корневой директорией скрипта должна быть корневая
директория проекта. Список допустимых для вызова модулей хранится в глобальном
массиве Glob::$vars['module_alias'].

Запуск системы может осуществляться с помощью web сервера или из консоли. В первом
случае запускается файл "www/index.php", во втором случае "console.php" или
"start_robot.php", которые работают по одному и тому же принципу.

Система построена по модульнуму принципу, все модули типовые, включая модуль core,
который является стартовым для всех процессов. Модули расположены в папке "modules".
Фронт контроллеры модулей находятся в корне своих корневых папок и называются так
же как и модуль (все символы в нижнем регистре). Обратите внимание на использование
паралельной структуры папок "app" в которых размещаются файлы, замещающие или
дополняющие те, которые находятся под системой контроля версий.

Маршрутизация во всех модулях осуществляется по одному и тому же принципу - во фронт
контроллере модуля после конфигов и инициализации выполняется php код, загружаемый
из файла маршрутизатора. В этом файле вы самостоятельно можете определять принципы
разбора входных данных для управления системой. Обычно для маршрутизации используются
уже подготовленные переменные из массива Glob::$vars['request']. В результате работы
маршрутизатора мы получаем требуемые module, controller, action и все остальное, что
потребуется при работе.

Все фронт контроллеры выполняются в глобальной области видимости на любом уровне
вложенности. После запуска маршрутизатора в модулях core и mnbv, управление передается
далее соответствующему конечному модулю (открывается файл модуля), а в случаях
работы конечных модулей - создается объект выбранного контроллера и запускается
метод, соответствующий выбранному action.


## Реестр глобальных переменных, конфиги, константы
Глобальные переменные системы размещаются в статическом массиве Glob::$vars. Для работы
с ним есть метод Glob::get('Ключ'), но вы можете и непосредственно работать с переменными
конфиги модулей размещаются в корневой папке модуля в "config/config.php". Пользовательские
конфиги из папки app выполняются после основного конфига модуля. По аналогии работают и
константы, единственное, что пользовательские константы инициализируются раньше основных,
чтоб иметь перед ними приоритет.


## Вывод, варианты вывода, шаблоны
Вывод производится из метода конечного контроллера с использованием MNBVf::render или
непосредственно запуском из контроллера шаблона вывода (модуль default).

Поддерживаются форматы: html, txt, json. На формат вывода влияет входной параметр "tpl_mode",
принимающий значения: "html", "txt", "json".

Если используется метод MNBVf::render, то в него передается алиас дизайна, корневой файл
шаблона страницы, массив с отображаемыми данными и тип формата вывода.

В шаблонах могут использоваться виджеты для вывода меню, блоков предпросмотра и иных
блоков дизайна. Виджеты поддерживают MVC и могут иметь свои контроллеры и view. Посмотрите
примеры реализации виджетов на шаблоне главной страницы демо сайта. Запуск виджета
производится методом MNBVf::startVidget(). Шаблоны дизайна виджетов имеют префиксы "wdg_"
и расположены в папке "units" в корне папки требуемого дизайна. Если виджет есть, он
использует шаблон, а его в текущем дизайне нет, то используется дефолтовый шаблон для
требуемого виджета из дизайна default. Контроллеры виджетов находятся в модуле "mnbv" в
папке "widgets".

Система позволяет использовать различные шаблоны для различных модулей, а в рамках работы
CMS.MNBV вы можете выбирать шаблоны в зависимости от запускаемого сайта (см. настройки сайта).

## Система логирования
Во всех местах системы доступно логирование с использованием методов SysLogs::addLog
и SysLogs::addError. Логи сохряняются и выводятся в соотетствии с настройками системы.
Логи и ошибки, если вы хотите могут выводиться непосредственно в момент возникновения
события, а также могут быть сохранены в файл в папку "tmp/logs". Использование встроенной
во фреймворк системы логов удобно для отладки и тестирования.

## Принцип организации системы управления данными в CMS, возможности системы
Система управления данными построена на базе универсальных модулей. что естественно упростило
и ускорило ее разработку. Также это позволяет и пользователю проще привыкнуть к интерфейсу.
Глобально управление идет на уровне работы с хранилищами, далее вы можете прейти в список
объектов хранилища и к редактированию требуемого объекта.

Вы можете управлять доступом на редактирование и чтение различных объектов хранилищ и их
приложенных файлов. Управление доступом идет на уровне групп пользователей. Настройка
разрешений для пользователя производится в хранилищах "Пользователи" и "Системные Пользователи".

Для более гибкой работы с хранилищами в режиме редактирования могут быть применены специальные
контроллеры для обработки входных данных и предварительных действий с данными и форматом их
вывода. Они размещаются вместе с контроллерами модуля, но имеют шаблон имени
"Storage[Название хранилища]Controller.class.php". Пример использования - контроллер в
редактировании задания робота.

## Базовый модуль CMS, рабочии модули, схема вызова модулей
Базовый модуль MMS называется "mnbv". Он содержит основные классы, конфиги и т.п. По результатам
работы маршрутизатора из него вызыватся уже модуль системы MNBV. Эти модули имеют типовые фронт
контроллеры, которые ссылаются на "modules_index.php". Посмотрите работу на примерах отдельных
модулей. Схема простая, вы быстро разберетесь. Работа конечных модулей системы MNBV идет по аналогии
с работой конечных модулей фрейморка.

## Работа с различными языками
Система поддерживает работу с несколькими языками. Основных языков - 2: основной и альтернативный.
При работе в админке вы работать с полями на 2х основных языках. В шаблонах и в остальных
местах вывод должен производиться с использованием системы словарей, поддерживаемых классом Lang.
Посмотрите примеры работы со словарями в модулях. Словари конечных модулей могут дополнять
словари корневых модулей. В файле каждого словаря могут быть заданы группы соответствий для
отдельных модулей. Файл словаря представляет собой php файл с описанием массива словаря и
применения его к текущему общему словарю с помощью метода Lang::addToDict. При выводе
полей одних хранилищ, связанных с другими могут быть использована замена алиасов по словарю.
Смотрите примеры релизации.

## Конфигурирование системы хранилищ, работа с различными базами данных, взаимосвязи
Работа с базами данных может вестись на уровне фреймворка и на уровне CMS. Остановимся на 2
варианте, т.к. с первым можно ознакомиться самостоятельно на примере модуля default.

На уровне CMS работа с базами данных ведется с использованием хранилищ. Хранилище - это
некий набор данных, объединенный общей структурой, правами доступа и некоторыми иными 
атрибутами. Если провести аналогию с MySQL, то хранилище - это таблица, однако 
оно может быть релизовано и на других технологиях (NoSQL базы, KeyValue базы, файлы, 
массивы,...). Хранилища содержат типовые объекты, которые имеют разные типы и могут
быть вложены друг в друга по принципу папок файловой системы. 

Конфигурирование баз данных ведется в конфиге модуля core с использованием SysStorage::setDb(),
однако вы можете делать это в других конфигах, в т.ч. в рамках модуля mnbv. После
установки БД будет доступен алиас с использованием которого будет вестись дальнейшая
работа с этой БД. Коннект произойдет при первом обращении к базе и будет сохранен
для дальнейшего использвания. 

Конфигурирование хранилищ и используемых баз данных ведется в конфиге модуля mnbv,
расположенном "modules/mnbv/config/storage.php". Фактически результатом работы данного
конфига будет формирование массива SysStorage::$storage, содержащего конфигурацию
и взаимосвязи всех хранилищ с привязкой к соответствующим им базам данных различных
типов.

В вышеуказанном файле сначала определяются служебные массивы определяющие: дефолтовую
структуру объекта в базе данных $storageDefStruArr, и дефолтовый формат отображения
данной структуры $storageDefViewArr, формат отображения списка объектов $storageDefListArr,
формат дефолтового отображения фильтров $storageDefFilterArr. В коде дано подробное 
описание формирования этих структур, по образу и подобию которых  вы можете формировать 
свои уникальные. Вышеперечисленные дефолтовые массивы нужны для того, чтобы вы
без необходимости не утяжеляли и без того достаточно массивный конфиг хранилищ.

Далее в конфиге хранилищ определяются сами хранилища в массивах типа 
SysStorage::$storage['site']. Конфиг хорошо документирован, описаны все варианты
его формирования. Естественно вы можете изменить формат настройки хранилищ, разделить
его на файлы по своему усмотрению и сделать так как это удобно вам.

Обратите внимание, что при конфигурировании формата отображения хранилища устанавливается
и метод проверки входных данных для него "checktype".

В конфиге хранилищ вы можете привязывать к полям иные хранилища с указанием
их алиасов и стартовых объектов.

В хранилище поля могут быть как самостоятельными (по ним возможны выборки), так и
сгруппированными в массив vars, а также по аналогии с vars могут создаваться наследуемые
динамически формируемые списки полей для вложенных папок. Посмотрите их настройку
в редактировании папок в интерфейсе администрирования. Последнее полезно например
при организации каталога товаров, где для разных категорий есть разные поля, 
часть из которых наследуется из родительских категорий.

## Многосайтовость, управление доменами, дизайнами, конфигурирование
Система поддерживает работу с несколькими доменами, прямо ограничение не установлено,
но видимо разумное какое-то существует. Для настройки многосайтовости есть хранлище
"Сайты". В этом хранилище создаются объекты, описывающие сайты, к которым могут быть
привязаны домены, хранилище корневой структуры сайта, идентификатор стартового 
объекта сайта (загрузка по дефолту), алиас выбранных шаблонов дизайна.

Вы можете достаточно гибко использовать структуру сайтов - показывать разные 
дизайны одной информационной структуры на разных доменах, задавать зеркала
и наверное еще как-то. 

Откройте имеющиеся сайты, ознакомьтесь с возможными параметрами их настройки.

## Работа с приложенными файлами. Изображения, видео, редактор изображений. Папки.
В админке CMS вы можете работать с приложенными изображениями любых объектов.
Можно закачивать различные типы изображений и иных файлов, пользоваться 
графическим редактором для предварительной подготовки изображений. Система
в ряде случаев производит автоматическое преобразование изображений при закачке.
В систему заложена возможность после закачки передать файл по месту хранения
на другом ресурсе. Данные о приложенных изображениях хранятся в базе данных,
запроса на наличие в файловой системе не производится. Подобная схема позволяет
организовывать распределенные системы хранения изображений.

## Управление служебными скриптами (роботами). Типы и задания роботов.
В системе есть 2 хранилища, содержащие типы роботов и задания роботов.
Задание робота - это объект, содержащий сведения о задании робота заданного типа
и статусе его выполнения. Через этот объект ведется управлением роботом, в т.ч.
его конфигурация, запуск, остановка..., а также мониторинг его вывода в
консоли сервера (в окошечке в интерфейсе). 

Запуск роботов можно проводить в ручном режиме из консоли с помощью скрипта 
"start_robot.php" или из интерфейса редактирования робота, также в конфиге 
вы можете задать возможность запуска робота по cron, при этом запускать его 
будет оболочка системы, которая сама уже запускается раз в минуту по крону. 
Запуск будет происходить в режиме демона каждый робот в отдельном процессе 
со своим идентификатором сессии. 

Роботы могут работать в бесконечном цикле. При этом в ряде случаев может происходит
их остановка. Для предотвращения последствий подобного развития событий в системе
есть робот, который мониторит состояние работающих роботов и перезапускает их, в
случае если в системе пропал активный процесс, соответствующий остановившимся
роботам, и... мы не встаем по ночам для запуска отвалившегося мегапарсера))).

## Фильтры списков
В режиме просмотра списков объектов как в админке, так и в любом другом месте
вы можете использовать фильтры. Настройка фильтров производится в конфиге хранилищ.

## Генерация URL.
К URL на сайте могут выдвигаться различные требования, связанные с SEO и иными
факторами. Формат вывода может быть с протоколом и доменом и в относительном
виде. Настройка формата вывода URL и префиксов URL для изображений производится
в хранилище "Сайты". Для формирования URL объектов используется системная функция
MNBVf::generateObjUrl(). Формирования URL приложенных изображений происходит во
время загрузки объектов методом MNBVf::getStorageObject() в массиве "file", 
для вывода специфических объектов, типа роликов гугля используем 
MNBVf::getObjCodeByURL(). При формировании URL не забывайте про стандартные 
механизмы и если используйте свои, то помните о настройках вывода URL для 
конкретного домена.


################################################################################
##  План развития
################################################################################

1. Доделать корзину и оформление заказа.
2. Сделать рекомендации по категории товаров + вы смотрели.
3. Сделать поиск + автокомплит + помощник поиска.
4. Подключить систему обработки событий.
5. Сделать настраиваемую систему выгрузки товарных фидов и других структур данных.
6. Сделать модуль анализа расхода ресурсов системы для мониторинга нагруженных систем.
7. Разработать и подключить универсальный бутстрап шаблон интернет-магазина.
8. Сделать вариант системы управления метатегами на основе шаблонов и исключений.
9. Подключить поддержку отзывов + оценка и рейтинг объектов.
10. Сделать систему голосований.
11. Плановые доработки по классам работы с разными типами БД.



