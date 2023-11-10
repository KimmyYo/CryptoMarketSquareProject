<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out Your Order</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/order.css">
    <script src="https://cdn.jsdelivr.net/npm/web3@1.3.5/dist/web3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@openzeppelin/contracts@4.1.0/build/contracts/ERC20.json"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
            margin-left: 175px;
            margin-top: 20px;
            margin-bottom: 25px;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
    const ERC20ABI = [
    {
        "inputs": [],
        "stateMutability": "nonpayable",
        "type": "constructor"
    },
    {
        "inputs": [
        {
            "name": "_spender",
            "type": "address"
        },
        {
            "name": "_value",
            "type": "uint256"
        }
        ],
        "name": "approve",
        "outputs": [
        {
            "name": "",
            "type": "bool"
        }
        ],
        "stateMutability": "nonpayable",
        "type": "function"
    },
    // 以下是其他函數的定義...
    {
            "inputs": [],
            "stateMutability": "nonpayable",
            "type": "constructor"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "owner",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "indexed": false,
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "Approval",
            "type": "event"
        },
        {
            "anonymous": false,
            "inputs": [
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "from",
                    "type": "address"
                },
                {
                    "indexed": true,
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "indexed": false,
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "Transfer",
            "type": "event"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                },
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                }
            ],
            "name": "allowance",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "spender",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "approve",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "owner",
                    "type": "address"
                }
            ],
            "name": "balanceOf",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "",
                    "type": "address"
                }
            ],
            "name": "balances",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "decimals",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "name",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "symbol",
            "outputs": [
                {
                    "internalType": "string",
                    "name": "",
                    "type": "string"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "totalSupply",
            "outputs": [
                {
                    "internalType": "uint256",
                    "name": "",
                    "type": "uint256"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "transfer",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "address",
                    "name": "from",
                    "type": "address"
                },
                {
                    "internalType": "address",
                    "name": "to",
                    "type": "address"
                },
                {
                    "internalType": "uint256",
                    "name": "value",
                    "type": "uint256"
                }
            ],
            "name": "transferFrom",
            "outputs": [
                {
                    "internalType": "bool",
                    "name": "",
                    "type": "bool"
                }
            ],
            "stateMutability": "nonpayable",
            "type": "function"
        }
    ];

    var string = '';
    var string_amount = '';

    </script>
