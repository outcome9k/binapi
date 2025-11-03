<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('X-Developed-By: @Outcome9k');
header('X-Channel: @Outcome9k');

/**
 * BIN Checker API - Fixed Version
 */
define('DEVELOPER', '@Outcome9k');
define('CHANNEL', '@Outcome9k');
define('SOURCE_URL', 'https://bincheck.io/details/');
define('REQUEST_TIMEOUT', 15);
define('CACHE_EXPIRY', 3600);

$countryFlags = [
    'AD' => '🇦🇩', 'AE' => '🇦🇪', 'AF' => '🇦🇫', 'AG' => '🇦🇬', 'AI' => '🇦🇮',
    'AL' => '🇦🇱', 'AM' => '🇦🇲', 'AO' => '🇦🇴', 'AQ' => '🇦🇶', 'AR' => '🇦🇷',
    'AS' => '🇦🇸', 'AT' => '🇦🇹', 'AU' => '🇦🇺', 'AW' => '🇦🇼', 'AX' => '🇦🇽',
    'AZ' => '🇦🇿', 'BA' => '🇧🇦', 'BB' => '🇧🇧', 'BD' => '🇧🇩', 'BE' => '🇧🇪',
    'BF' => '🇧🇫', 'BG' => '🇧🇬', 'BH' => '🇧🇭', 'BI' => '🇧🇮', 'BJ' => '🇧🇯',
    'BL' => '🇧🇱', 'BM' => '🇧🇲', 'BN' => '🇧🇳', 'BO' => '🇧🇴', 'BQ' => '🇧🇶',
    'BR' => '🇧🇷', 'BS' => '🇧🇸', 'BT' => '🇧🇹', 'BV' => '🇧🇻', 'BW' => '🇧🇼',
    'BY' => '🇧🇾', 'BZ' => '🇧🇿', 'CA' => '🇨🇦', 'CC' => '🇨🇨', 'CD' => '🇨🇩',
    'CF' => '🇨🇫', 'CG' => '🇨🇬', 'CH' => '🇨🇭', 'CI' => '🇨🇮', 'CK' => '🇨🇰',
    'CL' => '🇨🇱', 'CM' => '🇨🇲', 'CN' => '🇨🇳', 'CO' => '🇨🇴', 'CR' => '🇨🇷',
    'CU' => '🇨🇺', 'CV' => '🇨🇻', 'CW' => '🇨🇼', 'CX' => '🇨🇽', 'CY' => '🇨🇾',
    'CZ' => '🇨🇿', 'DE' => '🇩🇪', 'DJ' => '🇩🇯', 'DK' => '🇩🇰', 'DM' => '🇩🇲',
    'DO' => '🇩🇴', 'DZ' => '🇩🇿', 'EC' => '🇪🇨', 'EE' => '🇪🇪', 'EG' => '🇪🇬',
    'EH' => '🇪🇭', 'ER' => '🇪🇷', 'ES' => '🇪🇸', 'ET' => '🇪🇹', 'FI' => '🇫🇮',
    'FJ' => '🇫🇯', 'FK' => '🇫🇰', 'FM' => '🇫🇲', 'FO' => '🇫🇴', 'FR' => '🇫🇷',
    'GA' => '🇬🇦', 'GB' => '🇬🇧', 'GD' => '🇬🇩', 'GE' => '🇬🇪', 'GF' => '🇬🇫',
    'GG' => '🇬🇬', 'GH' => '🇬🇭', 'GI' => '🇬🇮', 'GL' => '🇬🇱', 'GM' => '🇬🇲',
    'GN' => '🇬🇳', 'GP' => '🇬🇵', 'GQ' => '🇬🇶', 'GR' => '🇬🇷', 'GS' => '🇬🇸',
    'GT' => '🇬🇹', 'GU' => '🇬🇺', 'GW' => '🇬🇼', 'GY' => '🇬🇾', 'HK' => '🇭🇰',
    'HM' => '🇭🇲', 'HN' => '🇭🇳', 'HR' => '🇭🇷', 'HT' => '🇭🇹', 'HU' => '🇭🇺',
    'ID' => '🇮🇩', 'IE' => '🇮🇪', 'IL' => '🇮🇱', 'IM' => '🇮🇲', 'IN' => '🇮🇳',
    'IO' => '🇮🇴', 'IQ' => '🇮🇶', 'IR' => '🇮🇷', 'IS' => '🇮🇸', 'IT' => '🇮🇹',
    'JE' => '🇯🇪', 'JM' => '🇯🇲', 'JO' => '🇯🇴', 'JP' => '🇯🇵', 'KE' => '🇰🇪',
    'KG' => '🇰🇬', 'KH' => '🇰🇭', 'KI' => '🇰🇮', 'KM' => '🇰🇲', 'KN' => '🇰🇳',
    'KP' => '🇰🇵', 'KR' => '🇰🇷', 'KW' => '🇰🇼', 'KY' => '🇰🇾', 'KZ' => '🇰🇿',
    'LA' => '🇱🇦', 'LB' => '🇱🇧', 'LC' => '🇱🇨', 'LI' => '🇱🇮', 'LK' => '🇱🇰',
    'LR' => '🇱🇷', 'LS' => '🇱🇸', 'LT' => '🇱🇹', 'LU' => '🇱🇺', 'LV' => '🇱🇻',
    'LY' => '🇱🇾', 'MA' => '🇲🇦', 'MC' => '🇲🇨', 'MD' => '🇲🇩', 'ME' => '🇲🇪',
    'MF' => '🇲🇫', 'MG' => '🇲🇬', 'MH' => '🇲🇭', 'MK' => '🇲🇰', 'ML' => '🇲🇱',
    'MM' => '🇲🇲', 'MN' => '🇲🇳', 'MO' => '🇲🇴', 'MP' => '🇲🇵', 'MQ' => '🇲🇶',
    'MR' => '🇲🇷', 'MS' => '🇲🇸', 'MT' => '🇲🇹', 'MU' => '🇲🇺', 'MV' => '🇲🇻',
    'MW' => '🇲🇼', 'MX' => '🇲🇽', 'MY' => '🇲🇾', 'MZ' => '🇲🇿', 'NA' => '🇳🇦',
    'NC' => '🇳🇨', 'NE' => '🇳🇪', 'NF' => '🇳🇫', 'NG' => '🇳🇬', 'NI' => '🇳🇮',
    'NL' => '🇳🇱', 'NO' => '🇳🇴', 'NP' => '🇳🇵', 'NR' => '🇳🇷', 'NU' => '🇳🇺',
    'NZ' => '🇳🇿', 'OM' => '🇴🇲', 'PA' => '🇵🇦', 'PE' => '🇵🇪', 'PF' => '🇵🇫',
    'PG' => '🇵🇬', 'PH' => '🇵🇭', 'PK' => '🇵🇰', 'PL' => '🇵🇱', 'PM' => '🇵🇲',
    'PN' => '🇵🇳', 'PR' => '🇵🇷', 'PS' => '🇵🇸', 'PT' => '🇵🇹', 'PW' => '🇵🇼',
    'PY' => '🇵🇾', 'QA' => '🇶🇦', 'RE' => '🇷🇪', 'RO' => '🇷🇴', 'RS' => '🇷🇸',
    'RU' => '🇷🇺', 'RW' => '🇷🇼', 'SA' => '🇸🇦', 'SB' => '🇸🇧', 'SC' => '🇸🇨',
    'SD' => '🇸🇩', 'SE' => '🇸🇪', 'SG' => '🇸🇬', 'SH' => '🇸🇭', 'SI' => '🇸🇮',
    'SJ' => '🇸🇯', 'SK' => '🇸🇰', 'SL' => '🇸🇱', 'SM' => '🇸🇲', 'SN' => '🇸🇳',
    'SO' => '🇸🇴', 'SR' => '🇸🇷', 'SS' => '🇸🇸', 'ST' => '🇸🇹', 'SV' => '🇸🇻',
    'SX' => '🇸🇽', 'SY' => '🇸🇾', 'SZ' => '🇸🇿', 'TC' => '🇹🇨', 'TD' => '🇹🇩',
    'TF' => '🇹🇫', 'TG' => '🇹🇬', 'TH' => '🇹🇭', 'TJ' => '🇹🇯', 'TK' => '🇹🇰',
    'TL' => '🇹🇱', 'TM' => '🇹🇲', 'TN' => '🇹🇳', 'TO' => '🇹🇴', 'TR' => '🇹🇷',
    'TT' => '🇹🇹', 'TV' => '🇹🇻', 'TW' => '🇹🇼', 'TZ' => '🇹🇿', 'UA' => '🇺🇦',
    'UG' => '🇺🇬', 'UM' => '🇺🇲', 'US' => '🇺🇸', 'UY' => '🇺🇾', 'UZ' => '🇺🇿',
    'VA' => '🇻🇦', 'VC' => '🇻🇨', 'VE' => '🇻🇪', 'VG' => '🇻🇬', 'VI' => '🇻🇮',
    'VN' => '🇻🇳', 'VU' => '🇻🇺', 'WF' => '🇼🇫', 'WS' => '🇼🇸', 'XK' => '🇽🇰',
    'YE' => '🇾🇪', 'YT' => '🇾🇹', 'ZA' => '🇿🇦', 'ZM' => '🇿🇲', 'ZW' => '🇿🇼'
];

