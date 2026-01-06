<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|*/

$hook['post_controller_constructor'][] = array(
                                'function' => 'redirect_ssl',
                                'filename' => 'ssl.php',
                                'filepath' => 'hooks'
                                );
								
$hook['post_controller_constructor'][] = array(
								'class'    => 'application_company',
                                'function' => 'check_company',
                                'filename' => 'company.php',
                                'filepath' => 'hooks'
                                );								
								
$hook['post_controller_constructor'][] = array(
								'class'    => 'subcription',
                                'function' => 'renew_before_days',
                                'filename' => 'renew.php',
                                'filepath' => 'hooks'
                                );								
								 										
								