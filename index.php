<!DOCTYPE html>
<html>
    <head>
        <title>Product List</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link href="style.css" rel="stylesheet" type="text/css" media="all">
        <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script> -->
        <script src="https://unpkg.com/vue@next"></script>

    </head>
    <body>
        <div id="app">
            <product-list>
            </product-list>
        </div>
        <footer>
            
        </footer>
        <script>
        
            //Vue.component('products', {
            //    props: ['product'],
            //    template: '<p>{{ product.index }}</p>'
            //})
 
            var app = Vue.createApp ({
                
            })
            
            app.component('product-list', {
                components: ['products', 'input'],
                template: `
                    <button id="delete-product-btn" v-on:click="massDelete()">MASS DELETE</button>
                    <button v-on:click="add">ADD</button>
                    <h1>Product List</h1>
                    <div id="lines">
                        <div id="grid">
                            <products style="margin:10px;"
                                v-for="(product, index) in productList"
                                v-bind:product="product" 
                                v-bind:checkbox="checkbox"
                                v-bind:key="product.index"
                                v-on:click="arr(index)"
                                >
                            </products>
                        </div>
                    </div>
                ` ,
                data: function(){
                    return {
                        productList: [],
                    }
                },
                methods:{
                    add: function(){ 
                        window.location.href = 'addproduct/' 
                    },
                    addProduct: function(p){
                        this.productList.push(p)
                        //console.log(this.productList)
                    },
                    showData: async function(){
                        this.productList = [];
                        var res = await fetch('sql/mysql_showdata.php', {
                            method: 'POST', 
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            //body: JSON.stringify({opts:opts})
                            //body: 'd='+d
                        })
                        .then(response => response.text())
                        .then(data => {('Success:', data); return data })
                        .catch((error) => { //console.error('Error:', error); 
                        });
                        
                        var json = JSON.parse(res)
                        //console.log(json.length)
                        //console.log(json)
                        
                        for (var i in json){
                            //console.log(json[i])
                            json[i].checked = false
                            this.addProduct(json[i])
                        }
                        
                        //return this.addProduct(JSON.parse(res))
                        //return this.productList.length-1
                    },
                    deleteData: async function(p){
                        var data
                        var res = await fetch('sql/mysql_deletedata.php', {
                            method: 'POST', 
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({p:p})
                            //body: 'd='+d
                        })
                        .then(response => response.text())
                        .then(data => {('Success:', data); return data })
                        .catch((error) => { //console.error('Error:', error); 
                        });
                        this.showData()
                        
                    },
                    arr: function(i){
                        //console.log (i)
                    },
                    massDelete: function(){
                        this.deleteData(this.productList)
                        /*while (i < this.productList.length) { 
                            if (this.productList[i] === value) { this.productList.splice(i, 1);
                            } else { ++i; } } */
                        for (var i in this.productList){
                            if (this.productList[i].checked){
                                //this.productList.splice(i,1)
                                //console.log(this.productList[i])
                            }
                        }
                        //console.log(this.productList)
                    }
                },
                created(){
                    this.showData()
                }
            })

            app.component('products', {
                props: ['product','checkbox'],
                data: function(){
                    return {
                        'checked': false
                    }
                },
                template: `
                    <span style="background-color:#fff;padding:5%" :product="product">
                    <input type="checkbox" style="float:left;" :class="delete-checkbox" checked="false" v-model="product.checked"><br>
                        <ul style="list-style-type:none; margin:0; padding:0;">
                        <li>{{ product.sku }}</li>
                        <li>{{ product.name }}</li>
                        <li>{{ product.price }} $</li>
                        <li v-if="product.size != ''">Size: {{ product.size }} MB</li>
                        <li v-if="product.weight != ''">Weight: {{ product.weight }} KG</li>
                        <li v-if="product.height != '' && product.width != '' && product.length != ''">Dimension: {{ product.height }}x{{ product.width }}x{{ product.length }}</li>
                        </ul>
                    </span>
                `,
                methods: {
                    
                }
            })
            
            const vm = app.mount('#app');

            
        </script>
    </body>
</html>