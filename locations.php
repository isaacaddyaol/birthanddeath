<?php
// Array of regions and their districts in Ghana
$locations = [
    'Greater Accra' => [
        'Accra Metropolitan' => ['Accra Central', 'East Legon', 'West Legon', 'Adabraka', 'Osu', 'Cantonments'],
        'Tema Metropolitan' => ['Tema Community 1', 'Tema Community 2', 'Tema Community 3', 'Tema Industrial Area'],
        'Ga East Municipal' => ['Madina', 'Adenta', 'Dodowa', 'Abokobi'],
        'Ga West Municipal' => ['Amasaman', 'Pokuase', 'Ofankor', 'Nsawam'],
        'Ga South Municipal' => ['Weija', 'Dansoman', 'Bortianor', 'Ngleshie Amanfro'],
        'Ledzokuku Municipal' => ['Teshie', 'Nungua', 'Sakumono', 'Lashibi'],
        'Krowor Municipal' => ['Nungua', 'Kokomlemle', 'Kaneshie', 'Adabraka']
    ],
    'Ashanti' => [
        'Kumasi Metropolitan' => ['Kumasi Central', 'Asokwa', 'Manhyia', 'Suame'],
        'Obuasi Municipal' => ['Obuasi', 'Tutuka', 'Anyinam', 'Binsere'],
        'Ejisu Municipal' => ['Ejisu', 'Bonwire', 'Fumesua', 'Juaben'],
        'Mampong Municipal' => ['Mampong', 'Asante Mampong', 'Agona', 'Ejura'],
        'Konongo Municipal' => ['Konongo', 'Odumasi', 'Asante Akyem', 'Juaso']
    ],
    'Western' => [
        'Sekondi-Takoradi Metropolitan' => ['Sekondi', 'Takoradi', 'Kwesimintsim', 'Essikado'],
        'Tarkwa-Nsuaem Municipal' => ['Tarkwa', 'Nsuaem', 'Bogoso', 'Prestea'],
        'Wassa Amenfi East Municipal' => ['Wassa Akropong', 'Asankragwa', 'Manso Amenfi', 'Dadieso'],
        'Ellembelle Municipal' => ['Nkroful', 'Axim', 'Esiama', 'Eikwe']
    ],
    'Central' => [
        'Cape Coast Metropolitan' => ['Cape Coast', 'Elmina', 'Kakumdo', 'Abura'],
        'Agona West Municipal' => ['Swedru', 'Nyakrom', 'Bobikuma', 'Kwanyako'],
        'Komenda-Edina-Eguafo-Abirem Municipal' => ['Elmina', 'Komenda', 'Eguafo', 'Abirem'],
        'Mfantseman Municipal' => ['Saltpond', 'Mankessim', 'Anomabo', 'Biriwa']
    ],
    'Eastern' => [
        'Koforidua Municipal' => ['Koforidua', 'Effiduase', 'Asokore', 'Oyoko'],
        'Nsawam Adoagyiri Municipal' => ['Nsawam', 'Adoagyiri', 'Dawhenya', 'Prampram'],
        'Suhum Municipal' => ['Suhum', 'Kade', 'Asamankese', 'Akim Oda'],
        'Akim Oda Municipal' => ['Akim Oda', 'Akim Swedru', 'Akim Achiase', 'Akim Kotoku']
    ],
    'Volta' => [
        'Ho Municipal' => ['Ho', 'Akoefe', 'Klefe', 'Taviefe'],
        'Hohoe Municipal' => ['Hohoe', 'Lolobi', 'Likpe', 'Alavanyo'],
        'Keta Municipal' => ['Keta', 'Anloga', 'Kedzi', 'Vodza'],
        'Ketu South Municipal' => ['Aflao', 'Denu', 'Agbozume', 'Klikor']
    ],
    'Northern' => [
        'Tamale Metropolitan' => ['Tamale Central', 'Lamashegu', 'Sagnarigu', 'Tolon'],
        'Yendi Municipal' => ['Yendi', 'Gushegu', 'Saboba', 'Chereponi'],
        'Savelugu Municipal' => ['Savelugu', 'Nanton', 'Kumbungu', 'Tolon'],
        'Gushegu Municipal' => ['Gushegu', 'Karaga', 'Nanton', 'Kumbungu']
    ],
    'Upper East' => [
        'Bolgatanga Municipal' => ['Bolgatanga', 'Zuarungu', 'Sumbrungu', 'Tindonsobligo'],
        'Bawku Municipal' => ['Bawku', 'Zebilla', 'Garu', 'Tempane'],
        'Navrongo Municipal' => ['Navrongo', 'Paga', 'Chiana', 'Kassena'],
        'Bongo Municipal' => ['Bongo', 'Zuarungu', 'Vea', 'Soe']
    ],
    'Upper West' => [
        'Wa Municipal' => ['Wa', 'Bamahu', 'Kambali', 'Dondoli'],
        'Lawra Municipal' => ['Lawra', 'Nandom', 'Jirapa', 'Lambussie'],
        'Nadowli Municipal' => ['Nadowli', 'Daffiama', 'Issa', 'Tumu'],
        'Jirapa Municipal' => ['Jirapa', 'Lambussie', 'Nandom', 'Lawra']
    ],
    'Bono' => [
        'Sunyani Municipal' => ['Sunyani', 'Fiapre', 'Abesim', 'Nsoatre'],
        'Techiman Municipal' => ['Techiman', 'Tuobodom', 'Kintampo', 'Nkoranza'],
        'Dormaa Municipal' => ['Dormaa Ahenkro', 'Wamfie', 'Nkrankwanta', 'Dormaa Akwamu'],
        'Wenchi Municipal' => ['Wenchi', 'Banda', 'Nchiraa', 'Badu']
    ],
    'Ahafo' => [
        'Goaso Municipal' => ['Goaso', 'Kenyasi', 'Hwidiem', 'Acherensua'],
        'Kenyasi Municipal' => ['Kenyasi', 'Hwidiem', 'Acherensua', 'Goaso'],
        'Bechem Municipal' => ['Bechem', 'Duayaw Nkwanta', 'Hwidiem', 'Kenyasi'],
        'Hwidiem Municipal' => ['Hwidiem', 'Kenyasi', 'Acherensua', 'Goaso']
    ],
    'Bono East' => [
        'Techiman Municipal' => ['Techiman', 'Tuobodom', 'Kintampo', 'Nkoranza'],
        'Kintampo Municipal' => ['Kintampo', 'Jema', 'Nkoranza', 'Pru'],
        'Nkoranza Municipal' => ['Nkoranza', 'Busunya', 'Dromankese', 'Yamfo'],
        'Atebubu Municipal' => ['Atebubu', 'Sene', 'Yeji', 'Prang']
    ],
    'Oti' => [
        'Jasikan Municipal' => ['Jasikan', 'Kadjebi', 'Nkwanta', 'Kpassa'],
        'Kadjebi Municipal' => ['Kadjebi', 'Pampawie', 'Dodo Pepesu', 'Ahamansu'],
        'Nkwanta Municipal' => ['Nkwanta', 'Kpassa', 'Kerri', 'Brewaniase'],
        'Krachi Municipal' => ['Kete Krachi', 'Chinderi', 'Kpassa', 'Nkwanta']
    ],
    'Western North' => [
        'Sefwi Wiawso Municipal' => ['Sefwi Wiawso', 'Asawinso', 'Bodi', 'Juaboso'],
        'Bibiani Anhwiaso Bekwai Municipal' => ['Bibiani', 'Anhwiaso', 'Bekwai', 'Sefwi Bekwai'],
        'Aowin Municipal' => ['Enchi', 'Aowin', 'Suaman', 'Bibiani'],
        'Juaboso Municipal' => ['Juaboso', 'Bodi', 'Asawinso', 'Sefwi Wiawso']
    ],
    'Savannah' => [
        'Damongo Municipal' => ['Damongo', 'Larabanga', 'Bole', 'Sawla'],
        'Bole Municipal' => ['Bole', 'Sawla', 'Tuna', 'Kalba'],
        'Sawla Tuna Kalba Municipal' => ['Sawla', 'Tuna', 'Kalba', 'Bole'],
        'West Gonja Municipal' => ['Damongo', 'Larabanga', 'Bole', 'Sawla']
    ],
    'North East' => [
        'Nalerigu Municipal' => ['Nalerigu', 'Gambaga', 'Walewale', 'Langbensi'],
        'Walewale Municipal' => ['Walewale', 'Gambaga', 'Nalerigu', 'Langbensi'],
        'Bunkpurugu Municipal' => ['Bunkpurugu', 'Nakpanduri', 'Gambaga', 'Walewale'],
        'Yunyoo Municipal' => ['Yunyoo', 'Bunkpurugu', 'Nakpanduri', 'Gambaga']
    ]
];

