<style>
	body {
		font-family: Arial, sans-serif;
	}

	.container {
		width: 100%;
		max-width: 600px;
		background: #ffffff;
		margin: 20px auto;
		padding: 20px;
		border-radius: 8px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	}

	.header {
		background-color: #881c06;
		color: #ffffff;
		text-align: center;
		padding: 15px;
		font-size: 20px;
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
	}

	.content {
		padding: 20px;
		color: #333333;
	}

	.footer {
		background-color: #f4f4f4;
		text-align: center;
		padding: 10px;
		font-size: 14px;
		color: #666666;
	}
</style>
<div class="container">
	<div class="header">
		New Rug Sell Request
	</div>
	<div class="content">
		<p><strong>Seller Name:</strong> <?php echo $data['first_name'] . ' ' . $data['last_name'] ?></p>
		<p><strong>Email:</strong> <?php echo $data['email'] ?></p>
		<p><strong>Phone Number:</strong> <?php echo $data['phone_number'] ?></p>
		<p><strong>Address:</strong> <?php echo $data['address_line_1'] . ', ' . $data['address_line_2'];?></p>
		<p><strong>City:</strong> <?php echo $data['city'] ?></p>
		<p><strong>State:</strong> <?php echo $data['state'] ?></p>
		<p><strong>Zip/Postal Code:</strong> <?php echo $data['zip_code'] ?></p>
		<hr>
		<p>Please review and contact the lead as soon as possible.</p>
	</div>
	<div class="footer">
		&copy; <?php echo date('Y') ?> Kaoud Carpets & Rugs | Admin
	</div>
</div>