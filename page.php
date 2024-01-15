<?php
function page($type, $message)
{

    // Get page.
    $html = file_get_contents('page.html');

    // Set title and icon.
    $title = 'Success';
    $icon = '✓';
    if ($type === 'error') {
        $title = 'Error';
        $icon = '✗';
    }

    // Replace variables.
    $html = str_replace('{message}', $message, $html);
    $html = str_replace('{title}', $title, $html);
    $html = str_replace('{type}', $type, $html);
    $html = str_replace('{icon}', $icon, $html);
    
    // Output page.
    return $html;
}