#!/bin/bash
#sh vgbackup.sh "SITE_NAME" "BACKUP_FOLDER" "DB_NAME" "DB_SERVER" "DB_USER" "DB_PASS"

#текущая директория
SCRIPT=`realpath $0`
SCRIPTPATH=`dirname $SCRIPT`

#тип, сохранить или распаковать
if [ -z $1 ]; then echo 'Error: empty ACTION_TYPE: save or reestablish'; exit; else ACTION_TYPE=$1; fi;


#Имя сайта
if [ -z $2 ]; then echo 'Error: empty SITE_NAME'; exit; else SITE_NAME=$2; fi;

#Папка с файлами сайта для копирования файлов
if [ -z $3 ]; then echo 'Error: empty BACKUP_FOLDER'; exit; else BACKUP_FOLDER=$3; fi;

#Настрйоки БД
if [ -z $4 ]; then echo 'Error: empty DB_NAME'; exit; else DB_NAME=$4; fi;
if [ -z $5 ]; then echo 'Error: empty DB_SERVER'; exit; else DB_SERVER=$5; fi;
if [ -z $6 ]; then echo 'Error: empty DB_USER'; exit; else DB_USER=$6; fi;
if [ -z $7 ]; then echo 'Error: empty DB_PASS'; exit; else DB_PASS=$7; fi;

DIR="$SCRIPTPATH/vgbackup/$SITE_NAME"

#создаем копию сайта
if [ $1 == "save" ]; then 

#создадим папку для копий
mkdir -p $DIR

#Создаем копию БД, в название текущий день
mysqldump -u$DB_USER -h$DB_SERVER  -P3306 -p$DB_PASS $DB_NAME | gzip > $DIR/db.`date +"%Y-%m-%d"`.sql.gz

#Создаем архив с файлами сайта
tar -czf $DIR/file.`date +"%Y-%m-%d"`.tar.gz $SCRIPTPATH/$BACKUP_FOLDER

echo "completed"
exit;


 
elif [ $1 == "reestablish" ] ;then 

if [ -z $8 ]; then echo 'Error: empty BACKUP_DATE'; exit; else BACKUP_DATE=$8; fi;


#восстанавливаем бд
gunzip < "$DIR/db.$BACKUP_DATE.sql.gz" | mysql -u$DB_USER -h$DB_SERVER  -P3306 -p$DB_PASS $DB_NAME
#распаковываем файлы
tar -C / -xf $DIR/file.$BACKUP_DATE.tar.gz
echo "completed"
exit;

fi;