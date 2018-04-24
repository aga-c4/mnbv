<?php
/**
 * Механизм обработки файлов миграций
 * запускаем так:
 * php migration.php db=Название_базы v=номер версии
 * номер версии - необязательный параметр, при первоначальном запуске его обязательно указывать, далее он будет браться
 * из файла конфигурации.
 *
 * Скрипт работает с текущей папкой, вы можете размещать его в требуемом вам месте.
 * Скрипт находит папку с названием как у названия базы в нижнем регистре, в ней находит папку требуемой версии типа "v1"
 * Если еще не было никаких действий по базе, то используется базовый дамп, имеющий дефолтовое название "baseline.sql".
 * Далее последовательно применяются файлы миграфий по возрастанию их номера. При применении файлов миграций их названия
 * фиксируются в текстовом файле на базе имени базы данных типа "ИМЯ_БАЗЫ-status.txt" (все название в нижнем регистре).
 * Первой записью данного файла будет baseline.sql, если база уже была восстановлена из дампа. Программа из требуемой
 * директории последовательно откроет и применит файлы миграций по возрастанию их номера, исключив при этом те из них,
 * которые уже перечислены в файле статусов. В файле фиксируются записи типа:
 * Название файла|timestamp-start|timestamp-stop|Версия|Подверсия|date-stop
 *
 * Механизм миграций не будет работать, если последняя запись не имеет меток времени окончания миграции.
 *
 * Названия файлов миграций формируются по принципу:
 * Номер-файла.Номер-версии.Номер-подверсии.расширение. Пример: 0001.03.07.sql В результате база после обновления будет
 * иметь версию 03.07
 *
 * Миграция не будет применена и процесс будет остановлен, если в файле статусов миграций уже есть файл миграции с
 * номером, который мы применяем в текущий момент. В этом случае будет выдано предупреждение об ошибке с просьбой в
 * ручном режиме решить эту проблему. Ручной режим требуется для уделения повышенного внимания возможным коллизиям.
 *
 * В файле конфигурации первая запись означает версию БД в формате: Номер-версии.Номер-подверсии
 *
 * Скрипт имеет режим, при котором будут отданы текущая версия и список файлов миграций, готовых к установке.
 *
 * Скрипт имеет режим создания дампа базы данных, в результате в папке dumps появится файл типа:
 * Название-базы_Номер-версии_Номер-подверсии_data.расширение
 *
 * В массиве конфигурации указываются для каждой базы:
 * - доступы к базе,
 * - шаблон команды для выполнения файла миграции,
 * - шаблон команды для создания дампа,
 * - расширение файлов миграции и дампов.
 *
 * В массиве конфигурации можно указать сведения о разных базах и соответственно работа с ними будет зависить от их
 * типов и особенностей.
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * License: BSD 2-Clause License
 * Date: 24.04.18
 */

chdir(__DIR__);

