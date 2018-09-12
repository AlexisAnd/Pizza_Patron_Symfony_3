/**
 * Created by Alexis on 24/11/2017.
 */
'use strict';

var Menu = function(){

    this.buttonadd = $('.fa-plus-circle');
    this.document = $(document);

    this.buttonadd.on("click", this.addproduct.bind(this));
    this.buttonadd.on("click", this.getcart.bind(this));
    this.document.ready(this.getbasket.bind(this));
    this.document.ready(this.getcart.bind(this));

};

     Menu.prototype.addproduct = function(event){
        event.preventDefault();
        var pizzaid = $(event.currentTarget).data('pizza');
        var paniniid = $(event.currentTarget).data('panini');
        var texmexid = $(event.currentTarget).data('texmex');
        var dessertid = $(event.currentTarget).data('dessert');
        var drinkid = $(event.currentTarget).data('drink');
        var name = $(event.currentTarget).data('name');
        var price = $(event.currentTarget).data('price');
        var quantity = $(event.currentTarget).data('quantity');

         $.ajax({

             url:'/addtocart',
             method: 'POST',
             dataType: 'html',
             data: {pizzaid:pizzaid, paniniid:paniniid, texmexid:texmexid, dessertid:dessertid, drinkid:drinkid, name:name, price:price, quantity:quantity},
             success: this.Success
         })
        };

        Menu.prototype.Success = function(result){

            $('#basket').empty();
            $('#basket').append(result);

        };

    Menu.prototype.getbasket = function(event){

        var pizzaid = $(event.currentTarget).data('pizza');
        var paniniid = $(event.currentTarget).data('panini');
        var texmexid = $(event.currentTarget).data('texmex');
        var dessertid = $(event.currentTarget).data('dessert');
        var drinkid = $(event.currentTarget).data('drink');
        var name = $(event.currentTarget).data('name');
        var price = $(event.currentTarget).data('price');
        var quantity = $(event.currentTarget).data('quantity');

        $.ajax({

            url:'/addtocart',
            method: 'GET',
            dataType: 'html',
            data: {pizzaid:pizzaid, paniniid:paniniid, texmexid:texmexid, dessertid:dessertid, drinkid:drinkid, name:name, price:price, quantity:quantity},
            success: this.Success
        })
    };
        // Menu.prototype.basketSuccess = function(result){
        //
        //
        //     $('#basket').empty();
        //     $('#basket').append(result);

        Menu.prototype.getcart = function() {

            $.ajax({

                url: '/getcart',
                type: 'get',
                dataType: 'html',
                success: this.cart
            });

        };

        Menu.prototype.cart =function(result) {


            $('#cart').empty();
            $('#cart').append(result);

        };



var menu = new Menu;
