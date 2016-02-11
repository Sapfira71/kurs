<pre>
    <?php print_r($_POST)?>
</pre>
<table>
    <tr>
        <td>Vendor code:</td>
        <td><input type="text" name="vendorCode" value="<?=$_POST["vendorCode"]?>"></td>
    </tr>
    <tr>
        <td>Name:</td>
        <td><input type="text" name="name" value="<?=$_POST["name"]?>"></td>
    </tr>
    <tr>
        <td>Price:</td>
        <td>from <input type="text" name="price1" value="<?=$_POST["price1"]?>"> to <input type="text" name="price2" value="<?=$_POST["price2"]?>"></td>
    </tr>
    <tr>
        <td>Quantity:</td>
        <td><input type="checkbox" name="quantity" value="<?=$_POST["quantity"]?>"></td>
    </tr>
</table>
<input type="submit" value="Submit">
<input type="reset" value="Reset">
<br/>
<br/>