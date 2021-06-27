// the functions below calls in product-list.content.php and add items in order_items table
  // we throw item variable id to tb products_cart by the function onAdd
  function send_request(id, price) {
    // alert("Heloo");
    // code below grabs value from input element with correct id of item 
      var quantity_of_item = document.getElementById(id).value;
      // the code below passes price from hidden field to item_cart_script
      var price = $('#price_' + id).val();
    
    $.ajax({                            
        type: "POST",
        url: url+"://greenbro."+domen_part+"/item/add_item_to_cart",
        data: {id: id , quantity_of_item: quantity_of_item, price: price},
        success: function(data, textStatus, jqXHR) {
          // the code below reload shopping-cart-container and displays correct info of item after updating 
          $("#display_reload_cart_item").load(url+"://greenbro."+domen_part+"/cart/show_cart_item/" + ' #cart_item_code');
            // alert(id);
            // alert(data);
            // alert(quantity_of_item);
            // alert(price);
        },
        error: function(data) {
          alert("Error in onAdd funciton");
        }
    });
    
}
