var rowCount;
var tablea = [], tableb = [], tabled = [];

function load_data() {      //載入購物車
    $.ajax({
        url: "cart-ajax.php",
        method: "GET",
        data: {},
    success: function (data) {
        $("#cart_box").append(data);
    }
    });
}


function refresh() {        //刷新總價
    let tprice = 0 , click = 0;
    for (let i=1; i<=rowCount; i++) {
        let a = tablea[i];
        let b = tableb[i];
        c = a * b;
    
        tprice += c;
        
        if (c != 0) click++;   
    }
    $('#totalclick').text(click);
    $('#totalprice').text('$'+tprice);
}
// a=個別單價   b=個別數量  c=總價小計



var all=0;
$(document).ready(function() {
    for (let i=1; i<= rowCount; i++) {
        tablea[i] =0;
        tableb[i] =0;
        tabled[i] =null
    }

    $('#checkout_all').click(function() {   //全選

        var checked = this.checked;
        $('input[type="checkbox"]').each(function() {
            this.checked = checked;
        });
    });

    $('#checkout_all').click(function() {   //全選
        if (all == 1) {
            for (let i=1; i<=rowCount; i++) {
                tablea[i] = 0;
                tableb[i] = 0;
                tabled[i] = 0;

                tabled[i] = null;
            }

            all=0;
            refresh();
        }
        else {
            tprice =0;
            for (let i=1; i<=rowCount; i++) {
                let aa = $('#product_unit_price'+i).text();
                let b = $('#product_unit_amount'+i).text();
                a = aa.replace(/[^0-9]/ig,"");
                c = a * b;
            
                tprice += c;
            
                tablea[i] = a;
                tableb[i] = b;

                tabled[i] = 'all';
            }
            
            all=1;
            refresh();
        }
    });
});


function checkbox (id, pNo) {        //單獨選取
    if (tablea[id] == 0) {      
        let aa = $('#product_unit_price'+id).text();
        let b = $('#product_unit_amount'+id).text();
        a = aa.replace(/[^0-9]/ig,"");
        c = a * b;
            
        tablea[id] = a;
        tableb[id] = b;
        
        tabled[id] = pNo;

        refresh();
    }
    else {
        tablea[id] = 0;
        tableb[id] = 0;
        tabled[id] = 0;

        $('#checkout_all').prop( "checked", false );
        all = 0;

        refresh();
    }
}


function product_amount_add (id, pNo, pStock) {          //增加數量
    let amount = $('#product_unit_amount'+id).text();
    amount = parseInt(amount);
    console.log(pStock);
    if (amount < pStock) {
    amount += 1;

    let pUnitprice = $('#product_unit_price'+id).text();
    pUnitprice = pUnitprice.replace(/[^0-9]/ig,"");

    let pTprice = $('#product_unit_tprice'+id).text();
    pTprice = pTprice.replace(/[^0-9]/ig,"");

    $('#product_unit_amount'+id).text(amount);
    pTprice -= -pUnitprice;
    $('#product_unit_tprice'+id).text('$'+pTprice);

    if (tablea[id] != 0) {
        tablea[id] = pUnitprice;
        tableb[id] = amount;
        refresh();
    }
    
    $.ajax({
        url: "cart-ajax-ajax.php",
        method: "GET",
        data: {
            pNo: pNo,
            amount: amount,
        },
    success: function (data) {
        $("#cart_box").append(data);
    }
    });
}
}

function product_amount_minus (id , pNo) {        //減少數量
    let amount = $('#product_unit_amount'+id).text();
    amount = parseInt(amount);

    let pUnitprice = $('#product_unit_price'+id).text();
    pUnitprice = pUnitprice.replace(/[^0-9]/ig,"");

    let pTprice = $('#product_unit_tprice'+id).text();
    pTprice = pTprice.replace(/[^0-9]/ig,"");

    if (amount != 1) {
        amount -= 1;
        $('#product_unit_amount'+id).text(amount);
        pTprice -= pUnitprice;
        $('#product_unit_tprice'+id).text("$"+pTprice);
    }

    if (tablea[id] != 0) {
        tablea[id] = pUnitprice;
        tableb[id] = amount;
        refresh();
    }

    $.ajax({
        url: "cart-ajax-ajax.php",
        method: "GET",
        data: {
            pNo: pNo,
            amount: amount
        },
    success: function (data) {
        $("#cart_box").append(data);
    }
    });
}

function remove (id , pNo) {
    $.ajax({
        url: "cart-ajax-remove.php",
        method: "GET",
        data: {
            pNo: pNo,
        }
    });
}

var record = 0;
function checkout (){   //tabled是pNo      //選了啥商品的傳值
    var str=0;
    if (tabled[1] == 'all') {
        location.href="order.php?pNo1=all";
    }
    else {
        for (let i=1 ; i<=rowCount ; i++) {
            if (tabled[i] != 0 && tabled[i] != null) {
                record = 1;
                if (str == 0)
                    str = "pNo" + i + "=" + String(tabled[i]) + "&";
                else 
                    str = str + "pNo" + i + "=" + String(tabled[i]) + "&";
            }
            else {
                if (str == 0)
                    str = "pNo" + i + "=" + String(tabled[i]) + "&";
                else {
                    str = str + "pNo" + i + "=" + String(tabled[i]) + "&";
                }
            }
        }
        if (record == 0) location.href="order.php?pNo1=NNN"
        else location.href="order.php?"+str;
    }
}