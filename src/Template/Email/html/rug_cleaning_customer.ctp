<style>
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
        text-align: center;
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
        background-color: #6b1403;
    }
</style>
<div class="container">
    <div class="header">
        <?php echo $header_message; ?>
    </div>
    <div class="content">
        <p>Dear Customer,</p>
        <p><?php echo $intro_message ?></p>
        <p>If you have any questions, feel free to contact us.</p>
        <a href="mailto:<?php echo $mail_to; ?>" class="button">Contact Support</a>
    </div>
    <div class="footer">
        &copy; <?php echo date('Y') ?> Rug Cleaning Services | All Rights Reserved
        <p><a href="https://www.kaouds.com" style="color: #881c06; text-decoration: none;">Visit Kaouds.com</a></p>
    </div>
</div>