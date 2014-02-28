	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
	<img src="images/hamsters_wheel.jpg" alt="Hamsters in a wheel" />

    <p>The repository was put together by a team of dedicated hamsters, with a back-end of tireless rats running in wheels to generate power. It currently has <strong><?php echo $query -> num_rows(); ?></strong> public records.</p>
    <p>This is the public interface to the database. If you'd like to enter or update existing records, please login (you need to be a registered user). </p>
	
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
