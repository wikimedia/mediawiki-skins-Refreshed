<?php

// TODO Look at taint issues and fix
$disableTaintCheck = true;

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config.php';

$cfg['directory_list'] = array_merge(
	$cfg['directory_list'],
	[
		'../../extensions/SocialProfile',
	]
);

$cfg['exclude_analysis_directory_list'] = array_merge(
	$cfg['exclude_analysis_directory_list'],
	[
		// We don't actually *depend on* SocialProfile, we merely *support* it, but phan cannot tell the difference.
		'../../extensions/SocialProfile',
	]
);

return $cfg;