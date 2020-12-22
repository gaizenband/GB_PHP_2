Vue.component('personal-link',{
    props:['register', 'cookie','userinfo','quit','uniqueorders','userorders','products','deleteorder','changestatus','products','deleteitem'],
    data(){
        return {
            isVisiblePersonal: false,
            name:'',
            password:'',
            registerCheck:'',
            userName:'',
            sortOrders(item){
                return this.userorders.filter(el => el.date_created == item);
            },
        }
    },
    methods: {
        productName(id){
            let temp = this.products.filter(el => el.id == id);
            return temp[0].product_name;
        },
        calcOrder(date){
            let total = 0;
            let temp = this.userorders.filter(el => el.date_created == date);
            temp.forEach(el => total += +el.price)
            return total;
        },
    },
    template: ` <div class="link">
                    <button class="buy-btn personal-link" @click='isVisiblePersonal = !isVisiblePersonal'>Личный кабинет</button>
                    <button class="buy-btn personal-link quit" v-if='cookie' @click='$emit("quit")'>Выйти</button>
                    <div class="personal-info" v-if='isVisiblePersonal'>
                        <form action='#' method="POST" class="access" v-if="!cookie">
                            <p>Login:</p>
                                <input type='text' v-model="name" required>
                            <p>Password:</p>
                                <input type='password' v-model="password" required>
                            <div class='register'>
                                <p>Register:</p>
                                    <input type='checkbox' v-model="registerCheck">
                            </div>
                            <div>
                                <p>Your name:</p>
                                    <input type='text' v-model='userName' placeholder='optional'>
                            </div>
                            <input type='submit' @click='$emit("register",name,password,registerCheck,userName,$event)'>
                        </form>
                        <div class="info" v-if="cookie">
                            <p>Wellcome {{userinfo.first_name? userinfo.first_name:userinfo.user_name}}</p>
                            <div class="orders" v-if='userinfo.admin_status == 1'>
                                <div class="shopControl">
                                    <div v-for="product of products" :key='product.id' class="product-item">
                                        <img :src="'img/'+product.img" alt="some img" width="150px"> 
                                        <form class='product_info' action="admin.php?action=change" enctype="multipart/form-data" method='post'>
                                            <div>
                                                Name:<input class='product_name' type="text" :value="product.product_name" name="name" required>
                                                Desc:<input class='product_name' type="text" :value="product.short_desc"  name="desc" required>
                                                Price:<input class='product_price' type="text" :value="product.price" name="price" required>
                                                Img:<input name="image" type='file' accept="image/*">
                                                <input type='number' style="display:none" name="id" :value="product.id">
                                            </div>
                                            <input type='submit' class="buy-btn" value='Save'>
                                            <button class="buy-btn" :id="product.id" @click='$emit("deleteitem",$event)'>Delete</button>
                                        </form>
                                    </div>
                                    <div class="product-item">
                                        <form class='product_info' action="admin.php?action=new" enctype="multipart/form-data" method='post'>
                                            <div>
                                                Name:<input class='product_name' type="text" name="name" required>
                                                Desc:<input class='product_name' type="text" name="desc" required>
                                                Price:<input class='product_price' type="text" name="price" required>
                                                Img:<input name="image" type='file' accept="image/*" required>
                                            </div>
                                            <input type='submit' class="buy-btn" value='Save'>
                                        </form>
                                    </div>
                                </div>

                                <h3>Заказы:</h3>
                                <div v-for="item of uniqueorders" :key='item' class="order">
                                    <div>
                                        <div v-for="(order,key) of sortOrders(item)" :key='key' class="list-order">
                                            <p class="order-info">{{productName(order.id_item)}}: </p>
                                            <p class="order-info">{{order.price}} руб.</p>
                                            <h6  v-if="order.order_status == 0">Новый</h6>
                                            <h6  v-if="order.order_status == 1">В обработке</h6>
                                            <h6  v-if="order.order_status == 2">Доставлен</h6>
                                            <h6  v-if="order.order_status == 3">Отменен</h6>
                                        </div>
                                        <p class="order-info">Total: {{calcOrder(item)}}</p>
                                    </div>
                                    <div class='changeStatus'> 
                                    <p>Изменить статус на: </p>
                                        <select @change="$emit('changestatus',$event,item)">
                                            <option value='0'>Новый</option>
                                            <option value='1'>В обработке</option>
                                            <option value='2'>Доставлен</option>
                                            <option value='3'>Отменен</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="orders" v-if='userinfo.admin_status == 0'>
                                <div v-for="item of uniqueorders" :key='item' class="order">
                                    <div>
                                        <div v-for="(order,key) of sortOrders(item)" :key='key' class="list-order">
                                            <p class="order-info">{{productName(order.id_item)}}: </p>
                                            <p class="order-info">{{order.price}} руб.</p>
                                            <h6  v-if="order.order_status == 0">Новый</h6>
                                            <h6  v-if="order.order_status == 1">В обработке</h6>
                                            <h6  v-if="order.order_status == 2">Доставлен</h6>
                                            <h6  v-if="order.order_status == 3">Отменен</h6>
                                        </div>
                                        <p class="order-info">Total: {{calcOrder(item)}}</p>
                                    </div>
                                    <div>
                                        <button class="decline" :id="item" @click='$emit("deleteorder",item)' >Отменить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
`
})
