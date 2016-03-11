function onLoad() {
    isFirstTime()
    pullCart()
}
function openPage(){
    window.location.href = "checkout.html"
}

function isFirstTime() {
    var firstTime = getCookie("firstTime");
    if (firstTime == "NO") {
        console.log("this is not their first time");
        var numberOfCookies = Number(getCookie("numberOfCookies"));
        if (numberOfCookies > 0) {
            console.log("there are " + numberOfCookies + " cookies in the cookie jar");
            grabAllCookies();
        }
        else {
            console.log("there are no cookies in the cookie jar");
        }
    }
    else {
        console.log("this is their first time");
        document.cookie = "firstTime=NO";
        document.cookie = "userId=" + (Math.random() * 3 * Math.random() * 6 * Math.random() * 8 );

        document.cookie = "product_1=0";
        document.cookie = "product_2=0";
        document.cookie = "product_3=0";
        document.cookie = "product_4=0";
        document.cookie = "product_5=0";
        document.cookie = "product_6=0";
        document.cookie = "product_7=0";
        document.cookie = "product_8=0";
        document.cookie = "product_9=0";
        document.cookie = "product_10=0";
    }
}

function getCookie(cname) {
    var cookies = document.cookie;
    cookies = cookies.split("; ");

    for (var i = 0; i < cookies.length; i++) {
        cookies2 = cookies[i].split('=');
        if (cookies2[0] == cname) {
            i = cookies.lenght + 1;
            result = cookies2[1];
            return cookies2[1];
        }
    }
}

function grabAllCookies() {
    var numberOfCookies = getCookie("numberOfCookies");
    console.log("grabbing  all cookies")

    for (i = 0; i < numberOfCookies; i++) {
        var productCookie = 'product' + (i + 1);
        breakCookie(productCookie);
    }
}

function breakCookie(productValues) {
    console.log("crumbling cookies")

    var cookies = document.cookie;
    cookies = cookies.split("; ");

    for (var i = 0; i < cookies.length; i++) {
        cookies2 = cookies[i].split('=');
        var productNumber = cookies2[0];
        if (cookies2[0] == productValues) {
            i = cookies.lenght + 1;
            productToAdd = cookies2[1];
            var values = productToAdd.split(", ");
            addProductCookies(values[0], values[1], values[2], values[3], productNumber);
        }
    }
}

function addProduct(productId) {

    console.log(productId);
    getCookieVal = getCookie(productId);
    console.log(getCookieVal);
    getCookieVal = getCookieVal.split("=");
    numberOfProducts = Number(getCookieVal) + 1;
    console.log(numberOfProducts);
    document.cookie = productId + "=" + numberOfProducts;
    openPage();


}

function removeProduct(productId) {
    console.log(productId);
    getCookieVal = getCookie(productId);
    console.log(getCookieVal);
    getCookieVal = getCookieVal.split("=");
    numberOfProducts = Number(getCookieVal) - 1;
    console.log(numberOfProducts);
    document.cookie = productId + "=" + numberOfProducts;
}

