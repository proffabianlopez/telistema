!/bin/bash
cd /home/telistema/telistema/shells
ENV_FILE="/home/telistema/telistema/.env"
export $(grep -v '^#' "$ENV_FILE" | xargs)
BACKUP_CLIENT="Telistema"
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
DATE_PREV=$(date +%Y%m%d --date='-28 day') #Fecha de hace 28 dias para la eliminacion de duplicados.
BACKUP_DIR_DB="../database_dump/" #Directorio donde se va a guardar el archivo zipeado
echo "---------------------------------------------------------------------------"
echo $(date +%Y-%m-%d\ %H:%M:%S)" Inicio de backup ..."
echo "---------------------------------------------------------------------------"
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 1: Iniciando MYSQLDUMP para base de datos (tablas InnoDB)"
docker exec mysql_server sh -c 'exec mysqldump --no-tablespaces -u'$MYSQL_USER' -p'$MYSQL_PASSWORD' '$MYSQL_DB' | sed "s/\t/-/g"' > $BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 1: Completado!"
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 2: Generando compresion de archivos..."
zip $BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip $BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 2: Completado! Comprimido en >> "$BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 3: Eliminando temporales..."
rm -r $BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 3: Completado! Se elimino el archivo.".$BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 4: Moviendo backup a directorio de backups a ".$BACKUP_DIR_DB
mv $BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip "../database_dump/"$BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 4: Completado! Se movio el archivo a >> "$BACKUP_DIR_DB/$BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip
# elimina backup de dias atras
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 5: Eliminando datos de backups de dias anteriores..."
rm ../database_dump/$BACKUP_CLIENT._BKP_.$DATE_PREV*
echo $(date +%Y-%m-%d\ %H:%M:%S)" Paso 5: Completado! Eliminados los archivos con nombre >> "$BACKUP_DIR_DB/$BACKUP_CLIENT._BKP_.$DATE_PREV*
echo "---------------------------------------------------------------------------"
echo $(date +%Y-%m-%d\ %H:%M:%S)" ...Backup completado!!"
echo "---------------------------------------------------------------------------"
