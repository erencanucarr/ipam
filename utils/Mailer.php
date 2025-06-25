<?php

// Simple mail utility for notification emails
class Mailer
{
    // Set your sender email here
    private static $from = 'no-reply@yourdomain.com';

    /**
     * Send a notification email
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $message Email body (plain text)
     * @return bool true on success, false on failure
     */
    public static function sendNotificationEmail($to, $subject, $message)
    {
        $headers = "From: " . self::$from . "\r\n" .
                   "Reply-To: " . self::$from . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();
        return mail($to, $subject, $message, $headers);
    }
}