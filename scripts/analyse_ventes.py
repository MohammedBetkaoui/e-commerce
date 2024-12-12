import mysql.connector
import matplotlib.pyplot as plt
from decimal import Decimal
import json


def convert_decimal(value):
    """Convertit les objets Decimal en float pour JSON sérialisable."""
    if isinstance(value, Decimal):
        return float(value)
    raise TypeError(f"Type {type(value)} non sérialisable")


def analyse_ventes():
    try:
        # Connexion à la base de données
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="db"
        )
        print("Connexion réussie à la base de données.")
        
        cursor = connection.cursor(dictionary=True)

        # Requête SQL optimisée
        query = """
            SELECT p.nom_produit, 
                   SUM(c.quantité) AS total_quantite, 
                   SUM(c.prix_total) AS total_ventes
            FROM commandes c
            JOIN produits p ON c.id_produit = p.id
            GROUP BY p.nom_produit
            ORDER BY total_ventes DESC
        """
        cursor.execute(query)
        rows = cursor.fetchall()

        # Vérification des données
        if not rows:
            print("Aucune donnée trouvée.")
            return json.dumps([])

        # Préparation des données pour le graphique
        produits = [row['nom_produit'] for row in rows]
        ventes_totales = [convert_decimal(row['total_ventes']) for row in rows]
        quantites_vendues = [convert_decimal(row['total_quantite']) for row in rows]

        # Générer et afficher le graphique
        afficher_graphique(produits, ventes_totales, quantites_vendues)

        # Retour des données en JSON
        return json.dumps(rows, default=convert_decimal)

    except mysql.connector.Error as db_error:
        print(f"Erreur de connexion ou SQL : {db_error}")
        return json.dumps({"error": "Erreur de connexion ou SQL"})
    except Exception as e:
        print(f"Erreur inattendue : {e}")
        return json.dumps({"error": str(e)})
    finally:
        # Assurez-vous de fermer la connexion
        if 'cursor' in locals() and cursor:
            cursor.close()
        if 'connection' in locals() and connection.is_connected():
            connection.close()
            print("Connexion fermée.")


def afficher_graphique(produits, ventes_totales, quantites_vendues):
    """Affiche un graphique comparant les ventes totales et les quantités vendues."""
    fig, ax = plt.subplots(figsize=(10, 6))
    bar_width = 0.35
    index = range(len(produits))

    bar1 = ax.bar(index, ventes_totales, bar_width, label='Ventes Totales (Dz)', color='#ff9800')
    bar2 = ax.bar([i + bar_width for i in index], quantites_vendues, bar_width, label='Quantité Vendue', color='#4caf50')

    ax.set_xlabel('Produits')
    ax.set_ylabel('Valeur')
    ax.set_title('Analyse des Ventes par Produit')
    ax.set_xticks([i + bar_width / 2 for i in index])
    ax.set_xticklabels(produits, rotation=45, ha='right')
    ax.legend()

    plt.tight_layout()
    plt.show()


if __name__ == "__main__":
    print(analyse_ventes())
