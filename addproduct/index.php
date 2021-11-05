<!DOCTYPE html>
<html>
    <head>
        <title>Product Add</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link href="../style.css" rel="stylesheet" type="text/css" media="all">
        <script src="https://unpkg.com/vue@next"></script>

    </head>
    <body>
        <style>
        
            div input {
                display:inline-block;
                justify-content:space-between;
                align-items:center;
                border:3px solid black;
                margin:10px;
                padding:10px;
            }
            
            div label{
                display:block;
            }
            
            select {
                padding: 5px 35px 5px 5px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background: #fff url('arrow.png') 96% / 15% no-repeat;
            }
            
            select::-ms-expand { 
                display: none;
            }
            
            .tooltip {
              position: relative;
              float:left;
              top:20px;
              display: inline;
              border-bottom: 1px dotted black;
              font-size:14px;
            }
            
            .tooltip .tooltiptext {
              position: absolute;
              width: 240px;
              background-color: black;
              color: #fff;
              text-align: center;
              border-radius: 6px;
              padding: 5px;
              margin-left:300px;
              z-index: 1;
              visibility: visible;
            }
        
        </style>
        <div id="product_form" v-cloak>
            <custom-form>
                
            </custom-form>
            </div>
        </div>
        <footer>
            
        </footer>

        <script>
        
            var productForm = Vue.createApp ({})
            
            productForm.component('custom-form', {
                props: {
                    modelValue: {
                      type: String,
                      default: ''
                    },
                },   
                components: ['status-bar', 'tooltips'],
                template: `
                    <button v-on:click="cancelProduct">CANCEL</button>
                    <button v-on:click="submitProduct">SAVE</button>
                    <h1>Product Add</h1>
                    <div id="lines">
                    <label>SKU<input type="text" disabled id="sku" v-model="this.product.sku"></label>
                    
                    <label>Name<input type="text" id="name" v-model="this.product.name" placeholder="Please, provide name"><tooltips v-if="this.tooltipText.show && checkName(this.product.name)!=false" :tooltip="this.checkName(this.product.name)" /></label>
                        
                    <label>Price ($)<input type="text" id="price" v-model="this.product.price" placeholder="Please, provide price"><tooltips v-if="this.tooltipText.show && checkNumbers(this.product.price)!=false" :tooltip="this.checkNumbers(this.product.price)" /></label>
                        
                    <label>Type Switcher <select id="productType" v-model="selected" :modelValue="selected">
                        <option 
                            v-for="item in options" 
                            >{{item}}
                        </option>
                    </select></label>
                    
                    <label v-if="this.selected == 'DVD'">Size (MB)<input type="text" id="size" v-model=this.product.attr.size placeholder="Please, provide size"><tooltips v-if="this.tooltipText.show && checkNumbers(this.product.attr.size)!=false" :tooltip="this.checkNumbers(this.product.attr.size)" /></label>
                        
                    
                    <label v-if="this.selected == 'Book'">Weight (KG)<input type="text" id="weight" v-model=this.product.attr.weight placeholder="Please, provide weight"><tooltips v-if="this.tooltipText.show && checkNumbers(this.product.attr.weight)!=false" :tooltip="this.checkNumbers(this.product.attr.weight)" /></label>
                    
                    <label v-if="this.selected == 'Furniture'">Height (CM)<input type="text" id="height" v-model=this.product.attr.dimensions.height placeholder="Please, provide height"><tooltips v-if="this.tooltipText.show && checkNumbers(this.product.attr.dimensions.height)!=false" :tooltip="this.checkNumbers(this.product.attr.dimensions.height)" /></label>
                    
                    <label v-if="this.selected == 'Furniture'">Width (CM)<input type="text" id="width" v-model=this.product.attr.dimensions.width placeholder="Please, provide width"><tooltips v-if="this.tooltipText.show && checkNumbers(this.product.attr.dimensions.width)!=false" :tooltip="this.checkNumbers(this.product.attr.dimensions.width)" /></label>
                    
                    <label v-if="this.selected == 'Furniture'">Length (CM)<input type="text" id="length" v-model=this.product.attr.dimensions.length placeholder="Please, provide length"><tooltips v-if="this.tooltipText.show && checkNumbers(this.product.attr.dimensions.length)!=false" :tooltip="this.checkNumbers(this.product.attr.dimensions.length)" /></label>
                    </div>
                ` ,
                
                data: function() {
                    return {
                        product: {
                            sku: '',
                            name: '',
                            price: '',
                            attr: {
                                size: '',
                                weight: '',
                                dimensions: {
                                    height: '',
                                    width: '',
                                    length: ''
                                }
                            }
                        },
                        options: ['DVD', 'Book', 'Furniture'],
                        selected: 'DVD',
                        tooltipText: {
                            onSubmit: 'Please, submit required data',
                            onType: 'Please, provide the data of indicated type',
                            show: false
                        }
                     }
                },
                computed:{
                    model:{
                        get(){ return this.modelValue },
                        set(v){ this.$emit('update:modelValue',v)}
                    }
                },

                methods:{
                    cancelProduct: function(){
                        window.location.href = '../'
                    },
                    updateValue: function () {
                        return this.$emit('sendData')
                    },
                    submitProduct: function(){
                        var p = this.product
                        var chk = this.checkNumbers
                        var chkn = this.checkName
                        this.tooltipText.show = false
                        this.getSKU()
                        if((p['sku'])=='' || chkn(p['name'])!=false || chk(p['price'])!=false)
                            this.tooltipText.show = true

                        if(this.selected == 'DVD')
                            if (chk(p['attr']['size'])!=false)
                                this.tooltipText.show = true

                        if(this.selected == 'Book')
                            if (chk(p['attr']['weight'])!=false)
                               this.tooltipText.show = true
                               
                        if(this.selected == 'Furniture')
                            if(chk(p['attr']['dimensions']['height'])!=false ||  
                            chk(p['attr']['dimensions']['width'])!=false || 
                            chk(p['attr']['dimensions']['length'])!=false
                            )
                               this.tooltipText.show = true
                        
                        else this.tooltipText.show = false
                        if (this.tooltipText.show == false){
                            return this.postData(this.product)
                        }
                    },
                    getSKU: async function(){
                        var res = await fetch('../sql/mysql_getSKU.php', {
                            method: 'POST', 
                        })
                        .then((response) => response.text())
                        .then((text) => { return (text);
                        })
                        return this.product.sku=res
                    },
                    postData: function(p){
                        fetch('../sql/mysql_postdata.php', {
                            method: 'POST', 
                            //mode: "same-origin",
                            //credentials: "same-origin",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({p:p})
                        })
                        .then(response => response.text())
                        .then(data => {
                            window.location.href = '../';
                        })
                        .catch((error) => {});
                    },
                    checkNumbers: function(v){
                        if(v == ''){ return this.tooltipText.onSubmit }
                        else if(isNaN(v)){ return this.tooltipText.onType }   
                        else { return false }
                    },
                    checkName: function(v){
                        if(v == ''){ return this.tooltipText.onSubmit }
                        else { return false }
                    },
                },
                created: function () {
                    this.getSKU();
                }
            })
            
            productForm.component ('tooltips', {
                props: ['tooltip', 'checkNumbers'],
                template: `
                    <div class="tooltip" :tooltip="tooltip" :checkNumbers="checkNumbers">
                        <span class="tooltiptext">{{tooltip}}</span>
                    </div>
                `
            })
            
            const vm = productForm.mount('#product_form')

        </script>
    </body>
</html>