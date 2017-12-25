<?php
/**
 * Support Functionality available sitewide
 *
 */

/** Pretty-print an object introspection **/
function pp($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}
/** pp alternative for use on valet **/
function dump($obj)
{
    echo "<pre>" . highlight_string("<?php\n\$data =\n" . var_export($obj, true) . ";\n?>") . '</pre>';
}
/** die and dump context **/
function dd($obj)
{
    dump($obj);
    die;
}

function find_equipment_images($cat, $class) {

	if(empty($cat) && empty($class)) return false;

	$cat = str_pad($cat, 3, '0', STR_PAD_LEFT);

	$path = ABSPATH . 'assets/images/supplied/';

	$equipment_images = array(); 

	for ($x = 1; $x <= 5; $x++) if(file_exists($path . $cat . '-' . $class . '-0' . $x . '.jpg')) $equipment_images[] = $cat . '-' . $class . '-0' . $x . '.jpg';

	$class = str_pad($class, 4, '0', STR_PAD_LEFT);

	for ($x = 1; $x <= 5; $x++) 
		if(file_exists($path . $cat . '-' . $class . '-0' . $x . '.jpg')) $equipment_images[] = $cat . '-' . $class . '-0' . $x . '.jpg';

	return $equipment_images;

}

function find_equipment_images_by_id($id) {

	if(empty($id)) return false;

	$fields = get_fields($id);

	if(empty($fields['cat']) && empty($fields['class'])) return false;

	return find_equipment_images($fields['cat'], $fields['class']);

}

function send_notifications($form_id, $entry_id) {

	$form = RGFormsModel::get_form_meta($form_id);

	$entry = RGFormsModel::get_lead($entry_id);

	$notification_ids = array();

	foreach($form['notifications'] as $id => $info) { array_push($notification_ids, $id); }

	GFCommon::send_notifications($notification_ids, $form, $entry);

}