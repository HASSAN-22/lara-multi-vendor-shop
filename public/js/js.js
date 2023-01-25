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
