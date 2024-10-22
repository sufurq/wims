

function calculateAmount() {
    var unitPrice = parseFloat(document.getElementById("unit_price").value) || 0;
    var quantity = parseFloat(document.getElementById("quantity").value) || 0;

    var amount = unitPrice * quantity;

    document.getElementById("amount").value = amount.toFixed(2);
}