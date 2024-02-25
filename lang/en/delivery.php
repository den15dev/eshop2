<?php

declare(strict_types=1);

return [
    'delivery' => 'Delivery',

    'express' => [
        'title' => 'Express delivery “Day to day”',
        'pre_payment' => 'Products shipped within Moscow after 100% prepayment on the website.',
        'in_stock' => 'The selected products must be available in one of the Moscow stores.',
        'courier_call' => 'Courier calls 30 minutes before delivery, on the day and interval you choose at the time of placing your order on the website.',
        'end_time' => 'Requests for express courier delivery are accepted until 17:30 on the day of delivery.',
        'availability' => 'Express shipping availability is displayed when you place an order.',
        'intervals' => 'Delivery intervals',
        'from_to' => 'from :start to :end',
    ],

    'regular' => [
        'title' => 'Regular delivery',
        'courier_call' => 'Courier calls an hour before delivery, on the day and interval you choose at the time of placing your order on the website.',
        'end_time' => 'Requests for courier delivery are accepted until 20:00 of the current day with delivery the next day.',
        'cost' => 'The cost of delivery of goods in the interval from 10.00 to 22.00',
    ],

    'conditions' => [
        'title' => 'Delivery conditions',
        'access_roads' => 'Purchased goods are delivered to the apartment (cottage) only if there are access roads to the entrance of the house (cottage). In two-level apartments, multi-storey cottages and dachas, goods are placed on the first floor.',
        'stairs' => 'When manually lifting goods, stairways and flights to the delivery site should not be blocked or crowded.',
        'doors' => 'Staircases and doorways must be clear and allow goods to be freely brought into the premises in packaging (when moving goods through an opening, the width on each side must be at least 10 cm between the goods and the side of the opening). If it is not possible to bring the goods into the apartment (office), the goods are transferred to the client at the place to which delivery was possible.',
        'threshold' => 'The packaged goods are brought beyond the threshold of the premises to which the order is delivered; the goods are not moved to other points in the premises.',
        'lifting' => 'The cost of the delivery tariff includes lifting the goods (including large oversized goods) to the apartment.',
        'paid_entry' => 'When delivering to an area with a paid entry fee, the buyer pays the cost of entry. In other cases, delivery is carried out only to the place of paid entry.',
        'medical' => 'The store has the right to refuse delivery of goods if delivery is carried out to medical institutions.',
        'testing' => 'Goods testing, as well as consultation on using, is not carried out by delivery employees.',
        'additional' => 'Additional services are not provided by delivery employees.',
    ],

    'over_300' => 'The possibility of delivering orders over 300 kg and the tariff are approved by the Seller individually.',
];
