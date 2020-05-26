<?php

defined('BASEPATH') or exit('No direct script access allowed');

// common helper functions
function pr($array, $exit = true)
{
    echo '<pre><br><br><br>';
    print_r($array);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}
function show_alert()
{
    if ($msg = isset_flash('success')) {
        custom_alert($msg, 'success', 'check-circle');
    }
    if ($msg = isset_flash('error')) {
        custom_alert($msg, 'danger', 'times-circle');
    }
    if ($msg = isset_flash('warning')) {
        custom_alert($msg, 'warning', 'exclamation-triangle');
    }
    if ('' !== validation_errors()) {
        return "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" . validation_errors() . '</div>';
    }
}
function custom_alert($message, $type, $fa_cls)
{
    return <<<DM

    <p class="alert alert-{$type} alert-dismissible">

    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

    <strong ><i class="fa fa-{$fa_cls}"></i></strong> {$message}

    </p>

DM;
}
function show_dialog()
{
    $ci = &get_instance();
    if ($msg = isset_flash('success')) {
        $ci->load->view('jquery_confirm/alert', ['type' => 'success', 'msg' => $msg]);
    }
    if ($msg = isset_flash('error')) {
        $ci->load->view('jquery_confirm/alert', ['type' => 'error', 'msg' => $msg]);
    }
    if ($msg = isset_flash('warning')) {
        $ci->load->view('jquery_confirm/alert', ['type' => 'warning', 'msg' => $msg]);
    }
}
function success_flash($message)
{
    $ci = &get_instance();
    $ci->session->set_flashdata('success', $message);
}

function error_flash($message)
{
    $ci = &get_instance();
    $ci->session->set_flashdata('error', $message);
}
function warning_flash($message)
{
    $ci = &get_instance();
    $ci->session->set_flashdata('warning', $message);
}
function isset_flash($key)
{
    $ci = &get_instance();
    if (isset($_SESSION[$key])) {
        return $ci->session->flashdata($key);
    }

    return null;
}

function set_flash($key, $val)
{
    $ci = &get_instance();
    $ci->session->set_flashdata($key, $val);
}
function set_userdata($key, $val)
{
    $ci = &get_instance();
    $ci->session->set_userdata($key, $val);
}
function response($flag, $data = '')
{
    $obj = new stdClass();
    if ($flag) {
        $obj->success = true;
        $obj->data = $data;
    } else {
        $obj->success = false;
        $obj->data = $data;
    }

    return $obj;
}

function response_json($flag, $data = '')
{
    if ($flag) {
        return json_encode(['success' => true, 'data' => $data]);
    } else {
        return json_encode(['success' => false, 'data' => $data]);
    }
}
function myCrypt($string, $decrypt = false)
{
    $secret_key = 'aarkay@1618';
    $secret_iv = '1618#Rahul';

    $output = false;
    $encrypt_method = 'AES-256-CBC';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($decrypt) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    } else {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }

    return $output;
}

function uuid($length = 6)
{
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($length / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    } else {
        throw new Exception('no cryptographically secure random function available');
    }

    return substr(bin2hex($bytes), 0, $length);
}

function num_uuid($len = 6, $table = '', $key = '', $val = '')
{
    $uuid = substr(str_shuffle('01234123456789123489'), 0, $len);
    $res = getRow($table, [$key => $val]);
    if (empty($res)) {
        return $uuid;
    }
    num_uuid();
}

function valid_email($email)
{
    $find1 = strpos($email, '@');
    $find2 = strpos($email, '.');

    return false !== $find1 && false !== $find2 && $find2 > $find1;
}

function clean_url($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
    $string = preg_replace('/-+/', '-', $string);

    return $result = strtolower($string);
}
function format_date($datetime)
{
    return date('F j, Y', strtotime($datetime));
}
function make_slug($string)
{
    $lower_case_string = strtolower($string);
    $string1 = preg_replace('/[^a-zA-Z0-9 ]/s', '', $lower_case_string);

    return strtolower(preg_replace('/\s+/', '-', $string1));
}
function encode($input)
{
    return urlencode(base64_encode($input));
}
function decode($input)
{
    return base64_decode(urldecode($input));
}
function text_limit($x, $length)
{
    if (strlen($x) <= $length) {
        echo $x;
    } else {
        $y = substr($x, 0, $length) . '...';
        echo $y;
    }
}

