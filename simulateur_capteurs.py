import mysql.connector
import random
from datetime import datetime

try:
    # Connexion à la base de données
    # Remplace 'admin_serre' et 'ton_mot_de_passe' par tes vrais identifiants
    connection = mysql.connector.connect(
        host='localhost',
        database='serre_db',
        user='user',
        password='admin'
    )

    if connection.is_connected():
        cursor = connection.cursor()
        
        # On génère une humidité réaliste (ex: entre 45% et 65%)
        humidite = round(random.uniform(45.0, 65.0), 2)
        maintenant = datetime.now()

        # Insertion
        sql = "INSERT INTO capteurs (humidite, date_mesure) VALUES (%s, %s)"
        cursor.execute(sql, (humidite, maintenant))
        
        connection.commit()
        print(f"[{maintenant}] Donnée envoyée : {humidite}%")

except mysql.connector.Error as e:
    print(f"Erreur : {e}")

finally:
    if 'connection' in locals() and connection.is_connected():
        cursor.close()
        connection.close()
