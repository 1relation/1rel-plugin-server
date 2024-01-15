<?php
/**
 * 1Relation Plugin Server
 * This page is used to save a plugin, it is called by the 1relation instance, when user installs a plugin.
 * @author 1Relation
 */

require_once 'config.php';
require_once 'DB.php';
require_once 'API.php';
require_once 'page.php';

// Require fields.
if (empty($_GET['publictoken']) || empty($_GET['identifier']) || empty($_GET['privatetoken'])) {
    // Tell what field is missing.
    if (empty($_GET['publictoken'])) {
        echo page('error', 'No public token provided.');
    } elseif (empty($_GET['identifier'])) {
        echo page('error', 'No identifier provided.');
    } elseif (empty($_GET['privatetoken'])) {
        echo page('error', 'No private token provided.');
    }

    exit;
}

// Make strings safe.
$publictoken = $mysqli->real_escape_string($_GET['publictoken']);
$identifier = $mysqli->real_escape_string($_GET['identifier']);
$privatetoken = $mysqli->real_escape_string($_GET['privatetoken']);

/* ---- CHECK IF PLUGIN EXISTS ---- */
$plugin = $mysqli->query('SELECT * FROM plugins WHERE publictoken = "' . $publictoken . '"')->fetch_assoc();
if (empty($plugin)) {
    echo page('error', 'Plugin not found.');
    exit;
}

/* ---- CHECK IF ALREADY INSTALLED ---- */
$installedplugin = $mysqli->query('SELECT * FROM installedplugins WHERE pluginid = "' . $plugin['id'] . '" AND privatetoken = "' . $privatetoken . '" AND identifier = "' . $identifier . '"')->fetch_assoc();
if (!empty($installedplugin)) {
    echo page('error', 'Plugin already installed.');
    exit;
}

/* ---- CREATE SOLUTION ---- */
$solutionid = 0;
if (!empty($plugin['blueprint'])) {
    $solution = api($publictoken, $identifier, $privatetoken, 'Solution', 'POST', [
        'name' => $plugin['name'],
        'blueprint' => $plugin['blueprint'],
    ]);
    
    // Check if success.
    if (!isset($solution->success)) {
        echo page('error', 'Failed to install solution: ' . $solution->error->message ?? 'Unknown error.');
        exit;
    }
    
    // Get solution id.
    $solutionid = $solution->success->response->data->items[0]->id;
}


// Insert into installed plugins.
$installed = $mysqli->query('INSERT INTO installedplugins (pluginid, identifier, privatetoken, solutionid) VALUES ("' . $plugin['id'] . '", "' . $identifier . '", "' . $privatetoken . '", "' . $solutionid . '")');

// Failed to create record.
if ($installed === false) {
    echo page('error', 'Failed to create installation record.');
    exit;
}

/* ---- IMPORT SOLUTION ---- */
if (!empty($solutionid)) {
    $import = api($publictoken, $identifier, $privatetoken, 'Solution', 'POST', [], 'import&id=' . $solutionid);

    // Check if success.
    if (!isset($import->success)) {
        echo page('error', 'Failed to import solution: ' . $solution->error->message ?? 'Unknown error.');
        exit;
    }
}

// Show a success page.
echo page('success', 'Plugin installed successfully. You can now use it on your site.');