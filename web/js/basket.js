/**
 * Created by Alexis on 24/11/2017.
 */
'use strict';

var Menu = function(){

    this.buttondelete = $('.fa-minus-circle');

    this.buttondelete.on("click", this.deleteproduct.bind(this));
    this.buttondelete.on("click", this.getcart.bind(this));


};

Menu.prototype.deleteproduct = function(event) {
    event.preventDefault();
    var quantity = $(event.currentTarget).data('quantity');
    var itemid = $(event.currentTarget).data('itemid');

    $.ajax({

        url:'/deleteitem',
        method: 'POST',
        dataType: 'html',
        data: {quantity:quantity, itemid:itemid},
        success:this.basketSuccess

    })

};

Menu.prototype.basketSuccess = function(result){


    $('#basket').empty();
    $('#basket').append(result);

};

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
