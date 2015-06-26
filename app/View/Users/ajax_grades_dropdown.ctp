<?php if (!empty($gradeLevels)) : ?>
	<?php foreach ($gradeLevels as $key => $gradeLevel) : ?>
		<li><a href='#' onclick='grade(<?php echo $gradeLevel['GradeLevel']['id']; ?>)'><?php echo $gradeLevel['GradeLevel']['level_name']; ?></a></li>
	<?php endforeach; ?>
<?php endif; ?>