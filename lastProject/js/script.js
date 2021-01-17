const deleteItem = (id) => {
    $.ajax({
        url: `index.php?path=order/cart/${id}`,
    })
    .done(function() {
    alert('Товар удален');
    location.reload();
    });
}

const addItem = (id) => {
    $.ajax({
        url: `index.php?path=order/add/${id}`,
    })
    .done(function() {
        alert('Товар добавлен');
    });
}

const changeCount = (id, value) => {
    if (value < 1){
        deleteItem(id);
    }else{
        $.ajax({
            url: `index.php?path=order/add/${id}/${value}`,
        })
        .done(function() {
            alert('Количество успешно изменено');
        });
    }
    location.reload();
}

const cancelOrder = (order_id) => {
    $.ajax({
        url: `index.php?path=order/cancelOrder/${order_id}`,
    })
    .done(function() {
        alert('Заказ отменен');
    });
    location.reload();
}

// const saveCategory = (category_id) => {
//     $.ajax({
//         url: `index.php?path=admin/changeCategory/${category_id}`,
//     })
//         .done(function() {
//             alert('Заказ отменен');
//         });
//     location.reload();
// }