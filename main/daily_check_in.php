<?php require 'includes/db.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/web3/dist/web3.min.js"></script>
<script>
    const abi = [
      // ABI code
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

</script>
<link rel="stylesheet" href="styles/dailycheckin/dailycheckin.css">
<div id="check_inner_box">
    <div class="title_box">
        <div class="title">Check In To Earn Money</div>
        <button id="connectButton">Connect Wallet</button>
    </div>
    
    <div id="check_in_box">
        <button id="0" class="dayButton" onclick="checkIn()">
            Sunday
            <img src="images/diamond.png">
        </button>
        <button id="1" class="dayButton" onclick="checkIn()">Monday
        <img src="images/diamond.png"></button>
        <button id="2" class="dayButton" onclick="checkIn()">Tuesday  <img src="images/diamond.png"></button>
        <button id="3" class="dayButton" onclick="checkIn()">Wednesday  <img src="images/diamond.png"></button>
        <button id="4" class="dayButton" onclick="checkIn()">Thursday  <img src="images/diamond.png"></button>
        <button id="5" class="dayButton" onclick="checkIn()">Friday  <img src="images/diamond.png"></button>
        <button id="6" class="dayButton" onclick="checkIn()">Saturday  <img src="images/diamond.png"></button>
    </div>
</div>
<script>
    var weekday = ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];

    var d = new Date();
    var dayIndex = d.getDay();
    var day = weekday[dayIndex];
    console.log(d);
    console.log(day);
    document.querySelectorAll(".dayButton").forEach(elem => {
        elem.disabled = true;
    });

    let web3;
    let address;
    const tokenContractAddress = "0xFB7c4019Df9e16737DAE493163A6094c56B4026e";
    const privateKey = "d84b8fad2b9ee025c328d1eea5847d7fe333352449a3df25d1d39387d1f2be60";

    const connectButton = document.getElementById("connectButton");
    connectButton.addEventListener("click", connectWallet);

    async function connectWallet() {
      if (window.ethereum) {
        try {
          await window.ethereum.request({ method: "eth_requestAccounts" });
          web3 = new Web3(window.ethereum);
          address = await web3.eth.getCoinbase();
          const connectButton = document.getElementById("connectButton");
          connectButton.innerHTML = address;
          document.getElementById(dayIndex.toString()).disabled = false;
        } catch (error) {
          console.error(error);
        }
      } else {
        console.error("Metamask not detected");
      }
    }

    async function handleTransfer() {
      if (!web3) {
        alert("Please connect your wallet first!");
        return;
      }

      try {
        const contract = new web3.eth.Contract(abi, tokenContractAddress);
        const txParams = {
          from: address,
          to: tokenContractAddress,
          gas: 200000,
          gasPrice: web3.utils.toWei("10", "gwei"),
          data: contract.methods.transfer(address, (500 * 10 ** 18).toString()).encodeABI(),
        };

        const signedTx = await web3.eth.accounts.signTransaction(txParams, privateKey);
        const txReceipt = await web3.eth.sendSignedTransaction(signedTx.rawTransaction);

        alert("You have received a reward.");
      } catch (error) {
        console.error(error);
      }
    }

    const receiveButton0 = document.getElementById("0");
    const receiveButton1 = document.getElementById("1");
    const receiveButton2 = document.getElementById("2");
    const receiveButton3 = document.getElementById("3");
    const receiveButton4 = document.getElementById("4");
    const receiveButton5 = document.getElementById("5");
    const receiveButton6 = document.getElementById("6");

    receiveButton0.addEventListener("click", handleTransfer);
    receiveButton1.addEventListener("click", handleTransfer);
    receiveButton2.addEventListener("click", handleTransfer);
    receiveButton3.addEventListener("click", handleTransfer);
    receiveButton4.addEventListener("click", handleTransfer);
    receiveButton5.addEventListener("click", handleTransfer);
    receiveButton6.addEventListener("click", handleTransfer);

    function checkIn(){
        $.ajax({
            url: 'check_in_ajax.php?day=' + day,
            type: 'GET',
            data: 'html',
            success: function(response){
                console.log("hello");
            }
        })
    }
</script>