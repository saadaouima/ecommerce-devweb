# ecommerce-devweb
# 📦 E-Commerce Product Scraper

This project is a Python-based web scraper designed to extract product data and images from an online cosmetics e-commerce store and store the information in a MySQL database. It also downloads product images locally.

---

## 📑 Features

- Scrapes product details (name, price, manufacturer, descriptions, composition, and more)
- Downloads product images to a local folder
- Inserts product and image data into a MySQL database
- Randomly generates product creation dates and stock quantities
- Categorizes products by type (Face, Body, Hair, Makeup, Massage Tools)

---

## 🛠️ Technologies Used

- **Python 3**
- **BeautifulSoup 4**
- **Requests**
- **MySQL Connector (mysql-connector-python)**
- **Pandas**
- **UUID**
- **Datetime**
- **WAMP Server (MySQL Database)**

---

## 📂 Project Structure
📂 ecommerce_project/
├── 📂 frontend/ (HTML, CSS, JavaScript – Interface utilisateur)
│ ├── 📂 assets/ (images, icônes, polices...)
│ ├── 📂 css/ (fichiers CSS pour le design)
│ ├── 📂 js/ (scripts JavaScript pour l’interactivité)
│ ├── 📂 pages/ (pages principales du site)
│ │ ├── index.html (page d’accueil)
│ │ ├── product.html (page produit détaillée)
│ │ ├── cart.html (panier d'achat)
│ │ ├── checkout.html (commande et paiement)
│ │ ├── login.html (authentification)
│ │ ├── register.html (inscription)
│ │ ├── profile.html (profil utilisateur)
│ │ ├── contact.html (page contact)
│ │ ├── about.html (à propos)
│ ├── 📜 script.js (code général en JS : animations, AJAX, etc.)

├── 📂 backend/ (PHP, MySQL – Traitement serveur)
│ ├── 📂 includes/ (fichiers PHP réutilisables : connexion DB, fonctions...)
│ │ ├── db_connect.php (connexion à la base de données)
│ │ ├── functions.php (fonctions utilitaires : ajout au panier, etc.)
│ ├── 📂 controllers/ (traitement des requêtes utilisateurs)
│ │ ├── userController.php (gestion des utilisateurs)
│ │ ├── productController.php (gestion des produits)
│ │ ├── cartController.php (gestion du panier)
│ ├── 📂 models/ (modèles pour gérer les données MySQL)
│ │ ├── User.php (modèle utilisateur)
│ │ ├── Product.php (modèle produit)
│ │ ├── Order.php (modèle commande)
│ ├── 📂 api/ (APIs pour le frontend AJAX, gestion API REST, Web Scraping...)
│ │ ├── fetch_products.php (API pour récupérer les produits)
│ │ ├── scrap_products.php (script de web scraping pour extraire des produits)

├── 📂 database/ (SQL – Schéma et données initiales)
│ ├── ecommerce.sql (script pour créer la base de données et les tables)

├── 📂 documentation/ (Documentation LaTeX, wireframes Figma, etc.)
│ ├── schema_DB.pdf (schéma de la base de données)
│ ├── wireframes.fig (maquettes UI/UX sur Figma)
│ ├── rapport.tex (rapport en LaTeX)

⚙️ Setup Instructions
Clone the repository

git clone https://github.com/yourusername/your-repo-name.git
cd your-repo-name

Install Dependencies

pip install requests beautifulsoup4 pandas mysql-connector-python

Setup MySQL Database

Create a database named eshop

Adjust database credentials in scrapper.py:


conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="eshop"
)
Run the Scraper

python scrapper.py

📌 Notes
Images are saved to the path:
C:/Users/marie/Desktop/Projet DevWeb2/ecommerce-devweb/frontend/assets/products_images/
(You can adjust this in the script)

The scraper is designed for the bazar-bio.fr website. Modify category URLs as needed.

📸 Demo
Add screenshots or a short GIF demo here if you’d like.

📄 License
This project is open-source and available under the MIT License.

✨ Author
Your Name – @yourgithubusername

