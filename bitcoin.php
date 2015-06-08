<?php session_start();  ?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bitcoin</title>
        <link rel="stylesheet" type="text/css" href="stylesheetmainphp.css" />
        <script src="js/libs/jquery/jquery.js"></script>
    </head>
    <body>
        
        <?php
        
             //classes must be first
        
            require "functions.php";
            
            require "classes.php";
            
            
            authenticate();
        
           
        
            $mainMenu1 = new mainMenu();
    
            $mainMenu1->displayEN();
            
            $transactionSystem1 = new TransactionSystem();
            

            
            $transactionSystem1->displayTransactionInterface($mysqli);
    
            
            $transactionSystem1->echoJavascriptFunctions();
            
            $transactionSystem1->echoJavascript();
            
            
            $graph1 = new graph();
    
            $graph1->echoCanvas();
    
            $graph1->getContext();
            
            $user1 = new User($con);
            
            //displayForum($mysqli)
            
  
            //$user1->bid($con, 11, 4, $_SESSION['userName']);
            
            //$user1->ask($con, 10, 3, $_SESSION['userName']);
            
            //$user1->ask($con, $amount, $price, $_Session['userName']);
           
            
            /*
            
            create_table_orderbookBitcoin($con);f
            
            create_table_deposits($con);
            
            create_table_transactionsBitcoin($con);
            
            */ 
           
          
            
           
    
        ?>
        
        <div id="copyright">Copyright: ©2015 Joel Smith. All Rights Reserved.</div>
        
            <script>
            
                //document.write("functions written executed");
                function deletePendingOrder(P_Id) 
                {
                
                        
                        
                        $("#"+P_Id).remove();
                    
                    
                
                }
                
           
            
                $(document).ready(function() 
                {
                
                    $(".openOrderCancelButton").click(function(event) 
                    {
                    
                        
                            
                            $.post("ajax.php",
                                {
                                operation:"deletePendingOrder",
                                P_Id:event.target.id
                                
                                
                                },
                                function(data,status){
                                
                                deletePendingOrder(event.target.id);
                                
                                
                                
                                }, "json");
                                
                            window.location.reload();
                    });
                
                });
                
                function updateSite()
                {
                
                    //update current price
                    $.post("ajax.php",{operation:"updateSite"},function(JSON){
                        
                        console.log("JSON data iss: " + JSON.currentPrice);
                        
                        $("#currentPrice").empty().append(JSON.currentPrice);
                            
                    }, "json");
                    

                     //update order book
                    $.post("ajax.php",{operation:"updateOrderbook"}, function(JSON)
                    {
                        var tbdy=document.createElement('tbodybid');
                        
                        var tbdy=document.createElement('tbodyask');
                        
                        var tr=document.createElement('tr');
                        
                        var td=document.createElement('td');
                        
                        td.appendChild(document.createTextNode('Amount'));
                        
                        
                        
                        tbdybid.appendChild(td);
                        
                        var td=document.createElement('td');
                        
                        td.appendChild(document.createTextNode('Price'));                        
                        
                        tbdybid.appendChild(td);
                        
                       var tr=document.createElement('tr');
                        
                        var td=document.createElement('td');
                        
                        td.appendChild(document.createTextNode('Amount'));
                        
                        
                        
                        tbdyask.appendChild(td);                        
                        
                        var td=document.createElement('td');
                        
                        td.appendChild(document.createTextNode('Price'));                        
                        
                        tbdyask.appendChild(td);
                        
                        for(var i = 0; i < JSON.length; i++) {
                            var obj = json[i];
                            
                            
                            
                          
                            var tr=document.createElement('tr');
                                
                            var td=document.createElement('td');
                                
                            td.appendChild(obj[1]);
                            
                            tr.appendChild(td)
                            
                            
                            var td = document.createElement('td');
                            
                            td.appendChild[obj[2]];
                            
                            tr.appendChild(td);
                            
                            
                            if(obj[3] == "true")
                            {
                            

                            tbdybid.appendChild(tr);
                        }
                        else if (obj[3] == "true")
                        {
                            tbdyask.appendChild(tr);
                        }
                        }
                         
                    
                    //bid is 3, ask is 4
                    $("#orderbookBidTable").empty().append(tbdybid);
                    $("#orderbookBidTable").empty().append(tbdyask);
                        

                        
                        //orderbookBidTable
                        //orderbookAskTable
                       // $("#orderbookPendingAskTable").empty().append(JSON.currentPrice);

                       
                    }, "json");
                    
                    //update pending orders
                    $.post("ajax.php", {operation:"updatePendingOrders"}, function(JSON)
                    {
                       // $("#orderbookBidTable").empty().append(JSON.currentPrice);
                       // $("#orderbookAskTable").empty().append(JSON.currentPrice);
                        
                                                //orderbookPendingBidTable
                        //orderbookPendingAskTable
                       
                    }, "json");                    
                   
                    
                    
                    
                };
                                
                
                
                
                //update the site
                $(document).ready(function()
                {
                
                    
                    setInterval("updateSite()",1000);
                });
                
                
                
            
                //ajax for sell form
                $(document).ready(function()
                {
                    
                    $("#sellForm").submit(function(event){
                        
                        event.preventDefault();
                        
                        var $form = $(this),
                        term = $form.find("input[name='amount']").val(),
                        term2 = $form.find("input[name='price']").val(),
                        url = $form.attr("action");
                        
                        var posting=$.post(url, {operation:"sellForm", amount: term, price: term2}, "json");
                         
                        
                        posting.done(function(data) {
                            
                            console.log(data.success);
                            
                            if (data.success == "notEnoughBalance")
                            {
                                alert("You do not have enough balance for this transaction.");
                            }
        //dont be updating the site here, all updating should be done by update site ajax function
                            
                        });
                        
                        
                    });
                
                    
                    
                });
                
                //ajax for buy form
                $(document).ready(function()
                {
                
                    $("#buyForm").submit(function(event){
                        
                        
                        event.preventDefault();
                        
                        alert("Your buy order has been placed");
                        
                            window.location.reload(true);
                        
                        var $form = $(this),
                        term = $form.find("input[name='amount']").val(),
                        term2 = $form.find("input[name='price']").val(),
                        url = $form.attr("action");
                        
                        var posting=$.post(url, {operation:"buyForm", amount: term, price: term2});
                        
                        posting.done(function(data) {
                            
                            console.log(data.success);
                            
                            if (data.success == "notEnoughBalance")
                            {
                                alert("You do not have enough balance for this transaction.");
                            }
                            
                        });
                        
                        
                    });
                        
                    $("#sellForm").submit(function(event){
                        
                        
                        event.preventDefault();
                        
                        alert("Your sell order has been placed.");
                        
                            window.location.reload(true);
                        
                        var $form = $(this),
                        term = $form.find("input[name='amount']").val(),
                        term2 = $form.find("input[name='price']").val(),
                        url = $form.attr("action");
                        
                        var posting=$.post(url, {operation:"buyForm", amount: term, price: term2});
                        
                        posting.done(function(data) {
                            
                            console.log(data.success);
                            
                            if (data.success == "notEnoughBalance")
                            {
                                alert("You do not have enough balance for this transaction.");
                            }
                            
                        });
                        
                        
                    });
                        
                        
                        
                    //});
                    
                    
                });
                    
                        
                        
                        
                                        
                        
                    
                    
                
                    
                    
            
                    
                
                

            </script>
            
            
            
            
    </body>
</html>