function day_before($date)
{
    return (time() - strtotime($date)) / (24 * 60 * 60);
}

function time_ago($date)
{
    if (empty($date)) {
        return 'No date provided';
    }
    $periods = ['second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade'];
    $lengths = ['60', '60', '24', '7', '4.35', '12', '10'];
    $now = time();
    $unix_date = strtotime($date);
    // check validity of date
    if (empty($unix_date)) {
        return '';
    }
    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = 'ago';
    } else {
        $difference = $unix_date - $now;
        $tense = 'from now';
    }
    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; ++$j) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if (1 != $difference) {
        $periods[$j] .= 's';
    }

    return "{$difference} {$periods[$j]} {$tense}";
}
function month_to_year($month)
{
    if (1 == $month) {
        return $month . ' Month';
    }
    if ($month < 12) {
        return $month . ' Months';
    }
    if (12 == $month) {
        return ($month / 12) . ' Year';
    }

    return ($month / 12) . ' Years';
}

function pagination($baseurl, $total_row, $uri_segment = 2, $per_page = 12, $num_links = 3)
{
    $CI = &get_instance();
    $CI->load->library('pagination');
    $config['base_url'] = $baseurl;
    $config['total_rows'] = $total_row;
    $config['uri_segment'] = $uri_segment;
    $config['per_page'] = $per_page;
    // custom paging configuration
    $config['num_links'] = $num_links;
    $config['use_page_numbers'] = true;
    $config['reuse_query_string'] = true;
    $config['full_tag_open'] = '<ul class="pagination pagination-split">';
    $config['full_tag_close'] = '</ul>';
    $config['prev_link'] = '&lt;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&gt;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['first_link'] = '&lt;&lt;';
    $config['last_link'] = '&gt;&gt;';

    $CI->pagination->initialize($config);

    return $CI->pagination->create_links();
}

/**
 * $data['template'] : mail view path
 * $data['to'] : email address
 * $data['subject'] : email subject
 * $data['message'] : Message to be sent in email.
 *
 * @param mixed $data
 */
