#!/bin/bash
cd /home/telistema/telistema/shells
ENV_FILE="/home/telistema/telistema/.env"
export $(grep -v '^#' "$ENV_FILE" | xargs)

# Variables globales
BACKUP_CLIENT="Telistema"
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
DATE_PREV=$(date +%Y%m%d --date='-28 day')
BACKUP_DIR_DB="/home/telistema/telistema/database_dump/"
REMOTE_DIR_DB="/home/telistema_backups/database_dump"
REMOTE_USER="telistema_backups"
REMOTE_HOST="149.50.133.229"
REMOTE_PORT="5369"
EMAIL="systemmss2023@gmail.com"
SUBJECT="Backup completado - $BACKUP_CLIENT"

# Función para mensajes de error y salida
error_exit() {
    echo "\e[31mERROR: $1\e[0m" 1>&2
    exit 1
}

# Función para enviar correo
send_email() {
    local message="$1"
    echo "$message" | mail -s "$SUBJECT" "$EMAIL"
    
    # Verificar si el correo fue enviado con éxito
    if [ $? -eq 0 ]; then
        echo  "\e[32m$(date +'%d %B %Y, %H:%M:%S') Correo enviado exitosamente a $EMAIL!\e[0m"
    else
        echo "\e[31mFallo al enviar el correo a $EMAIL\e[0m"
    fi
}


# Función para generar el dump de MySQL
backup_mysql() {
    echo "\e[34m$(date +'%d %B %Y, %H:%M:%S') Paso 1: Iniciando MYSQLDUMP...\e[0m"
    docker exec mysql_server sh -c 'exec mysqldump --no-tablespaces -u'$MYSQL_USER' -p'$MYSQL_PASSWORD' '$MYSQL_DB' | sed "s/\t/-/g"' > $BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
    if [ $? -ne 0 ]; then
        error_exit "Fallo en MYSQLDUMP"
    fi
    echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') Paso 1: Completado!\e[0m"
}

# Función para comprimir el archivo
compress_backup() {
    echo "\e[34m$(date +'%d %B %Y, %H:%M:%S') Paso 2: Comprimendo archivo...\e[0m"
    zip $BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip $BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
    if [ $? -ne 0 ]; then
        error_exit "Fallo al comprimir el archivo"
    fi
    rm -r $BACKUP_CLIENT._BKP_.$BACKUP_DATE.sql
    echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') Paso 2: Completado!\e[0m"
}

# Función para mover el backup a la carpeta local
move_local_backup() {
    mv $BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip "$BACKUP_DIR_DB/$BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip"
    if [ $? -ne 0 ]; then
        error_exit "Fallo al mover el archivo a la carpeta local"
    fi
    echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') Paso 3: Backup movido localmente!\e[0m"
}

# Función para copiar el archivo al VPS
copy_to_vps() {
    echo "\e[34m$(date +'%d %B %Y, %H:%M:%S') Paso 4: Copiando al VPS...\e[0m"
    scp -P $REMOTE_PORT $BACKUP_DIR_DB/$BACKUP_CLIENT._BKP_.$BACKUP_DATE.zip $REMOTE_USER@$REMOTE_HOST:$REMOTE_DIR_DB
    if [ $? -ne 0 ]; then
        error_exit "Fallo en la copia al VPS"
    fi
    echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') Paso 4: Backup copiado al VPS!\e[0m"
}

# Función para eliminar backups antiguos en el VPS
clean_remote_backups() {
    echo "\e[34m$(date +'%d %B %Y, %H:%M:%S') Paso 5: Eliminando backups antiguos en el VPS...\e[0m"
    
    # Verificar si hay backups antiguos antes de intentar eliminarlos
    FILES=$(ssh -p $REMOTE_PORT $REMOTE_USER@$REMOTE_HOST "ls $REMOTE_DIR_DB/$BACKUP_CLIENT._BKP_.$DATE_PREV* 2>/dev/null")
    
    if [ -z "$FILES" ]; then
        echo "\e[33m$(date +'%d %B %Y, %H:%M:%S') No se encontraron backups antiguos en el VPS para eliminar.\e[0m"
    else
        ssh -p $REMOTE_PORT $REMOTE_USER@$REMOTE_HOST "rm -r $REMOTE_DIR_DB/$BACKUP_CLIENT._BKP_.$DATE_PREV*" || error_exit "Fallo al eliminar backups antiguos en el VPS"
        echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') Paso 5: Completado! Backups antiguos eliminados en el VPS!\e[0m"
    fi
}

# Función para eliminar backups locales antiguos
clean_local_backups() {
    echo "\e[34m$(date +'%d %B %Y, %H:%M:%S') Paso 6: Eliminando backups locales antiguos...\e[0m"
    
    # Verificar si hay backups locales antiguos antes de intentar eliminarlos
    if ls $BACKUP_DIR_DB/$BACKUP_CLIENT._BKP_.$DATE_PREV* 1> /dev/null 2>&1; then
        rm $BACKUP_DIR_DB/$BACKUP_CLIENT._BKP_.$DATE_PREV*
        echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') Paso 6: Backups locales antiguos eliminados!\e[0m"
    else
        echo "\e[33m$(date +'%d %B %Y, %H:%M:%S') No se encontraron backups locales antiguos para eliminar.\e[0m"
    fi
}


# Registro del inicio de la operación
echo "---------------------------------------------------------------------------"
echo "\e[34m$(date +'%d %B %Y, %H:%M:%S') Inicio de backup ...\e[0m"
echo "---------------------------------------------------------------------------"

# Ejecución de funciones
backup_mysql
compress_backup
move_local_backup
copy_to_vps
clean_remote_backups
clean_local_backups

# Registro del fin de la operación
echo "---------------------------------------------------------------------------"
echo "\e[32m$(date +'%d %B %Y, %H:%M:%S') ...Backup completado!!\e[0m"
echo "---------------------------------------------------------------------------"

# Enviar correo electrónico de notificación
BACKUP_DATE=$(date +'%d %B %Y a las %H:%M:%Shs.')
send_email "El backup de $BACKUP_CLIENT se completó exitosamente el $BACKUP_DATE"