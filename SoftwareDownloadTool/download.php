<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

include 'config.php';

$bundle_id = $_GET['bundle_id'] ?? null;
$id = $_GET['id'] ?? null;

if($bundle_id) {
    // Handle bundle download
    $offer = array_filter($bestOffers, fn($o) => $o['id'] == $bundle_id);
    $offer = reset($offer);
    if (!$offer) {
        die('Bundle not found');
    }

    // Check if user has purchased this bundle
    $bundle_purchases = $_SESSION['bundle_purchases'] ?? [];
    $hasPurchased = false;
    foreach($bundle_purchases as $purchase) {
        if($purchase['bundle_id'] == $bundle_id) {
            $hasPurchased = true;
            break;
        }
    }

    if(!$hasPurchased) {
        die('You have not purchased this bundle');
    }

    // Create ZIP file for bundle
    $zipFilename = 'bundle_' . str_replace(' ', '_', $offer['name']) . '.zip';

    // Use ZipArchive if available, otherwise create a simple archive
    if(class_exists('ZipArchive')) {
        $zip = new ZipArchive();
        $tempZip = tempnam(sys_get_temp_dir(), 'bundle');
        if ($zip->open($tempZip, ZipArchive::CREATE) === TRUE) {
            foreach($offer['items'] as $itemId) {
                $sw = array_filter($software, fn($s) => $s['id'] == $itemId);
                $sw = reset($sw);
                if($sw) {
                    $filename = str_replace(' ', '_', $sw['name']) . '_setup.exe';
                    $content = str_repeat('This is a dummy setup file for ' . $sw['name'] . '. It simulates the software setup. ', 256);
                    $zip->addFromString($filename, $content);
                }
            }
            $zip->close();

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
            header('Content-Length: ' . filesize($tempZip));
            readfile($tempZip);
            unlink($tempZip);
            exit;
        }
    } else {
        // Fallback: download as text file with all items
        $content = "Bundle: " . $offer['name'] . "\n\n";
        foreach($offer['items'] as $itemId) {
            $sw = array_filter($software, fn($s) => $s['id'] == $itemId);
            $sw = reset($sw);
            if($sw) {
                $content .= "Software: " . $sw['name'] . "\n";
                $content .= "Description: " . $sw['description'] . "\n";
                $content .= str_repeat('This is a dummy file for ' . $sw['name'] . '. It simulates the download of the software. ', 256) . "\n\n";
            }
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit;
    }
} elseif($id) {
    // Handle individual software download
    $sw = array_filter($software, fn($s) => $s['id'] == $id);
    $sw = reset($sw);
    if (!$sw) {
        die('Software not found');
    }

    // Check if user has purchased this software
    $downloads = $_SESSION['downloads'] ?? [];
    if(!in_array($id, $downloads)) {
        die('You have not purchased this software');
    }

    // Add timestamp to download history
    $_SESSION['download_history'] = $_SESSION['download_history'] ?? [];
    $_SESSION['download_history'][] = [
        'id' => $id,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Create ZIP file for individual software
    $zipFilename = str_replace(' ', '_', $sw['name']) . '_setup.zip';

    if(class_exists('ZipArchive')) {
        $zip = new ZipArchive();
        $tempZip = tempnam(sys_get_temp_dir(), 'software');
        if ($zip->open($tempZip, ZipArchive::CREATE) === TRUE) {
            $content = str_repeat('This is a dummy setup file for ' . $sw['name'] . '. It simulates the software setup. ', 512); // approx 10 KB
            $zip->addFromString('setup.exe', $content);
            $zip->close();

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
            header('Content-Length: ' . filesize($tempZip));
            readfile($tempZip);
            unlink($tempZip);
            exit;
        }
    } else {
        // Fallback: download as text file
        $content = str_repeat('This is a dummy setup file for ' . $sw['name'] . '. It simulates the software setup. ', 512);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit;
    }
} else {
    die('Invalid request');
}
?>
