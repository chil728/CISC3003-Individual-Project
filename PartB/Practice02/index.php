<!--Splitting the header and footer into separate documents makes things easier!-->
<?php
include_once 'header.php';
?>

<section class="index-intro">
	<?php if (isset($_SESSION['useruid'])): ?>
		<p>Welcome, <?php echo $_SESSION["useruid"]; ?>!</p>
	<?php endif; ?>
	<h1>This is An Introduction </h1>
</section>