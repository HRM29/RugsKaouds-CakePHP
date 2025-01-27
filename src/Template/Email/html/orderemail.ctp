<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">Dear <strong><?= $user_info->billing_first_name . " " . $user_info->billing_last_name ?></strong>,</p>
<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">Thank you for purchasing on <a href="http://kaouds.com/" style="color: #881c06; text-decoration: none; font-weight: bold;">www.kaouds.com</a>. Here are the details of your order:</p>
<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;"><strong>Order#:</strong> <?= $order_id ?></p>

<style>
	table {
		width: 100%;
		max-width: 800px;
		margin: 20px auto;
		border-collapse: collapse;
		border: 1px solid #ddd;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		font-family: 'Arial', sans-serif;
	}

	th,
	td {
		padding: 12px;
		text-align: center;
		font-size: 14px;
		border: 1px solid #ddd;
	}

	th {
		background-color: #881c06;
		color: #fff;
		font-weight: bold;
		text-transform: uppercase;
	}

	td {
		background-color: #f9f9f9;
	}

	td img {
		height: 100px;
		max-width: 100px;
		border-radius: 8px;
		border: 1px solid #ddd;
	}

	.amount-cell,
	.qty-cell {
		text-align: center;
	}

	.bold {
		font-weight: bold;
	}

	.total-row td {
		font-weight: bold;
		background-color: #f1f1f1;
	}

	.total-row td:last-child {
		text-align: right;
		color: #881c06;
	}

	a {
		color: #881c06;
		text-decoration: none;
	}

	a:hover {
		text-decoration: underline;
	}

	p {
		margin: 10px 0;
		line-height: 1.6;
	}
</style>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Product Name</th>
			<th>Qty.</th>
			<th>Price</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$ttl_qty = 0;
		$sub_total = 0;
		$discount_amount = 0;
		$i = 1;
		foreach ($content as $key => $data) { ?>
			<tr>
				<td><?= $i ?></td>
				<td><?= $data['title'] ?></td>
				<td class="qty-cell"><?= $data['product_qty'] ?></td>
				<td class="amount-cell"><?= "$" . number_format($data['everyday_price'], 2) ?></td>
				<td class="amount-cell"><?= "$" . number_format($data['everyday_price'] * $data['product_qty'], 2) ?></td>
			</tr>
		<?php
			$i++;
		}
		if (!empty($returnCartDetails)) {
			$ttl_qty = $returnCartDetails['cartQty'];
			$cartTotal = $returnCartDetails['cartTotal'];
			$cartGrandTotal = $returnCartDetails['cartGrandTotal'];
			$discount_amount = $returnCartDetails['cartDiscount'];
		?>
			<tr class="total-row">
				<td colspan="2">Total Qty.</td>
				<td><?= $ttl_qty ?></td>
				<td>SubTotal</td>
				<td class="amount-cell"><?= "$" . number_format($cartTotal, 2) ?></td>
			</tr>

			<?php if ($discount_amount > 0): ?>
				<tr class="total-row">
					<td colspan="2">Discount</td>
					<td></td>
					<td>-</td>
					<td class="amount-cell"><?= "$" . number_format($discount_amount, 2) ?></td>
				</tr>
			<?php endif; ?>

			<tr class="total-row">
				<td colspan="2">Total</td>
				<td colspan="3" class="amount-cell"><?= "$" . number_format($cartGrandTotal, 2) ?></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">If you have any questions, contact us at: <a href="mailto:info@kaouds.com" style="color: #881c06; text-decoration: none; font-weight: bold;">info@kaouds.com</a></p>

<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">Thanks & Regards,</p>
<p style="font-family: Arial, sans-serif; font-size: 16px; color: #333;"><strong>Team Kaouds</strong></p>