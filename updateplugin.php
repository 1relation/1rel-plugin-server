<?php
/**
 * 1Relation Plugin Server
 * This page is used to save a plugin, it is called by the 1relation instance, when user installs a plugin.
 * @author 1Relation
 */
// Load config.
require_once 'config.php';
require_once 'DB.php';
require_once 'API.php';
require_once 'page.php';

// Require fields.
if (empty($_GET['publictoken']) || empty($_GET['identifier'])) {
    // Tell what field is missing.
    if (empty($_GET['publictoken'])) {
        echo page('error', 'No public token provided.');
    } elseif (empty($_GET['identifier'])) {
        echo page('error', 'No identifier provided.');
    }

    exit;
}

// Make strings safe.
$publictoken = $mysqli->real_escape_string($_GET['publictoken']);
$identifier = $mysqli->real_escape_string($_GET['identifier']);

/* ---- CHECK IF PLUGIN EXISTS ---- */
$plugin = $mysqli->query('SELECT * FROM plugins WHERE publictoken = "' . $publictoken . '"')->fetch_assoc();
if (empty($plugin)) {
    echo page('error', 'Plugin not found.');
    exit;
}

/* ---- CHECK IF NOT INSTALLED ---- */
$installedplugin = $mysqli->query('SELECT * FROM installedplugins WHERE pluginid = "' . $plugin['id'] . '" AND identifier = "' . $identifier . '"')->fetch_assoc();
if (empty($installedplugin)) {
    echo page('error', 'Plugin not installed.');
    exit;
}

/* ---- IMPORT SOLUTION ---- */
$import = api($publictoken, $identifier, $installedplugin['privatetoken'], 'Solution', 'POST', [], 'import&id=' . $installedplugin['solutionid']);

// Check if success.
if (!isset($import->success)) {
    echo page('error', 'Failed to import solution: ' . $import->error->message);
    exit;
}

// Show a success page.
echo page('success', $import->success->message);