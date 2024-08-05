$(function () {

    $('body').on('click', '.to-cart', function () {
        $productId = $(this).data('id');
        $productQuantity = $(this).closest('.product-action').find('input').val();

        $.post("/ajx/addToCart.php", { PRODUCT_ID: $productId, QUANTITY: $productQuantity })
            .done(function(data) {
                if(data == 1) {
                    BX.onCustomEvent('OnBasketChange');
                    $('[data-dropdown-toggle=cart]').trigger('click');
                }
            });
    });

    $('body').on('click', '.product-remove', function () {
        $productId = $(this).data('id');

        $.post("/ajx/removeFromCart.php", { PRODUCT_ID: $productId })
            .done(function(data) {
                if(data == 1) {
                    BX.onCustomEvent('OnBasketChange');
                }
            });
    });

    $('body').on('click', '.product-counter button', function () {
        $inputCnt = $(this).closest('.product-counter').find('input');
        $curCnt = $inputCnt.val()*1;
        $oldCnt = $curCnt;

        if($(this).hasClass('plus')) {
            $curCnt++;
        } else {
            $curCnt--;
        }

        if(!$curCnt) { $curCnt = 1; }

        $inputCnt.val($curCnt);

        if($oldCnt != $curCnt && !$(this).closest('#product').length) {
            $productId = $inputCnt.data('id');

            $.post("/ajx/changeQuantityCart.php", { PRODUCT_ID: $productId, QUANTITY: $curCnt })
                .done(function(data) {
                    if(data == 1) {
                        BX.onCustomEvent('OnBasketChange');
                    }
                });
        }
    });


    $(".order-form").on("submit", function (e) {
        e.preventDefault();

        $('.order-error').html('');

        $.ajax({
            url: "/ajx/addOrder.php",
            type: "post",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data, status) {
                //console.log(data);

                if(data.SUCCESS) {
                    window.location.href = '/cart/success/?ORDER_ID='+data.ORDER_ID;
                } else {
                    $('.order-error').html(data.MESSAGE);
                }
            },
            error: function (xhr, desc, err) {
                //console.log(err);
            },
        });
    });


    $(".personal-form").on("submit", function (e) {
        e.preventDefault();

        $('.order-error').html('');

        $.ajax({
            url: "/ajx/authProcess.php",
            type: "post",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data, status) {
                console.log(data);

                if(data.SUCCESS) {
                    if(data.REDIRECT) {
                        window.location.href = data.REDIRECT;
                    }
                    if(data.MESSAGE) {
                        alert(data.MESSAGE);
                    }
                } else {
                    $('.personal-error').html(data.MESSAGE);
                }
            },
            error: function (xhr, desc, err) {
                //console.log(err);
            },
        });
    });

});