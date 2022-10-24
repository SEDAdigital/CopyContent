<?php
/**
 * @var $_lang array
 * @var \MODX\Revolution\modLexicon $this
 *
 * @see modLexicon::getFileTopic()
 */
$prefix = 'copycontent';
$_lang = [
    "{$prefix}.button" => 'Copier le contenu',
    "{$prefix}.title" => 'Copy content',
    "{$prefix}.description" => '<p>Veuillez sélectionner la ressource de destination vers laquelle le contenu de la ressource actuelle doit être copié. Le contenu précédent de la ressource de destination sera écrasé.</p>',
    "{$prefix}.unsaved_warning" =>'<p>Vos modifications actuelles n\'ont pas été sauvegardées. Veuillez enregistrer la ressource courante si vous voulez prendre en compte ces modifications.</p>',
    "{$prefix}.target_label" => 'Ressource de destination',
    "{$prefix}.copy_tvs" => 'Copier également le contenu des variables de modèle (TV).',
    "{$prefix}.copy_button" => 'Copier',
    "{$prefix}.success_title" => 'Succès',
    "{$prefix}.success_message" => 'Le contenu a été copié avec succès sur la ressource de destination [[+cible]]. <p>Souhaitez-vous éditer cette ressource maintenant ?</p>',
    "{$prefix}.err.missing_id" => 'Il manque les IDs de ressource source et/ou de destination.',
    "{$prefix}.err.target_is_source" => 'On ne copiera pas le contenu sur la même ressource :) !',
    "{$prefix}.err.resource_not_found" => 'Au moins une des ressources n\'existe pas.',
    "{$prefix}.err.save_not_allowed" => 'Vous n\'êtes pas autorisé à sauvegarder la ressource de destination.',
    "{$prefix}.err.copy_failure" => 'Nous n\'avons pas été en mesure de copier le contenu dans la ressource de destination. Veuillez réessayer.',
];
