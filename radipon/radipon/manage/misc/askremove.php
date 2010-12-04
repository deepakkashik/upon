<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$id = abs(intval($_GET['id']));
Table::Delete('ask', $id);
Session::Set('notice', sprintf(MANAGE_MISC_ASKREMOVE_NOTICESUCCESS_ID,$id));
Utility::Redirect(udecode($_GET['r']));
