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
. ├── scrapper.py # Main scraping script
└── assets/
└── products_images/ # Folder to store downloaded images

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

