<?php include('_conf.php'); ?>

<script src="<?php echo $site_url.'/js/jquery.min.js'; ?>"></script>

<?php if(isset($_GET['text'])): ?>
<?php $text = $_GET['text']; ?>
<style>
.box {
	width: 200px;
	border:0px solid #ccc;
	text-align: center;
}
.box img {
	display: block;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
}
.box .text {
	text-align: center;
	font-size: 10px;
	font-family: monospace;
}
</style>
<div class="box">
	<img src="_inc/plugins/barcode.php?text=<?php echo $text; ?>" />
	<div class="text"><?php echo $text; ?></div>
</div>
<script>
	window.print();

	$(document).keydown(function(e) {
	    // ESCAPE key pressed
	    if (e.keyCode == 27) {
	        window.close();
	    }
	});
</script>
<?php endif; ?>
