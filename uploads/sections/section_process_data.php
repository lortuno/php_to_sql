<?php

    $sql = '';

    $i = 1;
    if ($productsToModify) {
        $sql .= '/* ---- Update existing products ----- */';
        foreach ($productsToModify as $key => $product) {
            $conditionsUrl = ($product['urlConditions']) ? $product['urlConditions'] : '';
            $sql           .= '<br>/** ----- START PRODUCT ' . $i++ . ' ----  */<br>';
            $sql           .= getVariables($product, $config, 'update');
            $sql           .= '<br>/** ----- MODIFYING ----  */<br>';
            $sql           .= insertInsurance($env);
            $sql           .= 'SET @newPolizaId = LAST_INSERT_ID();<br>';
            $sql           .= 'UPDATE `my_certificados` SET certificado = @certificadoPDF, seg_name = @insuranceCommercialName, certificado_promo = @certificadoPDF, certificado_renovacion = @certificadoRenovPDF
WHERE id= @certificadoId;<br>';
            $sql           .= '
UPDATE my_config_insurances 
SET seg_name_traducc = @insuranceCommercialName,
    id_certificado = @certificadoId,
    id_poliza = @newPolizaId,
    seg_promo = @promoPercentage,
    seg_url_contratar=@seg_url,
    seg_url_producto=@seg_url_product,
    seg_url_cond = @seg_url_cond,
    seg_url_cond_renovacion = @seg_url_cond_renov
WHERE  seg_id=@productId;<br>';
            $sql           .= '<br>/** ----- END PRODUCT ----  */<br>';
        }
    }

    $i = 1;
    if ($productsToCreate) {
        $sql .= '/* ---- Insert new products ----- */';
        foreach ($productsToCreate as $key => $product) {

            $sql .= '<br>/** ----- START PRODUCT ' . $i++ . ' ----  */<br>';
            $sql .= getVariables($product, $config, 'insert');
            $sql .= '<br>/** ----- MODIFYING ----  */<br>';
            $sql .= insertInsurance($env);
            $sql .= 'SET @newPolizaId = LAST_INSERT_ID();<br>';
            $sql .= 'INSERT INTO my_certificados (certificado, certificado_white_label, certificado_renovacion, certificado_promo, certificado_anual, certificado_sin_anulacion, certificado_cruceros, certificado_estancia, seg_name, seg_lang, removed)
SELECT @certificadoPDF, certificado_white_label, @certificadoRenovPDF, @certificadoPDF, certificado_anual, certificado_sin_anulacion, certificado_cruceros, certificado_estancia, @insuranceCommercialName, @langCode, removed
FROM my_certificados
WHERE id=@certificadoId;<br>';
            $sql .= '
INSERT INTO my_config_insurances (seg_lang, seg_name, seg_name_traducc, seg_database, seg_pasarela, seg_img_icon_big, seg_img_icon_mobile, seg_img_banner, seg_img_encuesta, seg_img_background, seg_url_contratar, seg_url_producto, seg_url_cond, seg_url_cond_renovacion, seg_url_cond_promo, seg_firma, seg_tipo, seg_subtipo, seg_duracion, seg_duracion_min, seg_google_conversion_label, seg_promo, id_certificado, id_poliza)
SELECT @langCode, @insuranceName, @insuranceCommercialName, seg_database, seg_pasarela, seg_img_icon_big, seg_img_icon_mobile, seg_img_banner, seg_img_encuesta, seg_img_background, @seg_url, @seg_url_product, @seg_url_cond, @seg_url_cond_renov, seg_url_cond_promo, seg_firma, seg_tipo, seg_subtipo, seg_duracion, seg_duracion_min, seg_google_conversion_label, @promoPercentage, @newCertificadoId, @newPolizaId
FROM  my_config_insurances
WHERE seg_id=@productId;<br>';
            $sql .= '<br>/** ----- END PRODUCT ----  */<br>';
        }
    }

    function insertInsurance($env)
    {
        if ($env == 'prod') {
            return $sql = 'INSERT INTO `my_polizas` (`numero_poliza`, `numero_poliza_promo`, `seg_name`, `seg_lang`, `removed`)
SELECT @polizaNumber, @polizaNumber, @insuranceCommercialName, @langCode, removed
FROM my_polizas WHERE id = @oldPolizaId;<br>';
        } else {
            return $sql = 'INSERT INTO `my_polizas` (`numero_poliza`, `numero_poliza_promo`, `seg_name`, `seg_lang`, `removed`, `id_poliza`, `id_poliza_promo`)
SELECT @polizaNumber, @polizaNumber, @insuranceCommercialName, @langCode, removed, @polizaId, @polizaId
FROM my_polizas WHERE id = @oldPolizaId;<br>';
        }

    }

    function getVariables($product, $config, $operationType)
    {
        $conditionsUrl       = ($product['urlConditions']) ? $product['urlConditions'] : '-';
        $insuranceRenovation =
            (isset($product['insuranceRenovationNumber']))
                ? strtoupper('CERTIF_' . $config['lang'] . '_WEB_' . $product['commercialName'] . '_' . $product['insuranceRenovationNumber']) . $config['ext']
                : 'certificado_renovacion';
        $sql                 = '';
        $sql                 .= 'SET @promoPercentage ="' . $config['promoCode'] . '";<br>';
        $sql                 .= 'SET @langCode ="' . $config['lang'] . '";<br>';
        $sql                 .= 'SET @langCodeOriginal ="' . $config['langOriginal'] . '";<br>';
        $sql                 .= 'SET @ezServerUrl ="' . $config['serverUrl'] . '";<br>';
        $sql                 .= 'SET @insuranceName ="' . $product['name'] . '";<br>';
        $sql                 .= 'SET @insuranceCommercialName ="' . $product['commercialName'] . '";<br>';
        $sql                 .= 'SET @insuranceUrlName ="' . $product['urlName'] . '";<br>';
        $sql                 .= 'SET @condicionadoId ="' . $product['conditionsFileId'] . '";<br>';
        $sql                 .= 'SET @polizaNumber ="' . $product['insuranceNumber'] . '";<br>';
        $sql                 .= 'SET @polizaNumberRenov ="' . $product['insuranceRenovationNumber'] . '";<br>';
        $sql                 .= 'SET @polizaId ="' . $product['insuranceId'] . '";<br>';
        $sql                 .= getMainVarsByOperationType($operationType);
        $sql                 .= 'SET @seg_url =(SELECT CONCAT("' . $config['shopUrl'] . '",@insuranceUrlName));<br>';
        $sql                 .= 'SET @seg_url_product =(SELECT CONCAT(@ezServerUrl,"' . getUrlType($product['type'],
                $config) . '",@insuranceUrlName));<br>';
        $sql                 .= 'SET @seg_url_cond ="' . $config['serverUrl'] . 'content/download/' . $product['conditionsFileId'] . 'file/COND_' . $product['urlName'] . '_' . $product['insuranceNumber'] . $config['ext'] . '";<br>';
        $sql                 .= 'SET @seg_url_cond_renov ="' . $conditionsUrl . '";<br>';
        $sql                 .= 'SET @certificadoPDF = (SELECT CONCAT(UPPER(CONCAT(\'CERTIF_\' , @langCode, \'_WEB_\', @insuranceCommercialName , \'_\' , @polizaNumber)), "' . $config['ext'] . '"));<br>';
        $sql                 .= 'SET @certificadoRenovPDF = "' . $insuranceRenovation . '";<br>';

        return $sql;
    }

    function getMainVarsByOperationType($type)
    {
        $sql = '';
        if ($type == 'insert') {
            $sql .= 'SET @productId = (SELECT seg_id FROM my_config_insurances WHERE seg_name = @insuranceName COLLATE utf8_unicode_ci AND seg_lang=@langCodeOriginal COLLATE utf8_general_ci);<br>';
            $sql .= 'SET @certificadoId = (SELECT id_certificado FROM my_config_insurances WHERE seg_name = @insuranceName COLLATE utf8_unicode_ci AND seg_lang=@langCodeOriginal COLLATE utf8_general_ci);<br>';
        } else {
            $sql .= 'SET @productId = (SELECT seg_id FROM my_config_insurances WHERE seg_name = @insuranceName COLLATE utf8_unicode_ci AND seg_lang=@langCode COLLATE utf8_general_ci);<br>';
            $sql .= 'SET @certificadoId = (SELECT id_certificado FROM my_config_insurances WHERE seg_name = @insuranceName COLLATE utf8_unicode_ci AND seg_lang=@langCode COLLATE utf8_general_ci); <br>';
        }

        $sql .= 'SET @oldPolizaId = (SELECT id_poliza FROM my_config_insurances WHERE seg_name = @insuranceName COLLATE utf8_unicode_ci AND seg_lang=@langCodeOriginal COLLATE utf8_general_ci);<br>';

        return $sql;
    }

    function getUrlType($type, $config)
    {
        switch ($type) {
            case 'sports':
                $urlType = $config['sportsUrl'];
                break;
            case 'travel':
            default:
                $urlType = $config['travelUrl'];
                break;
        }

        return $urlType;
    }