function buildResponse($success, $data = null, $error = null) {
    $response = [
        'status' => $success ? 'success' : 'error',
        'timestamp' => date('c'),
        'api' => [
            'version' => '1.1',
            'developer' => constant('DEVELOPER'),
            'channel' => constant('CHANNEL')
        ],
        'data' => $data,
        'error' => $error
    ];
    
    return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function extractTableData($xpath, $tableIndex) {
    $data = [];
    // More specific table selection
    $table = $xpath->query("(//table[contains(@class, 'table')])[$tableIndex]//tr");
    
    if ($table->length === 0) {
        return $data;
    }
    
    foreach ($table as $row) {
        $cells = $row->getElementsByTagName('td');
        if ($cells->length >= 2) {
            $key = trim($cells->item(0)->nodeValue);
            $value = trim($cells->item(1)->nodeValue);
            if (!empty($key) && $value !== '------') {
                $data[$key] = $value;
            }
        }
    }
    
    return $data;
}

// ======================== MAIN LOGIC ========================
try {
    // Validate BIN input
    if (!isset($_GET['bin']) || empty($_GET['bin'])) {
        throw new Exception('BIN parameter is required');
    }
    
    $bin = preg_replace('/[^0-9]/', '', $_GET['bin']);
    
    if (strlen($bin) < 6) {
        throw new Exception('Invalid BIN format. Must be at least 6 digits.');
    }
    
    $bin = substr($bin, 0, 6); // Take first 6 digits only

    // Improved HTTP request options
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => implode("\r\n", [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.9',
                'Cache-Control: no-cache'
            ]),
            'timeout' => REQUEST_TIMEOUT,
            'ignore_errors' => true
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ]
    ];

    $context = stream_context_create($options);
    $url = SOURCE_URL . $bin;
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        throw new Exception('Failed to fetch BIN information from source. Please try again.');
    }

    // Check if BIN is valid in response
    if (strpos($response, 'Invalid BIN') !== false || strpos($response, 'not found') !== false) {
        throw new Exception('Invalid or unrecognized BIN number');
    }

    // Parse HTML with error handling
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);

    // Extract data from tables with better error handling
    $cardDetails = extractTableData($xpath, 1);
    $countryDetails = extractTableData($xpath, 2);

    // Check if we got valid data
    if (empty($cardDetails) && empty($countryDetails)) {
        throw new Exception('No BIN information found. The BIN may be invalid or not in database.');
    }

    // Get country code and flag
    $countryCode = $countryDetails['ISO Country Code A2'] ?? $countryDetails['Country Code'] ?? '';
    $countryFlag = isset($countryFlags[strtoupper($countryCode)]) ? $countryFlags[strtoupper($countryCode)] : '🏳';

    // Prepare response data
    $responseData = [
        'bin' => $bin,
        'card' => [
            'type' => $cardDetails['Card Type'] ?? $cardDetails['Type'] ?? null,
            'brand' => $cardDetails['Card Brand'] ?? $cardDetails['Brand'] ?? null,
            'level' => $cardDetails['Card Level'] ?? $cardDetails['Level'] ?? null,
            'issuer' => $cardDetails['Issuer Name / Bank'] ?? $cardDetails['Bank'] ?? null,
            'phone' => $cardDetails['Issuer / Bank Phone'] ?? $cardDetails['Phone'] ?? null,
            'website' => $cardDetails['Issuer / Bank Website'] ?? $cardDetails['Website'] ?? null
        ],
        'country' => [
            'name' => $countryDetails['ISO Country Name'] ?? $countryDetails['Country'] ?? null,
            'code' => $countryCode,
            'flag' => $countryFlag,
            'currency' => $countryDetails['ISO Country Currency'] ?? $countryDetails['Currency'] ?? null,
            'currency_code' => $countryDetails['ISO Country Code A3'] ?? $countryDetails['Currency Code'] ?? null
        ],
        'source' => $url
    ];

    // Clean up null values
    $responseData['card'] = array_filter($responseData['card']);
    $responseData['country'] = array_filter($responseData['country']);

    echo buildResponse(true, $responseData);

} catch (Exception $e) {
    http_response_code(400);
    echo buildResponse(false, null, $e->getMessage());
}