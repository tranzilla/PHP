<?php //foodtruckitems.php

//--- INITIALIZE VARIABLES ---
$Total = 0;
$ItemSubtotal = 0;
$Extraquantity = 0;
$ExtraSubtotal = 0;
$TaxRate = .106;
$Tax = 0;
$itemsSubtotal = 0; 

// --- ADD ITEMS ---
$myItem = new Item(1,"Burgers","Eat a Burger!",6.95,0);
$myItem->addExtra("Bacon");
$myItem->addExtra("Cheese");
$myItem->addExtra("Extra Burger Pattie");
$items[] = $myItem;

$myItem = new Item(2,"Fries","Eat more French Fries!",4.95,0);
$myItem->addExtra("Gravy");
$myItem->addExtra("Cheese");
$myItem->addExtra("Baked Beans");
$items[] = $myItem;

$myItem = new Item(3,"Shake","Our Villina Shakes are awesome!",5.95,0);
$myItem->addExtra("More Ice Cream");
$myItem->addExtra("Strawberries");
$myItem->addExtra("Cherries");
$myItem->addExtra("Super Size");
$items[] = $myItem;

// --- BEGIN ITEM CLASS ---
class Item 
{
    public $ID = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Quantity = 0;
    public $Extraname = array();
    public $Extraprice = array();
    public $Extraquantity = array();
    public function __construct($ID, $Name, $Description, $Price, $Quantity) 
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        $this->Quantity = $Quantity;
    } // --- END ITEM CONSTRUCTOR ---
	
	//---CREATE FUNCTION TO ADD EXTRA
    public function addExtra($Extraname)
    {
        $this->Extranames[] = $Extraname;   
		
    } // --- END ADDEXTRA FUNCTION ---
}// --- END ITEM CLASS --

//START IF BLOCK 
if(isset($_POST['submit'])) {   
    foreach($items as $item) {      
    $item->Quantity += (int)$_POST[$item->Name]; 
        foreach($item->Extranames as $Extraname) {
            $Extraquantity += (int)$_POST[$Extraname];            
        }
    }
    $ExtraSubtotal = $Extraquantity * 0.75;
	
    // --- CREATING A TABLE TO DISPLAY PURCHASED ITEMS ---
    echo " 
    <div>
        <h2>Here is your cart:</h2>
        <table class=\"order-detail\">
        <tr>
            <th>Item Ordered</th>
            <th class=\"number\">Qty</th>
            <th class=\"number\">Item Price</th>
            <th class=\"number\">Item Subtotal</th>    
        </tr>";
	
        foreach ($items as $item) { // --- CREATES A LOOP THAT DISPLAYS ITEMS ORDERED IN A TABLE --
            if ($item->Quantity > 0) {
                $itemSubtotal = $item->Price * $item->Quantity;
                $itemsSubtotal += $itemSubtotal;
            echo "
                <tr>
                    <td>$item->Name</td>
                    <td class=\"number\">$item->Quantity</td>
                    <td class=\"number\">$item->Price</td>
                    <td class=\"number\">$itemSubtotal</td>  
                </tr>
                ";   
            } else {
				
            echo ''; //---DISPLAY NOTHING -- 
            }   
        }
        echo "
        <tr>
                    <td>Extras</td>
                    <td class=\"number\">$Extraquantity</td>
                    <td class=\"number\">.75</td>
                    <td class=\"number\">$ExtraSubtotal</td>
                </tr>
        </table>
        ";

    $itemsSubtotal += $ExtraSubtotal;
    $Tax = $itemsSubtotal * $TaxRate;
    $Total = $itemsSubtotal + $Tax;
    $Tax = number_format($Tax, 2);
    $Total = number_format($Total, 2);
    echo "<table class=\"order-total\">
        <tr>
            <td>Subtotal</td>
            <td class=\"number\">$itemsSubtotal</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class=\"number\">$Tax</td>
        </tr>
        <tr>
            <td>Total</td>
            <td class=\"number\">$Total</td>
        </tr>
        </table>
        </div>
    ";
} else {
    echo '
    <form action="" method="post">
    <div>
    ';
            /// ---- CREATED FIELDSETS AND LABEL FORS TO DISPLAY "ORDER PAGE" ----
        foreach($items as $item) {
            echo "
            <fieldset>
            <p> $item->Name is $item->Price.</p>
            <p>Description: $item->Description</p>
            <p><label for=\"$item->Name\">Qty: </label>
            <input type=\"number\" name=\"$item->Name\"><p>
            ";
            echo " <p>Extras available for $ .75: </p>";
            foreach ($item->Extranames as $Extraname) {
                echo " 
                   <p><label for=\"$Extraname\">$Extraname </label>
                    <input type=\"number\" name=\"$Extraname\"></p>
                ";
            }
            echo "</fieldset>";
        }
 
    echo '
    <p>
    <input type="submit" name="submit" value="Order" id="submit"/>
    </p>
    </form>
    </div>
    ';
}
?>