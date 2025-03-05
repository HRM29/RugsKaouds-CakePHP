<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Cake\Core\Configure;
class PHPMailerComponent extends Component {

    /**
     * Sends an email using PHPMailer.
     *
     * @param mixed $to Email address or an array of addresses.
     * @param string $subject The email subject.
     * @param string $body The email body.
     * @param array $config Optional configuration overrides.
     * @return bool|string True on success, or error message on failure.
     */
    public function sendMail($to, $subject, $body, $config = []) {
        // Default configuration; override by passing values in $config
        $defaults = [
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => 587,
            'tls' => true,
            'from' => ['harshit@racknap.com' => 'GOAT']
        ];
        $config = array_merge($defaults, $config);

        $mailer = new PHPMailer(true);

        try {
            // Configure PHPMailer for SMTP:
            $mailer->isSMTP();
            $mailer->Host = $config['host'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $config['username'];
            $mailer->Password = $config['password'];
            $mailer->SMTPSecure = $config['tls'] ? 'tls' : 'ssl';
            $mailer->Port = $config['port'];

            // Set the sender:
            foreach ($config['from'] as $email => $name) {
                $mailer->setFrom($email, $name);
                break;
            }

            // Add recipient(s):
            if (is_array($to)) {
                foreach ($to as $email => $name) {
                    $mailer->addAddress($email, $name);
                }
            } else {
                $mailer->addAddress($to);
            }

            // Set email subject and body:
            $mailer->Subject = $subject;
            $mailer->Body = $body;
            $mailer->isHTML(true);

            $mailer->send();
            return true;
        } catch (Exception $e) {
            // Return the error message for logging or debugging.
            return $e->getMessage();
        }
    }
    
     /**
     * Send an email using PHP's native mail() function.
     *
     * @param string|array $to The recipient email address or an array of addresses.
     * @param string $subject The email subject.
     * @param string $message The email message (HTML or plain text).
     * @param array $headers Optional additional headers as an associative array.
     * @return bool True if the mail function returns true, false otherwise.
     */
    public function sendViaPHPmail($to, $subject, $message, array $headers = [])
    {
        // Process recipient(s)
        if (is_array($to)) {
            $to = implode(',', $to);
        }

        // Define default headers
        $defaultHeaders = [
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=iso-8859-1', // Adjust if sending plain text
            'From'         => Configure::read("App.EmailFrom"),
            'Reply-To'     => Configure::read("App.EmailFrom"),
            'X-Mailer'     => 'PHP/' . phpversion(),
        ];

        // Merge default headers with any custom headers (custom headers override defaults)
        $finalHeaders = array_merge($defaultHeaders, $headers);
        $headersString = '';
        foreach ($finalHeaders as $key => $value) {
            $headersString .= "{$key}: {$value}\r\n";
        }
        echo "<pre>to: ";print_r($to);echo "</pre>";
        echo "<pre>subject: ";print_r($subject);echo "</pre>";
        echo "<pre>headersString: ";print_r($headersString);echo "</pre>";
        echo "<pre>EmailFrom: ";print_r(Configure::read("App.EmailFrom"));echo "</pre>";
        // die();
        // Use PHP's mail() function to send the email
        return mail($to, $subject, $message, $headersString);
    }
}
