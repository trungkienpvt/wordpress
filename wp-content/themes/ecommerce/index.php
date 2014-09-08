<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage demo
 * @since demo 1.0
 */

get_header(); ?>
      
        <?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
        <div class="hightlight-2">
          <div class="inner">
            <div class="share-price">
              <h2>Latest fund share prices</h2>
              <table class="table-1">
                <thead>
                  <tr>
                    <th>Company</th>
                    <th>VNL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Share price</td>
                    <td>$ 0.49</td>
                  </tr>
                  <tr>
                    <td>% change</td>
                    <td>1.55%</td>
                  </tr>
                  <tr>
                    <td>Nav /share*</td>
                    <td>$ 0.92</td>
                  </tr>
                  <tr>
                    <td>Total nav (usd mn)*</td>
                    <td>439.0</td>
                  </tr>
                  <tr>
                    <td>Go to <span class="color-1">VNL page </span>on LSE site</td>
                    <td>*Dec 2013</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="event-travel">
              <h2>events and travel schedule</h2><a href="" title="EVents and Travel Schedule">EVents and Travel Schedule</a>
            </div>
            <div class="compay-news">
              <h2>company news</h2>
              <ul>
                <li><a href="#" title="">VNL appointment of new Director <span class="date">(24/01/2014)</span></a></li>
                <li><a href="#" title="">VNL Market prospects for 2014 <span class="date">(24/01/2014)</span></a></li>
                <li><a href="#" title="">VNL appointment of new Director <span class="date">(24/01/2014)</span></a></li>
                <li><a href="#" title="">VNL Dec 2013 <span class="date">(24/01/2014)</span></a></li>
              </ul>
            </div>
          </div><span class="line-shadow"></span>
        </div>
      </main>
      <?php get_footer(); ?>