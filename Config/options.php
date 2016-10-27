<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */


return [
    'name' => 'Inventory',
    'payment_modes' => [
        'cash' => 'Cash',
        'bank' => 'Bank Deposit',
        'credit' => 'Credit',
        'mpesa' => 'MPESA',
        'airtel' => 'Airtel Money',
        'insurance' => 'Insurance',
        'card' => 'Credit Card', 'cheque' => 'Cheque',
    ],
        'rcv_modes' => [
        '1' => 'Cash',
        '2' => 'Bank Deposit',
        '3' => 'Credit',
        '4' => 'MPESA',
        '5' => 'Airtel Money',
        '6' => 'Insurance',
        '7' => 'Credit Card', 'cheque' => 'Cheque',
    ],
    'label_type' => [
        1 => 'External',
        2 => 'Oral',
        3 => 'Injection'
    ],
    'formulation' => [
        1 => 'Antifungal Spray',
        2 => 'Antiseptic',
        3 => 'Capsules',
        4 => 'Creams',
        5 => 'Dressing',
        6 => 'Ear Drops',
        7 => 'Eye Drop',
        8 => 'Gel',
        9 => 'Infusion',
        10 => 'Inhaller Spray',
        11 => 'Injection',
        12 => 'Intravenous',
        13 => 'Kits',
        14 => 'Lotion',
        15 => 'Lozenges',
        16 => 'Milk',
        17 => 'Mouth wash',
        18 => 'Nasal Drops',
        19 => 'Nasal Sprays',
        20 => 'Nebulizer',
        21 => 'Non Drug',
        22 => 'Ointments',
        23 => 'Oral Drops',
        24 => 'Patch',
        25 => 'Pessaries',
        26 => 'Powder',
        27 => 'Satchet',
        28 => 'Shampoo',
        29 => 'Soap',
        30 => 'Solutions',
        31 => 'Spray',
        32 => 'Suppository',
        33 => 'Suspension',
        34 => 'Syrup',
        35 => 'Tablet',
        36 => 'Test Strip',
        37 => 'Throat Garles',
        38 => 'Vaccine',
    ],
    'lpo_status' => [
        0 => 'Pending Approval',
        1 => 'Approved | Sent',
        2 => 'Rejected',
        3 => 'Complete',
        4 => 'Abandoned',
    ],
];
