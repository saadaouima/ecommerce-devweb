#!/usr/bin/env python
# coding: utf-8



# In[1]:


import requests
from bs4 import BeautifulSoup
import pandas as pd
import pyodbc
import os
import uuid
import random
import mysql.connector
from datetime import datetime, timedelta


# In[2]:


def random_datetime(start: str, end: str, date_format="%Y-%m-%d %H:%M:%S") -> datetime:
    """
    Generate a random datetime between two datetime strings.
    
    Parameters:
    - start (str): Start datetime in the given format.
    - end (str): End datetime in the given format.
    - date_format (str): Format of input and output datetime strings.
    
    Returns:
    - A random datetime object.
    """
    start_dt = datetime.strptime(start, date_format)
    end_dt = datetime.strptime(end, date_format)
    delta = end_dt - start_dt
    random_seconds = random.randint(0, int(delta.total_seconds()))
    return start_dt + timedelta(seconds=random_seconds)


# In[3]:


image_folder = "C:/Users/marie/Desktop/Projet DevWeb2/ecommerce-devweb/frontend/assets/products_images"
start_date = "2025-01-01 00:00:00"
end_date = "2025-04-09 23:59:59"


# In[7]:


# Connect to MySQL (WAMP)
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="eshop"  # Change this to your actual database name
)

cursor = conn.cursor()

cursor.execute("DROP TABLE products")
conn.commit()

cursor.execute("DROP TABLE images")
conn.commit()
    
    
                

# Create table if it doesn't exist
cursor.execute("""
    CREATE TABLE IF NOT EXISTS products (
        Id CHAR(36) PRIMARY KEY,
        Name VARCHAR(255),
        Price DECIMAL(10,2),
        Accroche TEXT,
        Manufacturer_Name VARCHAR(255),
        URL TEXT,
        Details TEXT,
        Composition TEXT,
        Utilisation TEXT,
        Short_Description TEXT,
        Contenance VARCHAR(50),
        Quantity INT,
        Category VARCHAR(255),
        Created_At DATETIME DEFAULT CURRENT_TIMESTAMP
    )
""")

conn.commit()
cursor.execute("""
    CREATE TABLE IF NOT EXISTS images (
        Id CHAR(42) PRIMARY KEY,
        product_id CHAR(36),
        FOREIGN KEY (product_id) REFERENCES products(Id) ON DELETE CASCADE
    )
""")

conn.commit()


# In[9]:


product_list = []
image_list = []

# Dictionary with categories as keys and links as values
categories = {
    "Visage": "https://www.bazar-bio.fr/2-soins-visage-bio",
    "Outils de Massage": "https://www.bazar-bio.fr/117-outils-de-massage",
    "MAQUILLAGE": "https://www.bazar-bio.fr/5-maquillage-bio",
    "CORPS": "https://www.bazar-bio.fr/3-soins-corps-bio",
    "CHEVEUX": "https://www.bazar-bio.fr/4-cheveux-bio"
}
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
}
for key, value in categories.items():
    print(f"Catégorie: {key}, Lien: {value}")
    url = value

    response = requests.get(url, headers=headers)
    
    soup = BeautifulSoup(response.content, 'html.parser')
    
    
    products = soup.find_all('div', class_='product-container')
    
    
    number_of_products = random.randint(10, 30)
    i= 0
    image_index = 1
    for product in products:
        # Generate a random integer between 50 and 100
        quantity = random.randint(50, 100)
        product_uuid =  uuid.uuid4()
        name = product.find('a', class_='product-name').text.strip()
        created_at = random_datetime(start_date, end_date)
        # Find all anchor tags within this container and extract href
        links = product.find_all('a', href=True)
        #print(links(0))
        for link in links:
            href = link['href']
            break
            print(href)  # Print the href found in the container
        product_details_response = requests.get(href, headers=headers)
        #print(product_details_response.text)
        product_details_soup = BeautifulSoup(product_details_response.content, 'html.parser')
        details_list = product_details_soup.find_all('div', class_='rte')
         # Extract image URL
        images = product_details_soup.find_all('img', itemprop='image')
        
         
         
            
        
        details=details_list[1].text.strip()
        short_description = product_details_soup.find('div', id='short_description_content').text.strip()
        composition_container = product_details_soup.find('div', id='composition')
        if composition_container :
            composition = composition_container.text.strip()
        else:
            composition = None
            
        product_details_list = product_details_soup.find_all('section', class_='page-product-box')
        if product_details_list[0].text.find("Contenance") == -1:
            contenance= None
        else:
            contenance =product_details_list[0].find_all('p')[0].text.strip().replace("Contenance :", "").strip()
        #vegan = product_details_soup.find('div', style='text-transform: uppercase;font-family:Bazar_Bold; font-size:11px;').text.strip()
        rte = product_details_soup.find_all('div', class_='rte collapse')
        if len(rte) == 2:
            utilisation = rte[1].text.strip()
        else:
            utilisation = None
            
        #for d in rte:
            #print("---------------")
            #print(d.text.strip())
        #url = product.find('a', href).text.strip()
        price = product.find('span', class_='price product-price').text.strip()
        accroche = product.find('p', class_='accroche').text.strip()
        manufactrer_name = product.find('h5', class_='manufacturer-name').text.strip()
        # SQL query to insert data
        sql = """
            INSERT INTO products (Id, Name, Price, Accroche, Manufacturer_Name, URL, Details, Composition, Utilisation, Short_description, Contenance, Quantity, Category, Created_At) 
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        
        
        # Execute query
        cursor.execute(sql, (str(product_uuid), str(name), str(price), str(accroche), str(manufactrer_name), str(href), str(details), str(composition), str(utilisation), str(short_description), str(contenance), str(quantity), str(key), str(created_at)))


        conn.commit()
        product_list.append({ 'Id' : product_uuid, 'Name': name, 'Price': price, 'Accroche':accroche, 'Manufactrer Name' :  manufactrer_name, 'URL' : href,'Details' : details, 'Composition' : composition, 'Utilisation' : utilisation,  'Short description': short_description, 'Contenance' : contenance, 'Quantity' : quantity, 'Category' : key  })
        for image in images:
            #if not img_tag:
            #continue
            
            img_url = image['src']
        
            # Download image
            img_data = requests.get(img_url).content
            img_filename = f"{product_uuid}_{image_index}.jpg"
            img_path = os.path.join(image_folder, img_filename)
            image_index = image_index +1
            
            with open(img_path, "wb") as f:
                f.write(img_data)
            # SQL query to insert data into product_images
            sql = "INSERT INTO images (Id, product_id) VALUES (%s, %s)"
            
            # Execute query with the values one by one
            cursor.execute(sql, (str(img_filename), str(product_uuid)))
            conn.commit()
            image_list.append({'image filename' : img_filename, 'Product Id' : product_uuid})
        i=i+1
        if i== number_of_products:
            break
# Close the connection
cursor.close()
conn.close()




