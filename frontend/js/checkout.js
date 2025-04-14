document.getElementById('submitCheckout').addEventListener('click', function(e) {
    e.preventDefault();
  
    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
  //alert(form);
    // Debug: log all form values
    for (let pair of formData.entries()) {
      console.log(pair[0]+ ' = ' + pair[1]);
    }
  
    fetch('../../backend/controllers/UserController.php', {
      method: 'POST',
      body: new URLSearchParams(formData)
    })
    .then(response => response.text())
    .then(data => {
      //console.log(data);
      //alert('Order submitted! ' + data);
      window.location.href = '../pages/index.php'; // change this path to your actual homepage
    });
  });
  