FLAG=`cat /app/flag.txt`

echo "mysql_user=HackfestUser" > /app/.env
echo "mysql_pwd=seCR3T_p@ssw0rD" >> /app/.env
echo "mysql_host=127.0.0.1" >> /app/.env
echo "mysql_db=17ed80ddc97e283e7e299e4a7d591a46" >> /app/.env

sed -i -e "s/HACKFEST{template}/$FLAG/g" /app/db.sql

mysqld_safe &   # démarre le serveur MySQL en arrière-plan 

echo "Wait a second"

while ! mysql -e "select NOW(); " 2>/dev/null; do    # utilisée pour vérifier si MySQL est prêt.
	sleep 1
done

echo "MYSQL server created. Waiting for databases"

mysql < /app/db.sql     # importe le fichier db.sql dans la base de données MySQL

while ! mysql -e "use 17ed80ddc97e283e7e299e4a7d591a46; select NOW() from operations;" 2>/dev/null; do
	sleep 1
done    # boucle attend que la base de données 17ed80ddc97e283e7e299e4a7d591a46 soit créée et prête en vérifiant la connexion à cette base de données toutes les secondes.

echo "Databases created"

cd /app && gunicorn --bind 0.0.0.0:7331 --workers=2 wsgi:app
