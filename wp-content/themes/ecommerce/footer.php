<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage demo
 * @since demo 1.0
 */
?>
<div class="popup-1" style="display: none;z-index: 1002; top: 0px; left: 304.5px;">
  <div class="header"><a href="http://www.vinacapital.com" title="Vina Capital" class="logo"><img src="<?php echo THEMEURL?>/images/log-vinacapital.png" alt="Vina Capital"></a><a href="javascript:void(0);" title="Clodse" class="close">Close</a></div>
  <div class="content"></div>
  <ul class="footer">
          <li><a href="#" title="Asset Management">Asset Management</a>
          </li>
          <li><a href="#" title="Corporate Finance">Corporate Finance</a>
          </li>
          <li><a href="#" title="Real Estate">Real Estate</a>
          </li>
        </ul>
      </div>
    </main><!-- #main -->
    <footer id="footer">
        <div class="list-link">
            <p><?php echo sm_theme_option( 'copyright_value' )?></p>
            <ul>
              <li><a href="<?php echo get_bloginfo('url')?>/contact" title="<?php echo __('Contact us', THEMENAME)?>"><?php echo __('Contact us', THEMENAME)?></a></li>
                <li><a href="<?php echo get_bloginfo('url')?>/sitemap" title="<?php echo __('Sitemap', THEMENAME)?>"><?php echo __('Sitemap', THEMENAME)?></a></li>
            </ul>
        </div>
        <div class="inner">
            <p><?php echo sm_theme_option( 'term_and_conditions' )?></p>
        </div>
    </footer>
</div><!-- #container -->
<script src="<?php echo THEMEURL; ?>/js/l10n.js"></script>
<script src="<?php echo THEMEURL; ?>/js/libs.js"></script>
<script src="<?php echo THEMEURL; ?>/js/plugins.js"></script>
<noscript><?php _e('JavaScript is off. Please enable to view full site.', THEMENAME) ?></noscript>
<?php wp_footer() ?>
</body>
</html>