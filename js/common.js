$(document).ready(function () {
    $('#sort-prod').on('change', function () {
        getProductsByParams();
    });

    $('.category-list .category-item').click(function () {
        $('.category-list .category-item').removeClass('active');
        $(this).addClass('active');
        getProductsByParams();
    });
});

$(document).on('click', '.btn_buy', function () {
    var prodId = $(this).data('id');
    getProductById(prodId);
})

function showProductCard(productData) {
    var modalTitle = '';
    var modalText = '';
    if(productData.success) {
        modalTitle = 'Детальная информация';
        modalText = productData.data;
    }else {
        modalTitle = 'Ошибка';
        modalText = productData.message;
    }
    $('.modal-title').text(modalTitle);
    $('.modal-body').html(modalText)
}

function getProductById(productId) {
    $.ajax({
        url: 'controller/Product',
        type: 'post',
        dataType: 'json',
        data: {
            'action': 'get-product-by-id',
            'product_id': productId
        },
        success: function (json) {
            showProductCard(json);
        },
        error: function (error) {
            var data = {
                'success': false,
                'message': error
            };
            showProductCard(data);
        }
    });
}

function getProductsByParams() {
    var sortId = $('#sort-prod').val();
    var categoryId = $('.category-item.active').data('id');

    categoryId = categoryId ?? '';
    history.pushState('', document.title, window.location.pathname + '?category_id=' + categoryId + '&sort_id=' + sortId);

    $.ajax({
        url: 'controller/Product',
        type: 'post',
        dataType: 'json',
        data: {
            'action': 'get-products-by-param',
            'sort_id': sortId,
            'category_id': categoryId
        },
        success: function (json) {
            if(json.success) {
                $('#result').html(json.data);
            }else {
                console.log(json.message)
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}