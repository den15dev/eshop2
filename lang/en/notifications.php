<?php

declare(strict_types=1);

return [
    'greeting' => 'Hello, :name!',
    'signature1' => 'Regards,',
    'signature2' => 'Electronics store team',
    'copyright' => 'Electronics store. All rights reserved.',

    'order_sent' => [
        'subject' => 'Order :id has been sent.',
        'body' => 'The order :id for amount :total_cost_formatted has been sent by delivery service to the address you specified. You can view information about orders and track their status in the :orders_link section.',
        'footer' => 'You received this message because you placed an order on the :link website. If it was not you, please ignore this message.',
    ],

    'verify_email' => [
        'subject' => 'Verify Email Address',
        'body1' => 'Please click the button below to verify your email address.',
        'button' => 'Verify Email Address',
        'body2' => 'If you did not create an account, no further action is required.',
        'body_issues' => 'If you\'re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:',
        'footer' => 'You received this message because you registered on the :link website. If it was not you, please ignore this message.',
    ],

    'reset_password' => [
        'subject' => 'Reset Password Notification',
        'body1' => 'You are receiving this email because we received a password reset request for your account.',
        'button' => 'Reset Password',
        'body2' => 'This password reset link will expire in 60 minutes.',
        'body3' => 'If you did not request a password reset, no further action is required.',
        'body_issues' => 'If you\'re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:',
        'footer' => 'You received this message because you requested a password reset on the :link website. If it was not you, please ignore this message.',
    ],
];
