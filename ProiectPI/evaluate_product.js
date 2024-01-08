// evaluate_product.js

$(document).ready(function() {
    // Ascultă evenimentul de clic pe stele
    $('.star').on('click', function() {
        // Obține id-ul produsului și numărul de stele selectate
        var productId = $(this).data('product-id');
        var rating = $(this).data('rating');

        // Trimite datele prin AJAX la evaluate_product.php
        $.ajax({
            type: 'POST',
            url: 'evaluate_product.php',
            data: { productId: productId, rating: rating },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Stelele au fost salvate cu succes
                    console.log("Stars saved successfully");
                } else {
                    // A apărut o eroare la salvarea stelelor
                    console.error("Error saving stars: " + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        });
    });
});
