<?php
/**
 * @var $_lang array
 * @var \MODX\Revolution\modLexicon $this
 *
 * @see modLexicon::getFileTopic()
 */
$prefix = 'copycontent';
$_lang = [
    "{$prefix}.button" => 'Inhalt kopieren',
    "{$prefix}.title" => 'Inhalte kopieren',
    "{$prefix}.description" => '<p>Bitte wählen Sie die Zielressource aus, in die die Inhalte der aktuellen Ressource kopiert werden sollen. Die bisherigen Inhalte der Zielressource werden dabei überschrieben.</p>',
    "{$prefix}.unsaved_warning" => '<p>Sie haben ungespeicherte Änderungen. Bitte speichern Sie die Ressource, bevor Sie die Inhalte kopieren.</p>',
    "{$prefix}.target_label" => 'Zielressource',
    "{$prefix}.copy_tvs" => 'Inhalte der Template-Variablen (TVs) auch kopieren',
    "{$prefix}.copy_button" => 'Kopieren',
    "{$prefix}.success_title" => 'Erfolgreich',
    "{$prefix}.success_message" => 'Die Inhalte wurden erfolgreich in die Zielressource [[+target]] kopiert. <p>Möchten Sie jetzt zur Zielressource wechseln?</p>',

    "{$prefix}.err.missing_id" => 'Die ID der Quell- oder Zielressoure fehlt.',
    "{$prefix}.err.target_is_source" => 'Der Inhalt kann nicht in die selbe Ressource kopiert werden!',
    "{$prefix}.err.resource_not_found" => 'Quell- oder Zielressource existiert nicht.',
    "{$prefix}.err.save_not_allowed" => 'Sie sind nicht berechtigt die Zielressource zu speichern.',
    "{$prefix}.err.copy_failure" => 'Es trat ein Fehler beim Kopieren zur Zielressource auf. Bitte versuchen Sie es noch einmal.',
];