function pullCart() {
    product_1 = getCookie('product_1')
    product_2 = getCookie('product_2')
    product_3 = getCookie('product_3')
    product_4 = getCookie('product_4')
    product_5 = getCookie('product_5')
    product_6 = getCookie('product_6')
    product_7 = getCookie('product_7')
    product_8 = getCookie('product_8')
    product_9 = getCookie('product_9')
    product_10 = getCookie('product_10')


    console.log(product_1)
    console.log(product_2)
    console.log(product_3)
    console.log(product_4)
    console.log(product_5)
    console.log(product_6)
    console.log(product_7)
    console.log(product_8)
    console.log(product_9)
    console.log(product_10)


    if (product_1 == 0 && product_2 == 0 && product_3 == 0 && product_4 == 0 && product_5 == 0 && product_6 == 0 && product_7 == 0 && product_8 == 0 && product_9 == 0 && product_10 == 0) {
        document.getElementById("noProducts").innerHTML = 'There are no products in your cart.';
    }

    if (product_1 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product1");
        document.getElementById("product1").innerHTML = '<img src="http://i.ebayimg.com/00/s/NTIxWDY4MQ==/z/GYcAAOSwL7VWjo-m/$_35.JPG" alt="Toucan" height="180px"></a> '

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_1);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_1 * 1500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_2 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product2");
        document.getElementById("product2").innerHTML = '<img src="http://germancarsforsaleblog.com/wp-content/uploads/2015/10/012-570x428.jpg" alt="" height="180px"></a>'

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_2);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_2 * 2000);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_3 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product3");
        document.getElementById("product3").innerHTML = '<img src="http://www.vwvortex.com/artman/uploads/ab_kidshorty_03.jpg" alt="" height="180px"></a>'

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_3);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_3 * 2500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_4 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product4");
        document.getElementById("product4").innerHTML = '<img src="http://static.cargurus.com/images/site/2008/06/24/22/26/2001_volkswagen_jetta_gls-pic-16581-1600x1200.jpeg" alt="" height="180px"></a>'

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_4);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_4 * 1500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_5 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product5");
        document.getElementById("product5").innerHTML = '<img src="https://media.ed.edmunds-media.com/volkswagen/jetta/2001/oem/2001_volkswagen_jetta_sedan_glx-vr6_fq_oem_1_300.jpg" alt="" height="180px"></a>'

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_5);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_5 * 2000);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_6 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product6");
        document.getElementById("product6").innerHTML = '<img src="http://www.runwalkjog.com/rhodeislandcars/providence/01volkswagenjetta51108.JPG" alt="" height="180px"></a> '

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_6);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_6 * 2500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_7 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product7");
        document.getElementById("product7").innerHTML = '<img src="http://image.superstreetonline.com/f/30210095+w+h+q80+re0+cr1/eurp_1102_01_o%2B2001_vw_jetta%2Bleft_side_view.jpg" alt="" height="180px"></a>'

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_7);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_7 * 1500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_8 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product8");
        document.getElementById("product8").innerHTML = '<img src="http://www.gotshadeonline.com/wp-content/gallery/2001-volkswagen-jetta/01-volkswagen-jetta-04.jpg" alt="" height="180px"></a> '

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_8);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_8 * 2000);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }

    if (product_9 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product9");
        document.getElementById("product9").innerHTML = '<img src="http://www.vwvortex.com/artman/uploads/ab_kidshorty_03.jpg" alt="" height="180px"></a> '

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_9);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_9 * 2500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table
    }

    if (product_10 > 0) {
        var createTable = document.createElement("TR");

        var node = document.createElement("TD");
        var textnode = document.createTextNode('');

        node.appendChild(textnode);
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);
        node.setAttribute("id", "product10");
        document.getElementById("product10").innerHTML = '<img src="http://carphotos.cardomain.com/ride_images/4/295/4241/38237120012_original.jpg" alt="" height="180px"></a> '

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode(product_10);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

        var node = document.createElement("TD");                        //First create an TD node
        var textnode = document.createTextNode("$" + product_10 * 2500);            //then create a Text node
        node.appendChild(textnode);                                     //then append the Text node to the TD node
        createTable.appendChild(node);
        document.getElementById("cartList").appendChild(createTable);  //Finally append the TD node to the table

    }
    document.getElementById("amount").innerHTML = "Number of Items: " + (Number(product_1) + Number(product_2) + Number(product_3) + Number(product_4) + Number(product_5) + Number(product_6) + Number(product_7) + Number(product_8) + Number(product_9) + Number(product_10))
    document.getElementById("priceAmount").innerHTML = "Price: $" + ((Number(product_1) * 1500) + (Number(product_2) * 2000) + (Number(product_3) * 2500) + (Number(product_4) * 1500) + (Number(product_5) * 2000) + (Number(product_6) * 2500) + (Number(product_7) * 1500) + (Number(product_8) * 2000) + (Number(product_9) * 2500) + (Number(product_10) * 2500))

}