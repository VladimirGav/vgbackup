# vgbackup - создание и восстановление резервных копий сайта

## Инструкция

### Посмотреть на [YouTube](https://www.youtube.com/watch?v=YlpkDVUyhVA)

  - Перенесите bash файл vgbackup.sh в папку выше сайта и установить права на выполнение
  - В корень сайта перенесите файл vgbackup.php и запустите его в браузере, после использования этот файл можно удалить
  - Копия сайта сохраняются в каталог vgbackup находящийся на одном уровне с vgbackup.sh
  - Для создания ежедневных резервных копий в автоматическом режиме, поставьте команду на cron:
```html
sh /Путь к файлу от корня/vgbackup.sh "save" "SITE_NAME" "BACKUP_FOLDER" "DB_NAME" "DB_SERVER" "DB_USER" "DB_PASS"
Пример: sh /var/www/data/www/vgbackup.sh "save" "vladimirgavrilov.ru" "vladimirgavrilov.ru" "vladimir" "localhost" "root" "123"
```
  - Для восстановления резервной копии через консоль:
```html
sh /Путь к файлу от корня/vgbackup.sh "reestablish" "SITE_NAME" "BACKUP_FOLDER" "DB_NAME" "DB_SERVER" "DB_USER" "DB_PASS" "2020-05-05"
Пример: sh /var/www/data/www/vgbackup.sh "reestablish" "vladimirgavrilov.ru" "vladimirgavrilov.ru" "vladimir" "localhost" "root" "123" "2020-05-05"
```


