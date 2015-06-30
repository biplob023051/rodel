<?php if (!empty($gradeLevels)) : ?>
	<?php foreach ($gradeLevels as $key => $gradeLevel) : ?>
		<li><a id="grade_<?php echo $gradeLevel['GradeLevel']['id']; ?>" href="#" onclick="grade(<?php echo $gradeLevel['GradeLevel']['id']; ?>, this.id)"><?php echo $gradeLevel['GradeLevel']['level_name']; ?></a></li>
	<?php endforeach; ?>
<?php endif; ?>