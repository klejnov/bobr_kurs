TRUNCATE `banks_kurs_log`;
ALTER TABLE `banks_kurs_log`ADD COLUMN `type_log` ENUM('limits exceeded','regular log') NULL AFTER `html`;
ALTER TABLE `banks_kurs_log`CHANGE COLUMN `type_log` `type_log` ENUM('limits exceeded','regular log') NULL DEFAULT NULL COMMENT '* 1 - limits exceeded (превышены лимиты)\r\n* 2 - regular log (обычный лог)' AFTER `html`;