function sendEmail($data)
{
    // $ci = &get_instance();
    // $message = $ci->load->view(($data['template']), $data, true);

    // send with swift mailer
    // if ('swift' == getSetting('mail_agent')) {
    //     try {
    //         // Create the Transport
    //         $transport = (new Swift_SmtpTransport(getSetting('mail_host'), getSetting('mail_port'), 'tls'))
    //             ->setUsername(getSetting('mail_username'))
    //             ->setPassword(getSetting('mail_password'))
    //         ;

    //         // Create the Mailer using your created Transport
    //         $mailer = new Swift_Mailer($transport);

    //         // Create a message
    //         $message = (new Swift_Message(getSetting('site_name')))
    //             ->setFrom([getSetting('mail_username') => getSetting('site_name')])
    //             ->setTo([$data['to'] => ''])
    //             ->setSubject($data['subject'])
    //             ->setBody($message, 'text/html')
    //         ;

    //         //Send the message
    //         $result = $mailer->send($message);
    //         if ($result) {
    //             return true;
    //         }
    //     } catch (\Swift_TransportException $Ste) {
    //         $ci->session->set_flashdata('error', $Ste->getMessage());

    //         return false;
    //     } catch (\Swift_RfcComplianceException $Ste) {
    //         $ci->session->set_flashdata('error', $Ste->getMessage());

    //         return false;
    //     }
    // }

    // send with php mailer
    // if ('php' == getSetting('mail_agent')) {
    //     $mail = new PHPMailer(true);

    //     try {
    //         //Server settings
    //         $mail->isSMTP();
    //         $mail->Host = getSetting('mail_host');
    //         $mail->SMTPAuth = true;
    //         $mail->Username = getSetting('mail_username');
    //         $mail->Password = getSetting('mail_password');
    //         $mail->SMTPSecure = 'tls';
    //         $mail->CharSet = 'UTF-8';
    //         $mail->Port = getSetting('mail_port');
    //         //Recipients
    //         $mail->setFrom(getSetting('mail_username'), getSetting('site_name'));
    //         $mail->addAddress($data['to']);
    //         //Content
    //         $mail->isHTML(true);
    //         $mail->Subject = $data['subject'];
    //         $mail->Body = $message;
    //         $mail->send();

    //         return true;
    //     } catch (Exception $e) {
    //         $ci->session->set_flashdata('error', $mail->ErrorInfo);

    //         return false;
    //     }
    // }

    //send with codeigniter mail
    // if ('codeigniter' == getSetting('mail_agent')) {
    //     $ci->load->library('email');
    //     if ('mail' == getSetting('mail_protocol')) {
    //         $config = [
    //             'protocol' => 'mail',
    //             'smtp_host' => getSetting('mail_host'),
    //             'smtp_port' => getSetting('mail_port'),
    //             'smtp_user' => getSetting('mail_username'),
    //             'smtp_pass' => getSetting('mail_password'),
    //             'smtp_timeout' => 30,
    //             'mailtype' => 'html',
    //             'charset' => 'utf-8',
    //             'wordwrap' => true,
    //         ];
    //     } else {
    //         $config = [
    //             'protocol' => 'smtp',
    //             'smtp_host' => getSetting('mail_host'),
    //             'smtp_port' => getSetting('mail_port'),
    //             'smtp_user' => getSetting('mail_username'),
    //             'smtp_pass' => getSetting('mail_password'),
    //             'smtp_timeout' => 30,
    //             'mailtype' => 'html',
    //             'charset' => 'utf-8',
    //             'wordwrap' => true,
    //         ];
    //     }

    //initialize
    // $ci->email->initialize($config);
    // //send email
    // $message = $message;
    // $ci->email->from(getSetting('mail_username'), getSetting('site_name'));
    // $ci->email->to($data['to']);
    // $ci->email->subject($data['subject']);
    // $ci->email->message($message);

    // $ci->email->set_newline("\r\n");

    // if ($ci->email->send()) {
    //     return true;
    // }
    // $ci->session->set_flashdata('error', $ci->email->print_debugger(['headers']));

    // return false;
    // }
}
function sendEmailSimple($to, $subject, $message)
{
    $ci = &get_instance();
    $ci->load->library('email');
    //initialize
    $ci->email->initialize([
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'wordwrap' => true,
    ]);
    $ci->email->from('noreply@' . $_SERVER['SERVER_NAME'], getSetting('site_name'));
    $ci->email->to($to);
    $ci->email->subject($subject);
    $ci->email->message($message);
    $ci->email->set_newline("\r\n");
    if ($ci->email->send()) {
        return true;
    }
    $ci->email->print_debugger(['headers']);
}
function curlPost($url, $postData)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
function curlGet($url, $postData)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
function redirects($url = '')
{
    $ci = &get_instance();
    if ($return_url = $ci->session->return_url) {
        $ci->session->unset_userdata('return_url');
        redirect($return_url);
    } elseif ('' !== $url) {
        redirect($url);
    } else {
        redirect(base_url());
    }
}

function fileUpload($file_key, $file_name, $path = './uploads/', $allowed_type = 'jpg|jpeg|png', $max_size = '4096')
{
    $ci = &get_instance();
    $config['file_name'] = $file_name;
    $config['upload_path'] = $path;
    $config['allowed_types'] = $allowed_type;
    $config['max_size'] = $max_size;
    $config['overwrite'] = true;
    $ci->load->library('upload', $config);

    if (!$ci->upload->do_upload($file_key)) {
        return response(false, $ci->upload->display_errors());
    }

    return response(true, $ci->upload->data());
}
