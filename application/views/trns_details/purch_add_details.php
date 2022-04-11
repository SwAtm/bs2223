<script>
	window.onload = function(){
	var title = document.querySelector('#title');
	title.focus();
	let btnhandle = document.querySelector('#complete')
	let gstratehandle = document.querySelector('#gstrate');
		function fillvalues(){
		let	details = title.options[title.selectedIndex].value;
		if ('' === details){
			btnhandle.disabled = false;
		} else {
			details1 = JSON.parse(details);
			gstratehandle.value = details1.gst_rate;
			btnhandle.disabled = true;
			console.log(details1);
		}
	}
		title.addEventListener('change',fillvalues);
	}
</script>
<style>
#tb {
table-layout: fixed;
width: 100%;
border: 1px solid black;	
}
th, tr {
border: 1px solid black;	
}
</style>


<table id = "tb">
<tr><th>Title</th><th style="width: 11%">Rate</th><th style="width: 11%">Quantity</th><th style="width: 11%">Discount</th><th style="width: 11%">Cash Disc</th><th style="width: 11%">HSN</th><th style="width: 11%">GST Rate</th><th style="width: 5%"></th></tr><tr>

<?php

if (isset($calling_proc) and 'edit' == $calling_proc):
	echo "<form method = POST action = ".site_url('trns_details/edit_purchase_add').">";
else:
	echo "<form method = POST action = ".site_url('trns_details/purch_add_details').">";
endif;
echo "<td><Select name = item required id = title>";
echo "<option value=''>Title</option>";
foreach ($item as $key => $value) {
	$optvalue = json_encode(array('item_id'=>$value['id'], 'gst_rate'=>$value['gstrate'], 'rcm'=>$value['rcm'], 'gcat_id'=>$value['gcat_id']));
	echo "<option value = $optvalue>$value[title]</option>";
}
echo "</td>";
echo "</select>";
?>
<td><input type = number size = 15 maxlength = "11" name = rate required step = 0.01 placeholder = 0.00></td>
<td><input type = number size = 15 name = quantity value = 1></td>
<td><input type = number size = 15 name = discount step = 0.01 placeholder = 0.00></td>
<td><input type = number size = 15 name = cash_disc step = 0.01 placeholder = 0.00></td>
<td><input type = number size = 15 maxlength = "14" name = hsn required></td>
<td><input type = number size = 15 name = gst_rate id = gstrate required readonly></td>
<td><input type = submit name = add value = Add></td></tr>
<tr><td colspan = 4 align = center><input type = submit name =  complete id = complete formnovalidate="formnovalidate" value = 'Bill Over'></td>
<td colspan = 4 align = center><input type = submit name =  cancel id = cancel formnovalidate="formnovalidate" value = 'Cancel Bill'></td>
</tr>
<?php
echo "</form>";
echo "</table>";

if (isset($details)):
echo "<table width = 100% border = 1><tr><td>Item id</td><td>Rate</td><td>Quantity</td><td>Discount</td><td>Cash Disc</td><td>HSN</td><td>GST Rate</td><td>Amount</td></tr></tr>";
$total = 0;
foreach ($details as $key):
	$amt = (($key['rate']-$key['cash_disc'])*$key['quantity'])-((($key['rate']-$key['cash_disc'])*$key['quantity'])*$key['discount']/100);
	echo "<td>$key[item_id]</td><td>$key[rate]</td><td>$key[quantity]</td><td>$key[discount]</td><td>$key[cash_disc]</td><td>$key[hsn]</td><td>$key[gst_rate]</td><td>".number_format($amt,2)."</td></tr><tr>";
	$total += $amt;
endforeach;
echo "<tr><td colspan = 7 align = center>Total: ".number_format($total,2)."</td></tr>";
echo "</table>";
endif;

?>
