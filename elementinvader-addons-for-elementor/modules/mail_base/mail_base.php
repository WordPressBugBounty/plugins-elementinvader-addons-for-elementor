<?php 
add_action('admin_menu', 'eli_mail_base');

function eli_mail_base() {
    add_submenu_page('tools.php', 
                       esc_html__('Newsletter', 'elementinvader-addons-for-elementor'), esc_html__('Newsletter', 'elementinvader-addons-for-elementor'), 'manage_options', 'eli-mails', 'eli_mails');
}

function eli_mails() {
    wp_enqueue_style( 'font-awesome', plugins_url( 'assets/admin/css/font-awesome.min.css',ELEMENTINVADER_ADDONS_FOR_ELEMENTOR__FILE__), false, '1.0.0' );
    wp_enqueue_style( 'eli-wrapper-admin',plugins_url( 'assets/admin/css/eli-wrapper.css',ELEMENTINVADER_ADDONS_FOR_ELEMENTOR__FILE__), false, false); 

    global $wpdb; 
    $table = "{$wpdb->prefix}eli_newsletters";
    $results = $wpdb->get_results( "SELECT * FROM $table", ARRAY_A  );

    include_once (ELEMENTINVADER_ADDONS_FOR_ELEMENTOR_PATH."pages/mail_base/index.php");
}

function eli_export_email_base() {
        $csv=array();
        /* special field */
        $csv_header['email']='email';
        $csv_header['date']='date';
        $csv_header['website']='website';
        /* end special field */
        
        $csv_t=array();
       // $csv_t[]=implode(';', $csv_header);
        $csv_t=array();
        
        
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}eli_newsletters", OBJECT );
        foreach ($results as $key => $value) {
            $csv_t[$key]['email'] =  '"'.$value->email.'"';
            $csv_t[$key]['date'] =  '"'.$value->date.'"';
            $csv_t[$key]['website'] =  '"'.$value->website.'"';
        }
        // create csv file, and skip not use fields from db
        $fieldId=1;
        foreach ($csv_t as $row) {
            $row_t=$csv_header;
            foreach ($csv_header as $key => $value) {
               if(isset($row[$key]))
                $row_t[$key]=$row[$key];
            }
            $csv[]= implode(';',  $row_t);
            $fieldId++;
        }
        array_unshift($csv, implode(';', $csv_header));
        $csv=implode(PHP_EOL, $csv);
        
        $date = date('Y-m-d');
        $filename = 'export_'.$date.'.csv';
        
        // Generate the server headers
        if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE)
        {
                header('Content-Type: "text/csv"');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header("Content-Transfer-Encoding: binary");
                header('Pragma: public');
                header("Content-Length: ".strlen($csv));
        }
        else
        { 
                header('Content-Type: "text/csv"');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                header("Content-Transfer-Encoding: binary");
                header('Expires: 0');
                header('Pragma: no-cache');
                header("Content-Length: ".strlen($csv));
        }

        exit($csv);
}

add_filter('admin_action_eli_export_email_base', 'eli_export_email_base');

// Called from ajax
// json for datatables
function eli_mails_bulk_remove()
{
    if ( ! current_user_can( 'administrator' ) ) {
        exit();
    }
    
    check_ajax_referer('eli_secure_ajax', 'eli_secure');
    
    $ids= eli_xss_clean($_POST['ids']);


    $json = array(
        "ids" => $ids,
    );
    global $wpdb;
    foreach($ids as $id)
    {
        if(is_numeric($id))
            $wpdb->delete( "{$wpdb->prefix}eli_newsletters", [ 'id' => $id ] );
    }

    if(TRUE)
    {
        ob_clean();
        ob_start();
    }
    //$length = strlen(json_encode($data));
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache');
    header('Content-Type: application/json; charset=utf8');
    //header('Content-Length: '.$length);
    echo json_encode($json);
    
    exit();
}

add_filter('admin_action_eli_mails_bulk_remove', 'eli_mails_bulk_remove');