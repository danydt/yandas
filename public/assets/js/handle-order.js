$('[type="button"]').click(function () {

    addToCart();
});

/*
This method adds html form elements to a specific html table element
 */
function addToCart() {

    let product_name = $('#exampleFormControlInput1').val(),
        product_url = $('#exampleInputUrl1').val(),
        product_quantity = $('#exampleInputNumber1').val(),
        product_description = $('#exampleFormControlTextarea4').val();

    // check that all the variables contains values
    if (product_name && product_url && product_quantity && product_description) {

        // prepare to add a new row to the HTML Table Element
        let table_body = $('.table-stripped tbody');

        // create a new row
        let row = '<tr><td>' + product_name + '</td>';
        row += '<td>' + product_url + '</td>';
        row += '<td>' + product_quantity + '</td>';
        row += '<td>' + product_description + '</td></tr>';

        table_body.append(row);
    }

}
