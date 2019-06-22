<?php
/**
 * Fichero para ejecutar e imprimir el sql a ejecutar en producción o test para crear productos.
 */

$config = array(
    'lang'         => 'pt',
    'laninitriginal' => 'es',
    'promoCode'    => '10',
    'serverUrl'    => 'https://www.test.pt/',
    'storeUrl'      => '/pt/store/quote/seguro-',
    'travelUrl'    => 'seguro-de-viagem/',
    'sportsUrl'    => 'seguro-desportivo/',
    'ext'          => '.pdf',
);

$productsToModify = array(
    'Globaltravel'      => array(
        'lang'             => $config['lang'],
        'name'             => 'Multiasistencia Plus',
        'commercialName'   => 'Globaltravel',
        'urlName'          => 'Globaltravel',
        'conditionsFileId' => '136/207339',
        'insuranceNumber'  => 'PTC01-TRY06-01C1',
        'insuranceId'      => '34710',
        'type'             => 'travel',
    ),
    'Globaltravel-mini' => array(
        'lang'             => $config['lang'],
        'name'             => 'Multiasistencia Basic',
        'commercialName'   => 'Globaltravel mini',
        'urlName'          => 'Globaltravel-mini',
        'conditionsFileId' => '4165/207546',
        'insuranceNumber'  => 'PTC02-TRY06-01C1',
        'insuranceId'      => '34711',
        'type'             => 'travel',
    ),
    'cancellation'     => array(
        'lang'             => $config['lang'],
        'name'             => 'Anulación Plus',
        'commercialName'   => 'init | cancellation',
        'urlName'          => 'init-cancellation',
        'conditionsFileId' => '517/207681',
        'insuranceNumber'  => 'PTC05-TRY06-01C1',
        'insuranceId'      => '34714',
        'type'             => 'travel',
    ),
    'schengen'         => array(
        'lang'             => $config['lang'],
        'name'             => 'Schengen',
        'commercialName'   => 'init | schengen',
        'urlName'          => 'init-schengen',
        'conditionsFileId' => '848/215268',
        'insuranceNumber'  => 'PTC06-TRY06-01C1',
        'insuranceId'      => '34715',
        'type'             => 'travel',
    ),
    'Globalsports'      => array(
        'lang'                      => $config['lang'],
        'name'                      => 'Aventura Plus',
        'commercialName'            => 'Globalsports',
        'urlName'                   => 'Globalsports',
        'conditionsFileId'          => '554/230512',
        'insuranceNumber'           => 'PTC09-TRY06-01C1',
        'insuranceRenovationNumber' => 'PTC09-TRY06-C104',
        'insuranceId'               => '34718',
        'type'                      => 'sports',

    ),
    'wintersports'     => array(
        'lang'                      => $config['lang'],
        'name'                      => 'Ski Plus',
        'commercialName'            => 'Wintersports',
        'urlName'                   => 'wintersports',
        'conditionsFileId'          => '18612/341542',
        'insuranceNumber'           => 'PTC08-TRY06-01C1',
        'insuranceRenovationNumber' => 'PTC08-TRY06-C104',
        'insuranceId'               => '34717',
        'type'                      => 'sports',
    ),
);

$productsToCreate = array(
    'businesstravel' => array(
        'lang'             => $config['lang'],
        'name'             => 'Multiasistencia Business',
        'commercialName'   => 'Businesstravel',
        'urlName'          => 'businesstravel',
        'conditionsFileId' => '',
        'insuranceNumber'  => 'PTC04-TRY06-01C1',
        'insuranceId'      => '34713',
        'type'             => 'travel',
    ),
    'study'          => array(
        'lang'             => $config['lang'],
        'name'             => 'Study Plus',
        'commercialName'   => 'init | study',
        'urlName'          => 'init-study',
        'conditionsFileId' => '',
        'insuranceNumber'  => 'PTC07-TRY06-01C1',
        'insuranceId'      => '34716',
        'type'             => 'travel',
    ),
);
