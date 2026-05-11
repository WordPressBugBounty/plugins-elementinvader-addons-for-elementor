<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Eli_MailBase_List_Table extends WP_List_Table
{
  public $results = [];
  function __construct()
  {
    global $status, $page;
    $this->results = $this->generate_data();
    parent::__construct(array(
      'singular'  => __('id', 'elementinvader-addons-for-elementor'), 
      'plural'    => __('mails', 'elementinvader-addons-for-elementor'),
      'ajax'      => false 
    ));
    add_action('admin_head', array(&$this, 'admin_header'));
  }

  protected function get_table_classes()
  {
    $mode = get_user_setting('posts_list_mode', 'list');

    $mode_class = esc_attr('table-view-' . $mode);

    return array('widefat', 'striped', $mode_class, $this->_args['plural']);
  }

  function generate_data()
  {
    // configuration
    $columns = array('id', 'date', 'email');

    // Fetch parameters
    $start = isset($_GET['start']) ? sanitize_text_field(wp_unslash($_GET['start']))  : 0;   // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
    $length = isset($_GET['length']) ? sanitize_text_field(wp_unslash($_GET['length'])) : 15; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
    $search =  isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s']))  : '';  // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.

    global $wpdb;
    $table = $wpdb->prefix . 'eli_newsletters';
    $where = 'WHERE 1=1';

    if (!empty($search)) {
        $like_search = '%' . $wpdb->esc_like($search) . '%';
        $where .= " AND (id LIKE {$like_search} OR email LIKE {$like_search})";
    }

    // Use a cache key based on start, length, and possible search parameters
    $eli_cache_key = 'eli_mailbase_results_' . md5( serialize( array( $table, $start, $length, $search ) ) );
    $results = wp_cache_get( $eli_cache_key, 'eli_mailbase' );

    if ( false === $results ) {
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM %i LIMIT %d, %d",
            $table,
            $start,
            $length
        ), ARRAY_A);
        wp_cache_set( $eli_cache_key, $results, 'eli_mailbase', 300 ); // Cache for 5 minutes
    }
    return $results;
  }

  function admin_header()
  {
    $page = (isset($_GET['page'])) ? sanitize_text_field(wp_unslash($_GET['page'])) : false; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
    if ('my_list_test' != $page)
      return;
    echo '<style type="text/css">';
    echo '.wp-list-table .column-id { width: 5%; }';
    echo '.wp-list-table .column-id { width: 40%; }';
    echo '.wp-list-table .column-date { width: 35%; }';
    echo '.wp-list-table .column-email { width: 20%;}';
    echo '</style>';
  }

  function no_items()
  {
    esc_html_e('Not found Emails', 'elementinvader-addons-for-elementor');
  }

  function column_default($item, $column_name)
  {
    switch ($column_name) {
      case 'id':
      case 'date':
      case 'email':
        return esc_html($item[$column_name]);
      default:
        return esc_html($item[$column_name]);
    }
  }

  function get_sortable_columns()
  {
    $sortable_columns = array(
      'email'   => array('email', false),
      'date' => array('date', false),
    );
    return $sortable_columns;
  }

  function get_columns()
  {
    $columns = array(
      'cb'        => '<input type="checkbox" />',
      'email'      => __('Email', 'elementinvader-addons-for-elementor'),
      'date'    => __('Submission date', 'elementinvader-addons-for-elementor'),
    );
    return $columns;
  }

  private function sort_data($a, $b)
  {
    // Set defaults
    $orderby = 'date';
    $order = 'desc';
    // If orderby is set, use this as the sort column
    if (!empty($_GET['orderby'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
      $orderby = sanitize_text_field(wp_unslash($_GET['orderby'])); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
    }
    // If order is set use this as the order
    if (!empty($_GET['order'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
      $order = sanitize_text_field(wp_unslash($_GET['order'])); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only search parameter.
    }
    $result = strcmp($a[$orderby], $b[$orderby]);
    if ($order === 'asc') {
      return $result;
    }
    return -$result;
  }

  function column_id($item)
  {
    $actions = array(
    );

    return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
  }

  function get_bulk_actions()
  {
    $actions = array(
      'delete'    => 'Delete'
    );
    return $actions;
  }

  public function process_bulk_action()
  {
    return false;
  }

  function column_cb($item)
  {
    return sprintf(
      '<input type="checkbox" name="bulk-delete[]" value="%s" />',
      $item['id']
    );
  }

  function prepare_items()
  {
    $columns  = $this->get_columns();
    $hidden   = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    usort($this->results, array(&$this, 'sort_data'));

    $per_page = 10;
    $current_page = $this->get_pagenum();

    $total_items = count($this->results);
    // only ncessary because we have sample data
    $found_data = array_slice($this->results, (($current_page - 1) * $per_page), $per_page);
    $this->set_pagination_args(array(
      'total_items' => $total_items,                  //WE have to calculate the total number of items
      'per_page'    => $per_page                     //WE have to determine how many items to show on a page
    ));

    $this->items = $found_data;
    $this->process_bulk_action();
  }

  /**
   * Delete a customer record.
   *
   * @param int $id customer ID
   */
  public static function delete($id)
  {
    global $wpdb;
    // Delete row from DB, then delete row/object from object cache if present
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
    $result = $wpdb->delete(
      "{$wpdb->prefix}eli_newsletters",
      ['id' => $id],
      ['%d']
    );
    if ( $result !== false ) {
      // Remove from object cache if present (per-row key and main export/all-results cache)
      wp_cache_delete( $id, "{$wpdb->prefix}eli_newsletters" );
      wp_cache_delete( 'eli_newsletters_all_results', 'db' );
      wp_cache_delete( 'eli_newsletters_export_all_results', 'eli_newsletters' );
    }
  }
}
?>

<div class="wrap eli_wrapper">
  <h1><?php esc_html_e('Newsletter', 'elementinvader-addons-for-elementor'); ?></h1>
  </br>

  <?php if (eli_count($results)) : ?>
    <a href="<?php echo esc_url(admin_url('tools.php?action=eli_export_email_base')); ?>" class="button button-primary"><?php echo esc_html__('Export csv All', 'elementinvader-addons-for-elementor'); ?></a>
    </br>
  <?php else : ?>
    <div class="bootstrap-wrapper">
      <div class="alert alert-info alert-dismissible" role="alert" style="margin-bottom: -10px">
        <?php echo esc_html__('No emails for export', 'elementinvader-addons-for-elementor'); ?>
      </div>
    </div>
  <?php endif ?>
  <div class="">
    <div class="panel panel-default">
      <div class="panel-body">
        <!-- Data Table -->
        <div class="box box-without-bottom-padding">
          <?php
          $option = 'per_page';
          $args = array(
            'label' => esc_html__('MailBase', 'elementinvader-addons-for-elementor'),
            'default' => 10,
            'option' => 'ids_per_page'
          );
          add_screen_option($option, $args);
          $Eli_MailBase = new Eli_MailBase_List_Table();
          $Eli_MailBase->prepare_items();
          ?>
          <form method="post">
            <input type="hidden" name="page" value="mails_list">
            <?php
            $Eli_MailBase->search_box('search', 'mail');
            $Eli_MailBase->display();
            echo '</form></div>';
            ?>
        </div>
      </div>
    </div>
  </div>
</div>