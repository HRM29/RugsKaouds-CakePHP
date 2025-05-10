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

	.button {
		display: inline-block;
		padding: 10px 20px;
		margin-top: 15px;
		font-size: 16px;
		color: #ffffff;
		background-color: #881c06;
		text-decoration: none;
		border-radius: 5px;
	}

	.button:hover {
		background-color: #881c06;
	}
</style>

<div class="container">
	<div class="header">
		Thank You for Your Request!
	</div>
	<div class="content">
		<p>Dear <?php echo $data['first_name'].' '.$data['last_name'] ?>,</p>
		<p>Thank you for submitting your rug appraisal request. We have received your request and will get back to you shortly.</p>
		<p><strong>Preferred Date:</strong> <?php echo $data['preferred_date'] ?></p>
		<p><strong>Alternate Date:</strong> <?php echo $data['alternate_date'] ?></p>
		<p><strong>Problem Reported:</strong> <?php echo $data['rug_request_problem'] ?></p>
		<p>If you have any questions, feel free to reach out to us.</p>
		<a href="mailto:<?php echo $mail_to; ?>" class="button">Contact Support</a>
	</div>
	<div class="footer">
		&copy; <?php echo date('Y') ?> Kaoud Carpets & Rugs | Customer Support
	</div>
</div>