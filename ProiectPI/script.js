document.addEventListener('DOMContentLoaded', function () {
    const ratingStars = document.getElementById('ratingStars');
    if (ratingStars) {
        const productId = ratingStars.getAttribute('data-product-id');
        let userRating = parseInt(ratingStars.getAttribute('data-user-rating')) || 0;
        const stars = ratingStars.querySelectorAll('.fa-star');

        stars.forEach(function (star, index) {
            star.addEventListener('click', function () {
                userRating = index + 1;
                rateProduct(productId, userRating);
            });

            star.addEventListener('mouseover', function () {
                highlightStars(index);
            });

            star.addEventListener('mouseout', function () {
                highlightStars(userRating - 1);
            });
        });
    }

    function rateProduct(productId, rating) {
        // Send an AJAX request to update the rating in the database
        // You can use XMLHttpRequest or fetch API for this
        // Example using fetch:
        let formData = new FormData();

        formData.append('productId', productId);
        formData.append('rating', rating);

        fetch('evaluate_product.php', {
            method: 'POST',
    
        body: formData,
         
                
        })
        
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the user rating in the DOM
                highlightStars(rating - 1);
                console.log('Product rated successfully');
            } else {
          
                console.error('Error rating product: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function highlightStars(index) {
        const stars = ratingStars.querySelectorAll('.fa-star');
        stars.forEach(function (star, i) {
            if (i <= index) {
                star.classList.add('rated');
            } else {
                star.classList.remove('rated');
            }
        });
    }
});
;


// Adaugă asta în funcția ta ready în script.js
$(document).ready(function() {
    $("#addproduct").submit(function(event) {
        event.preventDefault(); // Previne comportamentul implicit al formularului

        var productId = $(this).find('input[name="productId"]').val();
        var selectedSize = $(this).find('select[name="selected_size"]').val();
        var quantity = $(this).find('input[name="quantity"]').val();
        // Alte date pe care dorești să le trimiți

        $.ajax({
            type: "POST",
            url: "add_to_cart.php",
            data: {
                productId: productId,
                selectedSize: selectedSize,
                quantity: quantity,
                // Alte date
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    console.log("Product added to cart successfully");
                } else {
                    console.error("Error adding product to cart: " + response.error);
                }
            },
            error: function() {
                console.error("Error adding product to cart");
            }
        });


        $.ajax({
            type: "GET",
            url: "/cart.php?get=sum",
            dataType: 'json',
            success: function(data) {
                var dataArray = data;
               // alert(dataArray);
                $("#cartcount").text(dataArray);
                $("#cartcount").removeClass('bg-dark');
                $("#cartcount").addClass('bg-danger');
            }
        });

    });
});
$(document).ready(function(){

    $('#myCollapsible').collapse({
        toggle: false
      })

      
    $.ajax({
        type: "GET",
        url: "/cart.php?get=sum",
        dataType: 'json',
        success: function(data) {
            var dataArray = data;
           // alert(dataArray);
            $("#cartcount").text(dataArray);
            $("#cartcount").removeClass('bg-dark');
            $("#cartcount").addClass('bg-danger');
        }
    });
});


