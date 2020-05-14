<?php

return [
    'card' => [
        'discounts' => 'Kedvezmények',
        'invoices' => 'Számlák',
        'organizations' => 'Vállalkozások',
        'partners' => 'Partnerek',
        'partner_groups' => 'Partnercsoportok',
        'products' => 'Termékek',
        'taxes' => 'Adók',
        'users' => 'Felhasználók',
    ],
    'users' => [
        'name' => 'Név',
        'email' => 'Email',
        'is_admin' => 'Admin?',
        'password' => 'Jelszó',
    ],
    'organizations' => [
        'name' => 'Név',
        'email' => 'Email',
        'country' => 'Ország',
        'city' => 'Város',
        'zip_code' => 'Irányítószám',
        'address' => 'Cím',
        'phone' => 'Telefon',
        'fax' => 'Fax',
        'tax_number' => 'Adószám',
        'bank_account' => 'Bankszámlaszám',
        'bank_number' => 'Bank azonosító',
        'iban' => 'IBAN',
        'swift' => 'SWIFT',
    ],
    'discounts' => [
        'discount' => 'Kedvezmény',
        'starts_at' => 'Kezdeti dátum',
        'ends_at' => 'Lejárati dátum',
    ],
    'invoices' => [
        'id' => 'Azonosító',
        'product_name' => 'Termék neve',
        'quantity' => 'Mennyiség',
        'total' => 'Összeg',
        'partner_group_name' => 'Partnercsoport',
    ],
    'partners' => [
        'id' => 'Azonosító',
        'name' => 'Név',
        'zip_code' => 'Irányítószám',
        'city' => 'Település',
        'address' => 'Cím',
        'partner_group' => 'Partnercsoport',
    ],
    'partner_groups' => [
        'name' => 'Név',
    ],
    'products' => [
        'quantity' => 'Mennyiség',
        'unit' => 'Mértékegység',
        'name' => 'Név',
        'net_price' => 'Nettó érték',
        'tax' => 'Adó',
    ],
    'taxes' => [
        'tax' => 'Adó',
    ],
];
