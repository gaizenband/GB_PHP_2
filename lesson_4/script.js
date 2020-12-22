const app = new Vue(
    {
        el: '#app',
        data: {
            products: [],
            api: 'server.php',
            cartData: '',     
            showedProducts:[],
            cartGoods:[],
            cookie:'',
            userInfo: {},
            userOrders: [],
            uniqueOrders: [],
            shownProducts:0,
            countOfProducts:0,
        },
        methods: {
            fetchProducts(){
                let url;
                if(this.userInfo.id === '1') {
                    url = this.api;

                }else{
                    let start =  this.shownProducts;
                    let end;
                    if(this.shownProducts + 3 > this.countOfProducts){
                        this.shownProducts = this.countOfProducts;
                        start = this.shownProducts - 1;
                        end = 1;
                    }else{
                        end = 3;
                        this.shownProducts += 3;
                    }
                    url = this.api+`?start=${start}&end=${end}`;
                    console.log(url)
                }
                // console.log(url);
                return fetch(url)
                    .then(answer => answer.json())
                    .catch(error => console.log(error))
                    .then(data => {
                        this.products.push(...data);
                        this.showedProducts = this.products;
                    });
            },
            countGoods(){
                return fetch('countGoods.php')
                    .then(answer => answer.json())
                    .catch(error => console.log(error))
                    .then(data => this.countOfProducts = +data.val);
            },
            fetchCart(){
                return fetch(`cart.php?userId=${this.userInfo.id}`)
                    .then(answer => answer.json())
                    .catch(error => console.log(error))
                    .then(data => this.cartGoods=[...data]);
            },            
            filterGoods(searchLine){
                if (searchLine) {
                    this.showedProducts = this.products.filter(value => value.product_name.toLowerCase().includes(searchLine))
                } else {
                    this.showedProducts = this.products;
                }
            },
            addProduct(id,value,cookie){
                if(!this.cookie){
                    return alert('Please register!');
                }
                console.log(value);
                if(!value){
                    fetch(`cart.php?id=${id}&${cookie}&userId=${this.userInfo.id}`)
                    .then(answer =>answer.json())
                    .catch(error => console.log(error))
                    .then(data => this.cartGoods=[...data]);
                } else {
                    fetch(`cart.php?id=${id}&count=${value}&${cookie}&userId=${this.userInfo.id}`)
                    .then(answer =>answer.json())
                    .catch(error => console.log(error))
                    .then(data => this.cartGoods=[...data]);
                }
                
            },
            deleteItem(id){
                fetch(`cart.php?id=${id}&delete=1&${this.cookie}&userId=${this.userInfo.id}`)
                .then(answer =>answer.json())
                .catch(error => console.log(error))
                .then(data => this.cartGoods=[...data]);
            },
            async register(name,password,register,userName,e){
                e.preventDefault();
                await jQuery.ajax({
                    type: "POST",
                    url: 'login.php',
                    dataType: "json",
                    data: {functionname: 'registerUser', arguments: [name,password,register,userName]},
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    },
                })
                await this.fetchUser();
                await this.fetchOrders();
                await this.fetchCart();
            },
            fetchUser(){
                if(document.cookie){
                    this.cookie = document.cookie;
                    return fetch(`login.php?${document.cookie}&fetchUser=1`)
                        .then(answer => answer.json())
                        .catch(error => console.log(error))
                        .then(data => this.userInfo=data[0]);
                } 
            },
            async quitUser(){
                await fetch(`login.php?fetchUser=0&name=${this.userInfo.user_name}`)
                    .then(answer => answer)
                    .catch(error => console.log(error))
                    .then(data => console.log(data));
                    
                    this.userInfo = this.cartGoods = this.cookie = document.cookie = '';
            },
            async placeOrder(adress){
                if(!adress){
                    return alert('Укажите адрес');
                }
                await fetch(`orders.php?userId=${this.userInfo.id}&adress=${adress}`)
                    .then(answer => answer)
                    .catch(error => console.log(error))
                    .then(data => console.log(data));

                    this.cartGoods = '';
                await this.fetchOrders();
                await this.fetchCart();
            },
            async fetchOrders(){
                await fetch(`orders.php?userId=${this.userInfo.id}`)
                .then(answer => answer.json())
                .catch(error => console.log(error))
                .then(data => this.userOrders = data);
                this.userOrders.forEach(el => {
                    if(!this.uniqueOrders.includes(el.date_created))
                        this.uniqueOrders.push(el.date_created);
                });
            },
            async deleteOrder(date){
                await fetch(`orders.php?userId=${this.userInfo.id}&date=${date}`)
                .then(answer => answer)
                .catch(error => console.log(error))
                .then(data => alert("Item has been deleted"));
                await this.fetchOrders();
            },
            async changeStatus(e,date){
                await fetch(`orders.php?newStatus=${e.target.value}&date=${date}`)
                .then(answer => answer)
                .catch(error => console.log(error))
                .then(data => alert("Done"));
                await this.fetchOrders();
            },
            async deleteItem(e){
                e.preventDefault();
                await fetch(`admin.php?delete=1&id=${e.target.id}`) 
                .then(answer => answer)
                .catch(error => console.log(error))
                .then(data => alert("Done"));
                await this.fetchProducts(this.api);
            }
        },
        async mounted() {
            await this.countGoods();

            if(document.cookie){
                await this.fetchUser();
                await this.fetchCart();
                await this.fetchOrders();
            }

            await this.fetchProducts();
        },
        computed: {
            isInView: function(){
                return this.countOfProducts - this.shownProducts;
            }
        }
    }   
)