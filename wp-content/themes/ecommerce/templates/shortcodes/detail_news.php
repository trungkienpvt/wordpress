
<h2 class="title"><?php echo $post_data['Title']?></h2>
<div class="inner">
  <?php $date_create = $post_data['Date']?>
  <p><?php echo date('d F Y',  strtotime($date_create)) ?></p>
  <?php echo $post_data['Content']?>
</div