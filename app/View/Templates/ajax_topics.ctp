<?php if ($topics) : ?>
	<?php foreach ($topics as $key => $topic) : ?>
		<li> 
			<a id="topic_<?php echo $topic['Topic']['id']; ?>" href="#" onclick="topicProblems(<?php echo $topic['Topic']['id']; ?>, this.id)"><?php echo $topic['Topic']['topic_name']; ?></a>
		</li>
	<?php endforeach; ?>
<?php else: ?>
	<li><a href='#'>No Topics Found</a></li>
<?php endif; ?>