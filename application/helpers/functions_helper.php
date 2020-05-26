<?php

defined('BASEPATH') or exit('No direct script access allowed');

function getSettings()
{
    $settings = [];
    foreach (getRows('ts_settings') as  $value) {
        $settings[$value->setting_key] = $value->setting_value;
    }

    return json_decode(json_encode($settings));
}
function getSetting($key)
{
    $res = getRow('ts_settings', ['setting_key' => $key]);
    if (!empty($res)) {
        return $res->setting_value;
    }

    return '';
}

function updateSetting($key, $value)
{
    return updateRow('ts_settings', ['setting_key' => $key], ['setting_value' => $value]);
}

function getCountryById($id)
{
    if ($country = getRow('ts_countries', ['id' => $id])) {
        return $country->name;
    }

    return null;
}

function loadView($view, $data = [])
{
    $theme = getSetting('theme_' . $view);
    $ci = &get_instance();
    $ci->load->view("{$view}/{$theme}/layouts/layout", $data);
}

function assets($view, $path = '')
{
    $theme = getSetting('theme_' . $view);
    return base_url("assets/{$view}/{$theme}/{$path}");
}
function generateOrderId()
{
    $ci = &get_instance();
    $row = getLastRow('ts_payment_details');
    if (empty($row)) {
        return 'SR' . date('Ymd') . '0001';
    }
    $p1 = substr($row->orderid, 0, 10);
    $p2 = substr($row->orderid, 10);
    if ($p1 == 'SR' . date('Ymd')) {
        return $p1 . sprintf('%04s', ++$p2);
    } else {
        return 'SR' . date('Ymd') . '0001';
    }
}
// these are under beta testing
function addToCart($type = null, $id = 0, $coupon_id = 0)
{
    if (null == $type || 0 == $id) {
        return;
    }
    $data = [
        'client_id' => $_SESSION['client_id'],
        'product_type' => $type,
        'product_id' => $id,
        'coupon_id' => $coupon_id,
    ];
    if ($row = getRow('ts_cart', ['product_id' => $id])) {
        $data['quantity'] = ($row->quantity + 1);
        updateRow('ts_cart', ['product_id' => $id], $data);
    } else {
        $data['quantity'] = 1;
        insertRow('ts_cart', $data);
    }
}
function getFileIdFromUrl($url)
{
    preg_match('/[-\w]{25,}/', $url, $output);

    return $output[0];
}

function downloadFromDrive($file_id, $filename)
{
    $ch = curl_init('https://drive.google.com/uc?id=' . $file_id . '&export=download');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, []);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-drive-first-party: DriveWebUi',
        'x-json-requested: true',
    ]);
    $result = curl_exec($ch);

    $object = json_decode(str_replace(')]}\'', '', $result));
    // pr($object);

    if (!isset($object->error)) {
        header('Content-Type: application/zip');
        header('Content-Transfer-Encoding: Binary');
        header("Content-disposition: attachment; filename = {$filename}");
        header("Content-length: {$object->sizeBytes}");
        readfile($object->downloadUrl);
        exit;
    }
    echo "<p style='color:red; text-align:center'>Unable to Download File! Seems Link is Broken, Contact Support</p>";
}
