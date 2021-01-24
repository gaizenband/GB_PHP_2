const deleteItem = (id,order_id) => {
    $.ajax({
        url: `index.php?path=order/cart/${id},${order_id}`,
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

const changeStatus = (e,id) => {
    let id_array = e.id.split(":");
    let id_order = id_array[0];
    let id_user = id_array[1];
    $.ajax({
        url: `index.php?path=admin/changeStatus/${id_order},${id_user},${id}`,
    })
        .done(function(data) {
            alert(data);
        });
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