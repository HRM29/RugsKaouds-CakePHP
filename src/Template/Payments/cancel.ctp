<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 20px;">
    <div style="max-width: 600px; background: #fff; padding: 20px; margin: 0 auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #881c06; margin-bottom: 10px;">New Contact Inquiry</h2>
        <p style="font-size: 16px; line-height: 1.6;">Dear Admin,</p>
        <p style="font-size: 16px; line-height: 1.6;">You have received a new contact inquiry. Details are below:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; width: 30%; color: #555;">Name:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?php echo htmlspecialchars($data['name']); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #555;">Email:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?php echo htmlspecialchars($data['email']); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; color: #555;">Message:</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?php echo nl2br(htmlspecialchars($data['message'])); ?></td>
            </tr>
        </table>

        <p style="margin-top: 10px; font-size: 16px; line-height: 1.6;">Best regards,</p>
        <p style="font-size: 16px; font-weight: bold;">Kaoud Carpets & Rugs</p>
        
        <div style="margin-top: 20px; font-size: 14px; color: #777; text-align: center;">
            <p><strong>*** Please do not reply to this email ***</strong></p>
        </div>
    </div>
</body>