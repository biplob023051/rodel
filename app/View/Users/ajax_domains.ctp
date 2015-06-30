<?php if ($domains) : ?>
	<?php foreach ($domains as $key => $domain) : ?>
		<li> 
			<a id="domain_<?php echo $domain['Domain']['id']; ?>" href="#" onclick="domainProblems(<?php echo $domain['Domain']['id']; ?>, this.id)"><?php echo $domain['Domain']['domain_name']; ?></a>
		</li>
	<?php endforeach; ?>
<?php else: ?>
	<li><a href='#'>No Domains Found</a></li>
<?php endif; ?>