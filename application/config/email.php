<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------
| CodeIgniter Email Configuration File.
|---------------------------------------------------------------------
|
| Location: ./application/config/email.php
|
| Please see the link below for Email Configuration values.
|
| https://codeigniter.com/user_guide/libraries/email.html#setting-email-preferences-in-a-config-file
*/

$config['useragent']        = 'CodeIgniter';
$config['protocol']         = 'mail';
$config['mailpath']         = '/usr/sbin/sendmail';
$config['smtp_host']        = '';
$config['smtp_user']        = '';
$config['smtp_pass']        = '';
$config['smtp_port']        = 25;
$config['smtp_timeout']     = 5;
$config['smtp_keepalive']   = FALSE;
$config['smtp_crypto']      = '';
$config['wordwrap']         = TRUE;
$config['wrapchars']        = 76;
$config['mailtype']         = 'text';
$config['charset']          = 'utf-8';
$config['validate']         = FALSE;
$config['priority']         = 3;
$config['crlf']             = '\n';
$config['newline']          = '\n';
$config['bcc_batch_mode']   = FALSE;
$config['bcc_batch_size']   = 200;
$config['dsn']              = FALSE;

/**
 * -----------------------------------------------------------------------
 * Filename: email.php
 * Location: ./application/config/email.php
 * -----------------------------------------------------------------------
 */ 