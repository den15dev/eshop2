<?php

declare(strict_types=1);

return [
    'greeting' => 'Hello, :name!',
    'signature1' => 'Regards,',
    'signature2' => 'Electronics store team',
    'footer' => 'You received this message because you placed an order on the :link website. If it was not you, please ignore this letter, or contact us.',
    'copyright' => 'Electronics store. All rights reserved.',

    'order_sent' => [
        'subject' => 'Order :id has been sent.',
        'body' => 'The order :id for amount :total_cost_formatted has been sent by delivery service to the address you specified. You can view information about orders and track their status in the :orders_link section.',
    ],
];
