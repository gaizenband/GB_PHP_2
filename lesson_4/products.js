Vue.component('products-comp',{
    props:['showed','addproduct', 'cookie','isinview','fetchproducts'],
    template: ` <div class="products">
                    <div class="items">
                        <div v-for="product of showed" :key='product.id' class="product-item">
                            <a :href="'img/'+product.img" data-fancybox="images" :data-caption="product.long_desc" class="link">
                                <img :src="'img/'+product.img" alt="some img" width="350px" height="240px">
                            </a>    
                            <div class='product_info'>
                                <div>
                                    <h3 class='product_name'>{{product.product_name}}</h3>
                                    <h4 class='product_name'>{{product.short_desc}}</h4>
                                    <p class='product_price'>Стоимость: {{product.price}} рублей</p>
                                </div>
                                <button class="buy-btn" :id="product.id" @click='$emit("addproduct",product.id,0,cookie)'>Купить</button>
                            </div>
                        </div>
                    </div>
                    <button v-if="isinview" @click='$emit("fetchproducts")' class="more">Show more</button>
                </div>
`
})