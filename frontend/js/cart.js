document.querySelectorAll('.cart-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();  // stop link default behavior
      const productId = this.getAttribute('data-id');
      const quantityInput = this.closest('.product__details__button').querySelector('.quantity-input').value;
      alert(quantityInput)
      fetch('../../backend/controllers/CartController.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + productId  + '&quantity=' + quantityInput
      })
      .then(response => response.text())
      .then(data => {
        console.log(data);  // or display a message
        alert('Product added to cart!' + data );
      });
    });
  });  