// Function to get districts for a region
function getDistricts($region) {
    $districts = [
        'Greater Accra Region' => [
            'Accra Metropolitan',
            'Tema Metropolitan',
            'Ga East Municipal',
            'Ga West Municipal',
            'Ga Central Municipal',
            'Ga South Municipal',
            'Adentan Municipal',
            'Ashaiman Municipal',
            'Ledzokuku Municipal',
            'Krowor Municipal',
            'La Dadekotopon Municipal',
            'La Nkwantanang Madina Municipal',
            'Ningo Prampram District',
            'Shai Osudoku District',
            'Ada East District',
            'Ada West District'
        ],
        'Ashanti Region' => [
            'Kumasi Metropolitan',
            'Obuasi Municipal',
            'Ejisu Municipal',
            'Mampong Municipal',
            'Konongo Municipal'
        ],
        'Western Region' => [
            'Sekondi Takoradi Metropolitan',
            'Tarkwa Nsuaem Municipal',
            'Wassa Amenfi East Municipal',
            'Ellembelle Municipal'
        ],
        'Eastern Region' => [
            'Koforidua Municipal',
            'Nsawam Adoagyiri Municipal',
            'Suhum Municipal',
            'Akim Oda Municipal'
        ],
        'Central Region' => [
            'Cape Coast Metropolitan',
            'Agona West Municipal',
            'Komenda Edina Eguafo Abirem Municipal',
            'Mfantseman Municipal'
        ],
        'Northern Region' => [
            'Tamale Metropolitan',
            'Yendi Municipal',
            'Savelugu Municipal',
            'Gushegu Municipal'
        ],
        'Upper East Region' => [
            'Bolgatanga Municipal',
            'Bawku Municipal',
            'Bawku West District',
            'Binduri District',
            'Bongo Municipal'
        ],
        'Upper West Region' => [
            'Wa Municipal',
            'Lawra Municipal',
            'Nadowli Municipal',
            'Jirapa Municipal'
        ],
        'Volta Region' => [
            'Ho Municipal',
            'Hohoe Municipal',
            'Keta Municipal',
            'Ketu South Municipal'
        ],
        'Bono Region' => [
            'Sunyani Municipal',
            'Techiman Municipal',
            'Dormaa Municipal',
            'Wenchi Municipal'
        ],
        'Bono East Region' => [
            'Techiman Municipal',
            'Kintampo Municipal',
            'Nkoranza Municipal',
            'Atebubu Municipal'
        ],
        'Ahafo Region' => [
            'Goaso Municipal',
            'Kenyasi Municipal',
            'Bechem Municipal',
            'Hwidiem Municipal'
        ],
        'Western North Region' => [
            'Sefwi Wiawso Municipal',
            'Bibiani Anhwiaso Bekwai Municipal',
            'Aowin Municipal',
            'Juaboso Municipal'
        ],
        'Oti Region' => [
            'Jasikan Municipal',
            'Kadjebi Municipal',
            'Nkwanta Municipal',
            'Krachi Municipal'
        ],
        'Savannah Region' => [
            'Damongo Municipal',
            'Bole Municipal',
            'Sawla Tuna Kalba Municipal',
            'West Gonja Municipal'
        ],
        'North East Region' => [
            'Nalerigu Municipal',
            'Walewale Municipal',
            'Bunkpurugu Municipal',
            'Yunyoo Municipal'
        ]
    ];

    return $districts[$region] ?? [];
}

