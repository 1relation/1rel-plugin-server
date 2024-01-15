<?php
function getAPIURL() {
    return (isset($_GET['env']) && $_GET['env'] !== 'production' ? API_URL_DEV : API_URL);
}

function api(string $publictoken, string $identifier, string $privatetoken, string $endpoint, string $method = 'GET', array $data = [], string $methoduri = ''): object {
    // Build URL.
    $url = getAPIURL() 
        . '?publictoken=' . $publictoken . '&identifier=' . $identifier . '&privatetoken=' . $privatetoken . '&endpoint=' . $endpoint;
    
    // Add method uri if given.
    if (!empty($methoduri)) {
        $url .= '&method=' . $methoduri;
    }

    // Add data to url if http.
    if ($method === 'GET') {
        $url .= '&' . http_build_query($data);
    }
    
    // Build CURL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
    if ($method !== 'GET') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if (sizeof($data) > 0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
        }
    }
    
    // Execute CURL.
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    // Remove tracy debug bar.
    $response = explode('<!-- Tracy Debug Bar -->', $response)[0];

    // Decode response.
    $output = json_decode($response);

    // Check if response is null.
    if ($output === null) {
        die('No response (' . $error . ') from API on ' . $url . ' (method: ' . $method . ')');
    }
    
    // Return response.
    return (object) $output;
}