<?php
/**
 * Template Name: Sitemap
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage demo
 * @since demo 1.0
 */
// download file when client request
do_action('download_file');
do_action('wp_ajax_load');
$xml = new DOMDocument();
$xml_url = get_bloginfo('url') . '/sitemap-externals.xml' ;
$error_message = '';
if (($response_xml_data = file_get_contents($xml_url))===false){
   $error_message = "Error fetching XML\n";
} else {
   libxml_use_internal_errors(true);
   $sitemap_data = simplexml_load_string($response_xml_data);
   if (!$sitemap_data) {
        $error_message .= "Error loading XML\n";
       foreach(libxml_get_errors() as $error) {
           $error_message .= "\t" . $error->message;
       }
   } else {
     
   }
}

$arr_results = array();
if(!empty($sitemap_data)) {
  foreach($sitemap_data as $item):
    $child_data = $item->children();
    $data['loc'] = (string) $child_data->loc;
    $data['lastmod'] = (string) $child_data->lastmod;
    $data['changefreq'] = (string) $child_data->changefreq;
    $data['priority'] = (string) $child_data->priority;
    $arr_results[] = $data;
  endforeach;
}
$post = get_post();
get_header(); ?>
    <?php while ( have_posts() ) : the_post() ?>
<div class="sitemap-page">
  <ul class="breadcrumb">
    <li class="active"><a href="" title="Sitemap"><?php echo __('Sitemap', THEMENAME)?></a>
    </li>
  </ul>
  <?php echo $post->post_content ?>
  <?php if(!empty($arr_results)):?>
  <table class="table-1">
            <thead>
              <tr>
                <th>URL</th>
                <th>Priority</th>
                <th>Change Frequency</th>
                <th>LastChange (GMT)</th>
              </tr>
            </thead>
            <tbody>
              <?php $k=0;?>
              <?php foreach($arr_results as $item):?>
              <?php if($k%2==0)
                      $class="even";
                    else
                      $class='odd';
                    $k=1-$k;
              ?>
              <tr class="<?php echo $class?>">
                <td><?php echo $item['loc']?></td>
                <td><?php echo $item['priority']?>%</td>
                <td><?php echo $item['changefreq']?></td>
                <td><?php echo $item['lastmod']?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
  <?php endif;?>
  
</div>
    <?php endwhile; ?>
<?php get_footer(); ?>