</head>
<body>

    <?php

    require 'includes/db.php';
    $user_name = $_COOKIE["CookieUname"];
	$sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
	$user = $db -> query($sql);
	$user = $user->fetch();

    
    $row = $db->query("SELECT * FROM Contain WHERE mId='$user[0]' ORDER BY pNo ");
    $rowCount = $row->rowCount();  //購物車裡全部rowCount筆資料
   

    $getlength = count($_GET);    //算算全部多少東西
    if ($_GET['pNo1'] == 'NNN') {
        echo "<script>";
            echo "alert('You have not selected any items for checkout');";
            echo "location.href='cart.php';";
        echo "</script>";
    }
    if ($_GET['pNo1'] == 'all'){
        $getlength = $rowCount;
    }

    if ($getlength == 0) {
        echo "<script>";
        echo "alert('Please do not checkout again!');";
        echo "location.href='index.php';";
        echo "</script>";
    }
    
    ?>


    <div class="cart">   <!-- 大平台 -->
    

    <!-- 頭段 -->

    <div class="head_sec">
        <span class="logo">
        <a href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-coinbase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12.95 22c-4.503 0 -8.445 -3.04 -9.61 -7.413c-1.165 -4.373 .737 -8.988 4.638 -11.25a9.906 9.906 0 0 1 12.008 1.598l-3.335 3.367a5.185 5.185 0 0 0 -7.354 .013a5.252 5.252 0 0 0 0 7.393a5.185 5.185 0 0 0 7.354 .013l3.349 3.367a9.887 9.887 0 0 1 -7.05 2.912z"></path>
            </svg>
        </a>
        </span>
        <span class="logo_side">
            |  Confirm Your Order
        </span>
    </div>


    <!-- 欄位 -->

	<div class="cart_bar">
		<span class="cart_bar_col1">Product</span>
		<span class="cart_bar_col2">Unit Price</span>
		<span class="cart_bar_col3">Quantity</span>
		<span class="cart_bar_col4">Total Price</span>
	</div>

    <form action="ECpay.php" method="post" id="formTrans">


    <!-- 訂單內容 -->
    
    <?php

   
   
    $contain = $db->query("SELECT DISTINCT `mId` FROM Product WHERE pNo IN (SELECT pNo FROM Contain WHERE mId = '$user[mId]')");

    $payprice = 0;      //要付多少錢勒

    $tempSeller = 0;    //暫存當前迴圈印出的商品的賣家

    $no = 1;

    for ($i=1; $i<=$getlength; $i++) {
        $ROW = $row->fetch();
        if ($_GET['pNo1'] == 'all') $pNo = $ROW['pNo'];
        else {
            $pNo = $_GET['pNo'.$i];
            if ($_GET['pNo'.$i] == 'null') {
                continue;
            }
        }

        

        $cart_product = $db->query("SELECT * FROM Product WHERE pNo = '$pNo'");
        $cart_product = $cart_product->fetch();

        $pName = $db->query("SELECT storeName FROM Seller WHERE mId IN(SELECT mId FROM product WHERE pNo = '$pNo')");
        $pName = $pName->fetch();
        
        if ($cart_product['mId'] != $tempSeller) { ?>
            
            <!--  賣家是誰 -->

            <div class='product_seller_head'>
                <span class='product_seller'>Seller : <?php echo $pName['storeName'] ?></span>
            </div>
                
            <hr style='background-color: #d9d9d9; height:1px; border:none'>

        <?php
            $tempSeller = $cart_product['mId'];
        }
        
        $cart = $db->query("SELECT * FROM Contain WHERE pNo = '$pNo'");
        $cartf = $cart->fetch();
        
        ?>

        <div class='cart_product_detail'>  <!-- 商品條 -->

        <!-- 圖片片 -->
		<img class="product_img" src="<?php echo "images/".$cart_product['pImage'] ?>">

        <!-- 品名名 -->
	    <span class="product_head"><?php echo $cart_product['pName'] ?></span>

        <!-- 規格子 -->
		<span class="product_head_specs"></span>
        <!-- Variations:<br> -->
        <?php // echo $cart_product['pSpecs'] ?>

        <!-- 單價子 -->
		<span class="product_unit_price">$<?php echo $cart_product['unitPrice'] ?></span>

        <!-- 數量了 -->
		<span class="product_unit_amount"><?php echo $cartf['amount'] ?></span>

        <!-- 小計額 -->
        <?php $totalprice = $cartf['amount'] * $cart_product['unitPrice']; ?>
		<span class="product_unit_tprice">$<?php echo $totalprice ?></span>
        
        </div>  <!-- 商品條 -->


        <input type="hidden" name="order_pNo<?php echo $no ?>" value="<?php echo $pNo?>">
        <?php   
        $payprice += $totalprice;

        ?>
        <input type="hidden" name="order_pNo<?php echo $no ?>" value="<?php echo $pNo?>">
        
        <?php
            $no++;
        ?>
        
        <script>

            string = string + <?=$pNo?> + ",";
            string_amount = string_amount + <?=$cartf['amount']?> + ",";

            

        </script>

        
    <?php
    }   ?>

    <!-- 備註 -->

    <div class="trans_info">
        <input type="text" placeholder="Remarks..." class="remark" name="remark" id="remark">
    </div>


    <!-- 地址 -->

    <div class="trans_info" class="shipping_opt" id="shippingOptionsContainer">
        <div class="trans_info_title">Shipping Options</div>
        <div class="shipping_opt_text">
            <span>Name</span>
            <input type="text" class="shipping_opt_input" style="margin: 15px 0 0 15px" id="name" name="name" oninput="this.value=this.value.replace(/[^a-zA-Z]/g,'')" required="required">
            <span style="padding-left: 100px">Phone Number</span>
            <input type="text" class="shipping_opt_input" name="phone" id="phone" oninput = "value=value. replace(/[^\d]/g,'')" required="required" maxlength="10">
        </div>
        <div class="shipping_opt_adress">
            <span>Address</span>
            <input type="text" class="shipping_opt_input" id="adress" style="width: 597px" name="adress" oninput = "value=value.replace(/[^\w_]/g,''')" required="required">
        </div>
    </div>


    <!-- 付款 -->

    <div class="trans_info">
        <div class="pay_section">
            <div class="trans_info_title">Payment Method</div>
            <span class="paytotal">Total Payment</span>
            <span class="paytotal_price">$<?php echo $payprice ?></span>
        </div>
        <div class="pay_section">
            <button type="submit" class="pay_method" name="paymethod" value="DBC">Debit Card</button>
            <button type="submit" class="pay_method" name="paymethod" value="CRD">Credit Card</button>
            <button type="submit" class="pay_method" name="paymethod" value="ATM">Bank Transfer</button>
            <button type="button" style="cursor:not-allowed;" disabled id="cryptocurrency_button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="pay_method" name="paymethod" value="Crypto">Cryptocurrency</button>
        </div>
    </div>

    <script>
        function good(){

                    var nameInput = $("#name").val();
                    var phoneInput = $("#phone").val();
                    var addressInput = $("#adress").val();
                    var remarkInput = $("#remark").val();
                    console.log(nameInput);

                 


                    // window.location.href = "crypto_order.php";
        }

        document.addEventListener('DOMContentLoaded', () => {
            const connectButton = document.getElementById('connectButton');
            // Rest of your code using connectButton
            const shippingOptionsContainer = document.getElementById('shippingOptionsContainer');
            const cryptocurrencyButton = document.getElementById('cryptocurrency_button');

            // Add an event listener to the shipping options container to check for changes
            shippingOptionsContainer.addEventListener('input', () => {
                const nameInput = document.querySelector('input[name="name"]');
                const phoneInput = document.querySelector('input[name="phone"]');
                const addressInput = document.querySelector('input[name="adress"]');
                const remarkInput = document.querySelector('input[name="remark"]');

                // Enable the cryptocurrency button if all shipping options are filled
                if (nameInput.value.trim() !== '' && phoneInput.value.trim() !== '' && addressInput.value.trim() !== '') {
                    cryptocurrencyButton.disabled = false;
                    cryptocurrencyButton.style.cursor = "pointer";
                    cryptocurrencyButton.title = '';
                } else {
                    cryptocurrencyButton.disabled = true;
                    cryptocurrencyButton.style.cursor = "not-allowed";
                    cryptocurrencyButton.title = 'Please enter the shipping options first.'; // Set the tooltip message
                }
                });
        
            });
    </script>
    
    <input type="hidden" name="tprice" value="<?php echo $payprice ?>">     <!-- 總價 -->
    <input type="hidden" name="rowCount" value="<?php echo $no-1 ?>">

    </form>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="text-align:center;">
                <div class="modal-header" style="text-align:center;">
                    <h5 class="modal-title" id="staticBackdropLabel">Cryptocurrency Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="loader" id="loader"></div>
                    
                    <div style="width:400px; display:flex; align-items:center;">
                            <div style="width:80px; padding-left:40px"><img style="width:25px; height:25px;" src="images/order-delivery.png" alt=""></div> 
                            <div><p style="width:120px">Payment Detail</p></div>
                    </div>
                    <div style="width:400px; display:flex; align-items:center; margin-top:15px;">
                            <div><p style="width:150px; margin-left:33px; font-size:19px; font-weight:bold;">Total amount</p></div>
                            <div><p style="width:200px; font-size:19px; font-weight:bold;">$<?php echo $payprice ?></p></div>
                    </div>
                    <button id="connectButton" style="width:90%; margin-top:20px; border-radius:5px;">Connect Metamask</button>
                    <button id="transferButton" style="width:90%; margin-top:10px; border-radius:5px; cursor:not-allowed;" disabled>Confirm Transcation</button>
                    <div style="width:auto; display:flex; align-items:center; margin-top:25px;" class="alert alert-warning" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>    
                        <div><p style="font-size: 13px;">Please do not close the window before the payment is completed.</p></div>
                    </div>
                    <script>
                        var paypriceho = <?php echo $payprice; ?>;
                        let web3;
                        const tokenAddress = '0xFB7c4019Df9e16737DAE493163A6094c56B4026e';
                        const connectButton = document.getElementById('connectButton');
                        const transferButton = document.getElementById('transferButton');

                        connectButton.addEventListener('click', async () => 
                        {
                            const loader = document.getElementById("loader");
                            loader.style.display = "block";
                            // Prompt user to connect to Metamask
                            if (window.ethereum) 
                            {
                                try 
                                {
                                    await window.ethereum.request({ method: 'eth_requestAccounts' });
                                    web3 = new Web3(window.ethereum);
                                    address = await web3.eth.getCoinbase();
                                    const connectButton = document.getElementById("connectButton");
                                    connectButton.innerHTML = address;
                                    transferButton.disabled = false;
                                    transferButton.style.cursor = "pointer";
                                    console.log('Connected to Metamask');
                                } 
                                catch (error) 
                                {
                                    console.error(error);
                                }
                            } 
                            else 
                            {
                                console.error('Metamask not detected');
                            }
                            loader.style.display = "none";
                        });
                        
                        transferButton.addEventListener('click', async () => 
                        {
                            const loader = document.getElementById("loader");
                            loader.style.display = "block";
                            // Define transfer parameters
                            const fromAddress = (await web3.eth.getAccounts())[0];
                            const toAddress = '0xa43a1610072207e46bd3e17B1d723a1Bca66020B';
                            const paypricehohoho = paypriceho.toString();
                            const amount = web3.utils.toWei(paypricehohoho, 'ether'); 

                            // Get current network ID
                            const networkId = await web3.eth.net.getId();

                            // Check if network is Binance Smart Chain Testnet
                            if (networkId === 97) 
                            {
                                const tokenContract = new web3.eth.Contract(ERC20ABI, tokenAddress);

                                try 
                                {
                                // Approve token transfer
                                    await tokenContract.methods.approve(toAddress, amount).send({ from: fromAddress });

                                    // Transfer tokens
                                    tokenContract.methods.transfer(toAddress, amount).send({ from: fromAddress })
                                        .on('transactionHash', (txHash) => 
                                        {
                                            console.log(`Sent transaction with hash: ${txHash}`);
                                            setTimeout(() => {
                                                loader.style.display = "none";
                                                // add into transaction and delete contain
                                                var nameInput = $("#name").val();
                                                var phoneInput = $("#phone").val();
                                                var addressInput = $("#adress").val();
                                                var remarkInput = $("#remark").val();
                                                
                                                
                                                $.ajax({
                                                    url: "crypto_order.php?name=" + nameInput + "&pphone=" + phoneInput + "&address=" + addressInput + "&remark=" + remarkInput,
                                                    type: "GET",
                                                    data: {
                                                        pNo: string,
                                                        amount: string_amount
                                                            },
                                                    success: function (data){
                                                        alert("付款成功！");
                                                        location.href='index.php';
                                                    },
                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                        // Handle error
                                                        console.error('Request failed:', textStatus, errorThrown);
                                                    }
                                                });

                                            },  3000);
                                        })
                                    
                                        .on('error', (error) => 
                                        {
                                            console.error(error);
                                        });
                                } catch (error) 
                                {
                                    console.error(error);
                                }
                            } 
                            else 
                            {
                                alert('Please switch to Binance Smart Chain Testnet');
                                try 
                                {
                                    await ethereum.request({
                                    method: 'wallet_switchEthereumChain',
                                    params: [{ chainId: '0x61' }], // Binance Smart Chain Testnet chain ID
                                });
                                } 
                                catch (error) 
                                {
                                    console.error(error);
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

</body>
</html>