<?php
    require_once 'database.php';
    $customer_id= filter_input(INPUT_GET,'customer_id',FILTER_VALIDATE_INT);
    if($customer_id==null||$customer_id==false){
        $customer_id=10;
    }
    
    //get of the selected customer
    $querycustomer='select distinct customers.CustomerID,Name from customers inner join invoices on customers.customerID=invoices.customerID where customers.customerID=:customer_id';
    $statement1=$db->prepare($querycustomer);
    $statement1->bindvalue(':customer_id',$customer_id);
    $statement1->execute();
    $Customer=$statement1->fetch();
    $customer_Name=$Customer['Name'];
    $statement1->closecursor();
    
    //get all customers with invoices
    $queryallcustomers='select distinct customers.CustomerID,Name from customers inner join invoices on customers.customerID=invoices.customerID order by customers.CustomerID';
            $statement2=$db->prepare($queryallcustomers);
            //$statement2->bindvalue(':customer_id',$customer_id);
            $statement2->execute();
            $customers=$statement2->fetchall();
            $statement2->closecursor();
            
            //Get invoices for selected customers
                $queryinvoices='select InvoiceID,InvoiceDate,InvoiceTotal from invoices where customerID=:customer_id order by InvoiceID';
                $statement3=$db->prepare($queryinvoices);
                $statement3->bindvalue(':customer_id',$customer_id);
                $statement3->execute();
                $invoices=$statement3->fetchall();
                $statement3->closecursor();
                          
                ?>
<!<!doctype html>
<html>
    <head>
        <title>Customer Invoice Application.</title>
        <link rel="stylesheet" type="text/css" href="main.css">
        <link rel="icon" type="image/x-icon" href="favico.ico">
    </head>
    <body>
        <main>
            <h1>Invoice List.</h1>
            <aside>
                <h2>Customers</h2>
                <nav>
                    <ul>
                        <?php foreach($customers as $Customer): ?>
                        <li>
                            <a href="?customer_id=<?php echo $Customer['CustomerID']; ?>"><?php echo $Customer['Name']; ?></a>
                        </li>
                        <?php endforeach; ?>
                        </ul>
                </nav>
            </aside>
            <section>
                <!---------display a table of invoices----->
                <h2><?php echo $customer_Name; ?></h2>
                <table>
                    <tr>
                    <th>InvoiceID</th>
                    <th>InvoiceDate</th>
                    <th>InvoiceTotal</th>
                    </tr>
                    <tr>
                        <?php foreach($invoices as $invoice): ?>
                        <td><?php echo $invoice['InvoiceID']; ?></td>
                        <td><?php echo $invoice['InvoiceDate']; ?></td>
                        <td class="right"><?php echo $invoice['InvoiceTotal']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                </section>
        </main>
        <footer></footer>
    </body>
</html>