<?php

echo "<pre>";
print_r($_POST);  ?>

<form name="bbb" action="" method="post">
<div id="POItablediv">
    <input type="button" id="addPOIbutton" value="Add Adjustment"/><br/><br/>
    <table id="POITable" border="1">
        <tr>
            <td>Adj No</td>
            <td>Item SKU</td>
            <td>Qty in Stock</td>
            <td>Adj Qty</td>
            <td>Item Cost</td>
            <td>Description</td>
            <td>Delete?</td>
           
        </tr>
        <tr>
            <td>1</td>
            <td><input size=10 type="text"  name ="Sku" id="Sku"/><Span id="a">search</span></td>
            <td><input size=15 type="text" id="qtyInStock" id="qtyInStock" /></td>
            <td><input size=10 type="text" id="adjQty" id="adjQty" /></td>
            <td><input size=15 type="text" id="itemCost" id="itemCost" /></td>
            <td><input size=40 type="text" id="description"  id="description" /></td>
            
            <td><input type="button" id="delPOIbutton" value="Delete" onclick="deleteRow(this)"/></td>
            
        </tr>
    </table>
    
    <div><input type="button" id="addmorePOIbutton" value="Add More Adjustment" onclick="insRow()"/>
    
    <input type="submit" id="adjustbutton" value="Add adjustment" /></div>
</div>
    </form>
<script>
 function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(i);
}


function insRow()
{
    console.log( 'hi');
    var x=document.getElementById('POITable');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
    var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
    x.appendChild( new_row );
}
</script>