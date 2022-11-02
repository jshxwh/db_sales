var itemCount = 0;
var priceTotal = 0.00;
var quantity = 0;
var clone = "";

$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/item",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                // console.log(key);
                id = value.item_id;
                var item = "<div class='item'><div class='itemDetails'><div class='itemImage'><img src=" + "/storage/" + value.imagePath +
                    " width='200px', height='200px'/></div><div class='itemText'><p class='price-container'>Price: Php <span class='price'>" + value.sell_price +
                    "</span></p><p>" + value.description + "</p></div><input type='number' class='qty' name='quantity' min='1' max='5'><p class='itemId' hidden>" + value.item_id +
                    "</p>      </div><button type='button' class='btn btn-primary add' style='margin-top:5px;'>Add to cart</button></div>";
                $("#items").append(item);

            });

        },
        error: function () {
            console.log('AJAX load did not work');
            alert("error");
        }
    });


    $("#items").on('click', '.add', function () {
        itemCount++;
        $('#itemCount').text(itemCount).css('display', 'block');
        clone = $(this).siblings().clone().appendTo('#cartItems')
            .append('<button class="removeItem">Remove Item</button>');
        var price = parseInt($(this).siblings().find('.price').text());
        priceTotal += price;
        $('#cartTotal').text("Total: $" + priceTotal);
    });


    $('.openCloseCart').click(function () {
        $('#shoppingCart').toggle();
    });

    $('#shoppingCart').on('click', '.removeItem', function () {
        $(this).parent().remove();
        itemCount--;
        $('#itemCount').text(itemCount);

        // Remove Cost of Deleted Item from Total Price
        var price = parseInt($(this).siblings().find('.price').text());
        priceTotal -= price;
        $('#cartTotal').text("Total: php" + priceTotal);

        if (itemCount == 0) {
            $('#itemCount').css('display', 'none');
        }
    });

    $('#emptyCart').click(function () {
        itemCount = 0;
        priceTotal = 0;

        $('#itemCount').css('display', 'none');
        $('#cartItems').text('');
        $('#cartTotal').text("Total: $" + priceTotal);
    });

    $('#checkout').click(function () {
        itemCount = 0;
        priceTotal = 0;
        let items = new Array();

        $("#cartItems").find(".itemDetails").each(function (i, element) {
            // console.log(element);
            let itemid = 0;
            let qty = 0;

            qty = parseInt($(element).find($(".qty")).val());
            itemid = parseInt($(element).find($(".itemId")).html());

            items.push({
                "item_id": itemid,
                "quantity": qty
            });

        });
        console.log(JSON.stringify(items));
        var data = JSON.stringify(items);

        $.ajax({
            type: "POST",
            url: "/api/item/checkout",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            processData: false,
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                console.log(data);
                alert(data.status);
            },
            error: function (error) {
                alert(data.status);
            }
        });
        $('#itemCount').css('display', 'none');
        $('#cartItems').text('');
        $('#cartTotal').text("Total: P" + priceTotal);
        $('#shoppingCart').css('display', 'none');

        // console.log(clone.find(".itemDetails"));

    });
})
