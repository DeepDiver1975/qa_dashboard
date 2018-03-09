<?php
script('qa_dashboard', 'bootstrap.bundle.min');
style('qa_dashboard', 'bootstrap-grid.min');
style('qa_dashboard', 'bootstrap.min');
?>

<h3 class="display-3">QA DashBoard for ownCloud</h3>
<div class="container">
<?php foreach ($_['dashboard'] as $repo) {
	/** @var \OCA\QaDashboard\Repo $repo */?>
	<div class="row">
		<div class="col-sm-9">
			<a href="<?php print_unescaped($repo->getRepoLink())?>" target="_blank"><?php p($repo->getDisplayName()) ?></a>
				<?php foreach ($repo->getBranches() as $branch) {
				/** @var \OCA\QaDashboard\RepoState $branch */?>
				<div class="row">
					<div class="col">
						<?php p($branch->getDisplayName()) ?>
					</div>

				<?php foreach ($branch->getBuildStatusBadges() as $badges) { ?>
					<div class="col">
						<a href="<?php print_unescaped($badges['url']) ?>" target="_blank">
							<img src="<?php print_unescaped($badges['badge']) ?>" />
						</a>
					</div>
				<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
		<?php } ?>
</div>
