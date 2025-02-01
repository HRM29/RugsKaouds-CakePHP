<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 0; background-color: #f9f9f9;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f9f9f9">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="margin: 20px auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h2 style="color: #881c06;"><?= $header_message; ?></h2>
                        </td>
                    </tr>

                    <!-- Intro Message -->
                    <tr>
                        <td style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border-left: 5px solid #881c06; text-align: center;">
                            <p><?= $intro_message; ?></p>
                        </td>
                    </tr>
                    <?php 
                    // echo "<pre>Data: ";print_r($data);echo "</pre>";
                    ?>
                    <!-- Customer Information -->
                    <tr>
                        <td style="padding: 20px 0;">
                            <h3 style="color: #881c06; margin-bottom: 10px;">Customer Information</h3>
                            <table width="100%" cellspacing="0" cellpadding="8" border="0" style="border-collapse: collapse; background: #fff;">
                                <tr>
                                    <th align="left" width="40%" bgcolor="#881c06" style="color: #fff; padding: 10px;">First Name</th>
                                    <td><?= h($data['first_name']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Last Name</th>
                                    <td><?= h($data['last_name']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Email</th>
                                    <td><?= h($data['email']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Phone</th>
                                    <td><?= h($data['phone_number']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Address</th>
                                    <td><?= h($data['address_line_1']) ?><br><?= h($data['address_line_2']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">City</th>
                                    <td><?= h($data['city']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">State</th>
                                    <td><?= h($data['state']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Zip Code</th>
                                    <td><?= h($data['zip_code']) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Pickup Details -->
                    <tr>
                        <td>
                            <h3 style="color: #881c06;">Pickup Information</h3>
                            <table width="100%" cellspacing="0" cellpadding="8" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Preferred Date</th>
                                    <td><?= h($data['preferred_date']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Preferred Time</th>
                                    <td><?= h($data['preferred_time']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Alternate Date</th>
                                    <td><?= h($data['alternate_date']) ?></td>
                                </tr>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Alternate Time</th>
                                    <td><?= h($data['alternate_time']) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Rug Details -->
                    <tr>
                        <td>
                            <h3 style="color: #881c06;">Rug Details</h3>
                            <table width="100%" cellspacing="0" cellpadding="8" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Rug Type</th>
                                    <td><?= h($data['rug_type']) ?></td>
                                </tr>
                                <?php if ($data['rug_type'] == 'Other'): ?>
                                    <tr>
                                        <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Other Rug Type</th>
                                        <td><?= h($data['rug_type_other_text']) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th align="left" bgcolor="#881c06" style="color: #fff; padding: 10px;">Rug Condition</th>
                                    <td><?= nl2br(h($data['rug_condition'])) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top: 20px; border-top: 1px solid #ddd;">
                            <p><a href="www.kaouds.com" style="color: #881c06; text-decoration: none;">Visit Our Website</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>