// Function to get towns for a district
function getTowns($region, $district) {
    $towns = [
        'Greater Accra Region' => [
            'Accra Metropolitan' => [
                'Accra Central',
                'Adabraka',
                'Cantonments',
                'Dansoman',
                'East Legon',
                'Kaneshie',
                'Kokomlemle',
                'Korle Bu',
                'Labone',
                'Lapaz',
                'Mamprobi',
                'Nima',
                'Osu',
                'Ridge',
                'Roman Ridge',
                'West Legon'
            ],
            'Tema Metropolitan' => [
                'Tema Community 1',
                'Tema Community 2',
                'Tema Community 3',
                'Tema Community 4',
                'Tema Community 5',
                'Tema Community 6',
                'Tema Community 7',
                'Tema Community 8',
                'Tema Community 9',
                'Tema Community 10',
                'Tema Community 11',
                'Tema Community 12',
                'Tema Industrial Area',
                'Tema New Town',
                'Tema Port'
            ],
            'Ga East Municipal' => [
                'Abokobi',
                'Dome',
                'Haasto',
                'Kwabenya',
                'Oyibi',
                'Taifa',
                'Kitase',
                'Pokuase'
            ],
            'Ga West Municipal' => [
                'Amasaman',
                'Dawhenya',
                'Nsawam',
                'Prampram',
                'Ofankor',
                'Ablekuma',
                'Awoshie',
                'Domeabra'
            ],
            'Ga Central Municipal' => [
                'Sowutuom',
                'Anyaa',
                'Awoshie',
                'Bubiashie',
                'Kokrobite',
                'Mallam',
                'Weija',
                'Gbawe'
            ],
            'Ga South Municipal' => [
                'Bortianor',
                'Ngleshie Amanfro',
                'Oblogo',
                'Sakumono',
                'Teshie',
                'Kokrobite',
                'Glefe',
                'Dansoman'
            ]
        ],
        'Ashanti Region' => [
            'Kumasi Metropolitan' => [
                'Adum',
                'Ahodwo',
                'Asokwa',
                'Ayigya',
                'Bantama',
                'Bomso',
                'Danyame',
                'Dichemso',
                'Fante New Town',
                'Kaase',
                'Manhyia',
                'Nhyiaeso',
                'Patasi',
                'Santasi',
                'Suame',
                'Tafo'
            ],
            'Obuasi Municipal' => [
                'Obuasi',
                'Tutuka',
                'Akaporiso',
                'Anyinam',
                'Brahabebome',
                'Hia',
                'Kokoteasua',
                'Wawase'
            ],
            'Ejisu Municipal' => [
                'Ejisu',
                'Bonwire',
                'Fumesua',
                'Juaben'
            ],
            'Mampong Municipal' => [
                'Mampong',
                'Asante Mampong',
                'Agona',
                'Ejura'
            ],
            'Konongo Municipal' => [
                'Konongo',
                'Odumasi',
                'Asante Akyem',
                'Juaso'
            ]
        ],
        'Western Region' => [
            'Sekondi Takoradi Metropolitan' => [
                'Airport Ridge',
                'Beach Road',
                'Effia',
                'Essikado',
                'Kojokrom',
                'Kwesimintsim',
                'New Takoradi',
                'Sekondi',
                'Takoradi',
                'Tanokrom',
                'Windy Ridge'
            ],
            'Tarkwa Nsuaem Municipal' => [
                'Tarkwa',
                'Nsuaem',
                'Bogoso',
                'Prestea'
            ],
            'Wassa Amenfi East Municipal' => [
                'Wassa Akropong',
                'Asankragwa',
                'Manso Amenfi',
                'Dadieso'
            ],
            'Ellembelle Municipal' => [
                'Nkroful',
                'Axim',
                'Esiama',
                'Eikwe'
            ]
        ],
        'Eastern Region' => [
            'Koforidua Municipal' => [
                'Koforidua',
                'Effiduase',
                'Asokore',
                'Oyoko'
            ],
            'Nsawam Adoagyiri Municipal' => [
                'Nsawam',
                'Adoagyiri',
                'Dawhenya',
                'Prampram'
            ],
            'Suhum Municipal' => [
                'Suhum',
                'Kade',
                'Asamankese',
                'Akim Oda'
            ],
            'Akim Oda Municipal' => [
                'Akim Oda',
                'Akim Swedru',
                'Akim Achiase',
                'Akim Kotoku'
            ]
        ],
        'Central Region' => [
            'Cape Coast Metropolitan' => [
                'Cape Coast',
                'Abura',
                'Kakumdo',
                'Pedu',
                'Bakano',
                'Duakro',
                'Ekon',
                'Ola'
            ],
            'Agona West Municipal' => [
                'Swedru',
                'Nyakrom',
                'Bobikuma',
                'Kwanyako'
            ],
            'Komenda Edina Eguafo Abirem Municipal' => [
                'Elmina',
                'Komenda',
                'Eguafo',
                'Abirem'
            ],
            'Mfantseman Municipal' => [
                'Saltpond',
                'Mankessim',
                'Anomabo',
                'Biriwa'
            ]
        ],
        'Northern Region' => [
            'Tamale Metropolitan' => [
                'Tamale Central',
                'Lamashegu',
                'Sagnarigu',
                'Tolon',
                'Kumbungu',
                'Savelugu',
                'Yendi',
                'Gushegu'
            ],
            'Yendi Municipal' => [
                'Yendi',
                'Gushegu',
                'Saboba',
                'Chereponi'
            ],
            'Savelugu Municipal' => [
                'Savelugu',
                'Nanton',
                'Kumbungu',
                'Tolon'
            ],
            'Gushegu Municipal' => [
                'Gushegu',
                'Karaga',
                'Nanton',
                'Kumbungu'
            ]
        ],
        'Upper East Region' => [
            'Bolgatanga Municipal' => [
                'Bolgatanga',
                'Zuarungu',
                'Bongo',
                'Navrongo',
                'Bawku',
                'Zebilla',
                'Sandema',
                'Fumbisi'
            ],
            'Bawku Municipal' => [
                'Bawku',
                'Zebilla',
                'Sandema',
                'Fumbisi'
            ],
            'Bawku West District' => [
                'Zebilla',
                'Sandema',
                'Fumbisi',
                'Navrongo'
            ],
            'Binduri District' => [
                'Binduri',
                'Bawku',
                'Zebilla',
                'Sandema'
            ],
            'Bongo Municipal' => [
                'Bongo',
                'Zuarungu',
                'Bolgatanga',
                'Navrongo'
            ]
        ],
        'Upper West Region' => [
            'Wa Municipal' => [
                'Wa',
                'Bamahu',
                'Kambali',
                'Dondoli'
            ],
            'Lawra Municipal' => [
                'Lawra',
                'Nandom',
                'Jirapa',
                'Lambussie'
            ],
            'Nadowli Municipal' => [
                'Nadowli',
                'Daffiama',
                'Issa',
                'Tumu'
            ],
            'Jirapa Municipal' => [
                'Jirapa',
                'Lambussie',
                'Nandom',
                'Lawra'
            ]
        ],
        'Volta Region' => [
            'Ho Municipal' => [
                'Ho',
                'Akoefe',
                'Klefe',
                'Taviefe'
            ],
            'Hohoe Municipal' => [
                'Hohoe',
                'Lolobi',
                'Likpe',
                'Alavanyo'
            ],
            'Keta Municipal' => [
                'Keta',
                'Anloga',
                'Kedzi',
                'Vodza'
            ],
            'Ketu South Municipal' => [
                'Aflao',
                'Denu',
                'Agbozume',
                'Klikor'
            ]
        ],
        'Bono Region' => [
            'Sunyani Municipal' => [
                'Sunyani',
                'Fiapre',
                'Abesim',
                'Nsoatre'
            ],
            'Techiman Municipal' => [
                'Techiman',
                'Tuobodom',
                'Kintampo',
                'Nkoranza'
            ],
            'Dormaa Municipal' => [
                'Dormaa Ahenkro',
                'Wamfie',
                'Nkrankwanta',
                'Dormaa Akwamu'
            ],
            'Wenchi Municipal' => [
                'Wenchi',
                'Banda',
                'Nchiraa',
                'Badu'
            ]
        ],
        'Bono East Region' => [
            'Techiman Municipal' => [
                'Techiman',
                'Tuobodom',
                'Kintampo',
                'Nkoranza'
            ],
            'Kintampo Municipal' => [
                'Kintampo',
                'Jema',
                'Nkoranza',
                'Pru'
            ],
            'Nkoranza Municipal' => [
                'Nkoranza',
                'Busunya',
                'Dromankese',
                'Yamfo'
            ],
            'Atebubu Municipal' => [
                'Atebubu',
                'Sene',
                'Yeji',
                'Prang'
            ]
        ],
        'Ahafo Region' => [
            'Goaso Municipal' => [
                'Goaso',
                'Kenyasi',
                'Hwidiem',
                'Acherensua'
            ],
            'Kenyasi Municipal' => [
                'Kenyasi',
                'Hwidiem',
                'Acherensua',
                'Goaso'
            ],
            'Bechem Municipal' => [
                'Bechem',
                'Duayaw Nkwanta',
                'Hwidiem',
                'Kenyasi'
            ],
            'Hwidiem Municipal' => [
                'Hwidiem',
                'Kenyasi',
                'Acherensua',
                'Goaso'
            ]
        ],
        'Western North Region' => [
            'Sefwi Wiawso Municipal' => [
                'Sefwi Wiawso',
                'Asawinso',
                'Bodi',
                'Juaboso'
            ],
            'Bibiani Anhwiaso Bekwai Municipal' => [
                'Bibiani',
                'Anhwiaso',
                'Bekwai',
                'Sefwi Bekwai'
            ],
            'Aowin Municipal' => [
                'Enchi',
                'Aowin',
                'Suaman',
                'Bibiani'
            ],
            'Juaboso Municipal' => [
                'Juaboso',
                'Bodi',
                'Asawinso',
                'Sefwi Wiawso'
            ]
        ],
        'Oti Region' => [
            'Jasikan Municipal' => [
                'Jasikan',
                'Kadjebi',
                'Nkwanta',
                'Kpassa'
            ],
            'Kadjebi Municipal' => [
                'Kadjebi',
                'Pampawie',
                'Dodo Pepesu',
                'Ahamansu'
            ],
            'Nkwanta Municipal' => [
                'Nkwanta',
                'Kpassa',
                'Kerri',
                'Brewaniase'
            ],
            'Krachi Municipal' => [
                'Kete Krachi',
                'Chinderi',
                'Kpassa',
                'Nkwanta'
            ]
        ],
        'Savannah Region' => [
            'Damongo Municipal' => [
                'Damongo',
                'Larabanga',
                'Bole',
                'Sawla'
            ],
            'Bole Municipal' => [
                'Bole',
                'Sawla',
                'Tuna',
                'Kalba'
            ],
            'Sawla Tuna Kalba Municipal' => [
                'Sawla',
                'Tuna',
                'Kalba',
                'Bole'
            ],
            'West Gonja Municipal' => [
                'Damongo',
                'Larabanga',
                'Bole',
                'Sawla'
            ]
        ],
        'North East Region' => [
            'Nalerigu Municipal' => [
                'Nalerigu',
                'Gambaga',
                'Walewale',
                'Bunkpurugu'
            ],
            'Walewale Municipal' => [
                'Walewale',
                'Gambaga',
                'Nalerigu',
                'Langbensi'
            ],
            'Bunkpurugu Municipal' => [
                'Bunkpurugu',
                'Nakpanduri',
                'Gambaga',
                'Walewale'
            ],
            'Yunyoo Municipal' => [
                'Yunyoo',
                'Bunkpurugu',
                'Nakpanduri',
                'Gambaga'
            ]
        ]
    ];

    return $towns[$region][$district] ?? [];
}

// Function to get all regions
function getRegions() {
    return [
        'Greater Accra Region',
        'Ashanti Region',
        'Western Region',
        'Eastern Region',
        'Central Region',
        'Northern Region',
        'Upper East Region',
        'Upper West Region',
        'Volta Region',
        'Bono Region',
        'Bono East Region',
        'Ahafo Region',
        'Western North Region',
        'Oti Region',
        'Savannah Region',
        'North East Region'
    ];
}
?> 