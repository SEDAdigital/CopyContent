<?php
/**
 * @var $_lang array
 * @var modLexicon $this
 *
 * @see modLexicon::getFileTopic()
 */
$prefix = 'copycontent';
$_lang = [
    "{$prefix}.button" => 'Copy content',
    "{$prefix}.title" => 'Copy content',
    "{$prefix}.description" => '<p>Please select the target resource into which the contents of the current resource are to be copied. The previous contents of the target resource will be overwritten.</p>',
    "{$prefix}.unsaved_warning" =>'<p>Your changes have not been saved. Please save the current resource if you want to reflect pending changes.</p>',
    "{$prefix}.target_label" => 'Target resource',
    "{$prefix}.copy_tvs" => 'Copy contents of Template Variables (TVs) as well',
    "{$prefix}.copy_button" => 'Copy',
    "{$prefix}.success_title" => 'Success',
    "{$prefix}.success_message" => 'Content has been successfully copied to the target resource [[+target]]. <p>Would you like to go to that resource now?</p>',

    "{$prefix}.err.missing_id" => 'Either source and/or target resource IDs is missing.',
    "{$prefix}.err.target_is_source" => 'We won\'t copy over the content to the same resource, you fool!',
    "{$prefix}.err.resource_not_found" => 'At least one of the resources is not existing.',
    "{$prefix}.err.save_not_allowed" => 'You are not allowed to save the target resource.',
    "{$prefix}.err.copy_failure" => 'We were unable to copy content to targeted resource. Please try again.',
];
