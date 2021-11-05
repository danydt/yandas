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
        let row = '<tr>';
        row += '<tr><td>' + product_name + '</td>';
        row += '<td>' + product_url + '</td>';
        row += '<td>' + product_quantity + '</td>';
        row += '<td>' + product_description + '</td>';
        row += '<td><a href="#" onclick="return removeItemToHtmlTable(this);"><span class="fa fa-times"></span></a></td>';

        // add hidden html input to the row
        row += '<input type="hidden" name="articles[]" value="' + product_name + '">';
        row += '<input type="hidden" name="urls[]" value="' + product_url + '">';
        row += '<input type="hidden" name="quantities[]" value="' + product_quantity + '">';
        row += '<input type="hidden" name="descriptions[]" value="' + product_description + '">';

        row += '</tr>';

        table_body.append(row);

        document.getElementById('formNoSubmit').reset();
    }

    function removeItemToHtmlTable(e) {

        //$(e).closest('tr').remove();
        return false;
    }

}
