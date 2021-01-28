/**
 * @param id
 * @param order_id
 * Функция для удаления товара из корзины
 */
const deleteItem = (id,order_id) => {
    $.ajax({
        url: `index.php?path=order/cart/${id},${order_id}`,
    })
    .done(function() {
    alert('Товар удален');
    location.reload();
    });
}

/**
 * Функция для добавления товара в корзину
 * @param id
 */
const addItem = (id) => {
    $.ajax({
        url: `index.php?path=order/add/${id}`,
    })
    .done(function() {
        alert('Товар добавлен');
    });
}

/**
 * Фунцкия для изменения количества товара в корзине
 * @param id
 * @param value
 */
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

/**
 * Функция для отмены заказа
 * @param order_id
 */
const cancelOrder = (order_id) => {
    $.ajax({
        url: `index.php?path=order/cancelOrder/${order_id}`,
    })
    .done(function() {
        alert('Заказ отменен');
    });
    location.reload();
}

/**
 * Функция для изменения статуса заказа
 * @param e
 * @param id
 */
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

/**
 * Функция для удаления товара или категории с сайта
 * @param item
 * @param id
 */
const removeItem = (item, id) => {
    if(item == 'good'){
        $.ajax({
            url: `index.php?path=admin/removeGood/${id}`,
        })
            .done(function() {
                window.location.replace("?path=admin/control/goods/");
            });
    } else if(item == 'category'){
        $.ajax({
            url: `index.php?path=admin/removeCategory/${id}`,
        })
            .done(function() {
                window.location.replace("?path=admin/control/categories/")
            });
    }
}