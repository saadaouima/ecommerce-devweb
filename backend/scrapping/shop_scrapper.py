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
    url = 'https://www.bazar-bio.fr/4-cheveux-bio'
    response = requests.get(url, headers=headers)

    soup = BeautifulSoup(response.content, 'html.parser')


    products = soup.find_all('div', class_='product-container')



    i= 0
    image_index = 1
for product in products:
    # Generate a random integer between 50 and 100
    quantity = random.randint(50, 100)
    product_uuid =  uuid.uuid4()
    name = product.find('a', class_='product-name').text.strip()
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
    
    image_folder = "C:/Users/marie/Documents/images/" 
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
        image_list.append({'image filename' : img_filename, 'Product Id' : product_uuid}) 
        
    
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
    product_list.append({ 'Id' : product_uuid, 'Name': name, 'Price': price, 'Accroche':accroche, 'Manufactrer Name' :  manufactrer_name, 'URL' : href,'Details' : details, 'Composition' : composition, 'Utilisation' : utilisation,  'Short description': short_description, 'Contenance' : contenance, 'Quantity' : quantity  })
    i=i+1
    if i==1:
        break

