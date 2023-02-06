function token(){
    let token = $('meta[name="csrf-token"]').attr('content');
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    return token;
}


function numberFormat(number){
    return new Intl.NumberFormat().format(number)
}

function discount(price, discount){
    discount = (discount / 100) * price;
    return (price - discount);
}



$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
    $('.dropdown-menu a').click(function(e){
        e.preventDefault();
        if($(this).next('.submenu').length){
            $(this).next('.submenu').toggle();
        }
        $('.dropdown').on('hide.bs.dropdown', function () {
            $(this).find('.submenu').hide();
        })
    });
}

// add product price when select properties if properties hav price
function property(originPrice){
    let price = 0;
    $('.properties').find("input[type='radio']").each(function(){
        if($(this).is(":checked")){
            price += parseFloat($(this).val())
        }
    });
    let count = $('.productCount').val();
    $('.product_price').text(numberFormat(((parseFloat(originPrice) + price) * count)));
}

// change price of product when increment count
function incrementProduct(originPrice){
    let price = $('.product_price').text().replace(',','');
    $('.product_price').text(numberFormat((parseFloat(originPrice) + parseFloat(price))));
}

// change price of product when decrement count
function decrementProduct(originPrice){
    let price = $('.product_price').text().replace(',','');
    $('.product_price').text(numberFormat((parseFloat(price) - parseFloat(originPrice))));
}

// add product to basket
function addToCart(productId){
    let properties = [];
    let hasProperty = false;
    $('.properties').find("input[type='radio']").each(function(){
        hasProperty = true;
        if($(this).is(":checked")){
            let name = $(this).attr("name");
            let id = $(this).attr("id");
            let label = $("label[for='"+id+"']").text();
            properties.push($(`input[name='${name}[${label}]']`).val())
        }
    });
    if(hasProperty && properties.length === 0){
        alert('Please select a feature')
    }else{
        let count = $('.productCount').val();
        axios.post('/add-basket/'+productId,{'_token':token(),properties:properties,count:count}).then(res=>{
            alert('با موفقیت ثبت شد')
        }).catch(err=>{
            let response = err.response
            if(err.response){
                let data = response.data.error;
                if(data === 'userLogin'){
                    alert('You need to login to the website')
                }else if(data === 'productCount'){
                    alert('The product is not available in stock')
                }else if(data === 'productCount'){
                    alert('The product is not available in stock')
                }
            }else{
                alert('Server error')
            }
        })
    }

}


$(document).ready(function(){
    $('.star>i').click(function (){
        $('.star').find("i").each(function(){
            $(this).removeClass('fa')
            $(this).addClass('far')
        });
        if($(this).hasClass('far')){
            $(this).addClass('fa')
            $('.rating_star').val($(this).attr('data-star'))
        }
    })
})
