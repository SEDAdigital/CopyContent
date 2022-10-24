<?php
/**
 * @var $_lang array
 * @var \MODX\Revolution\modLexicon $this
 *
 * @see modLexicon::getFileTopic()
 */
$prefix = 'copycontent';
$_lang = [
    "{$prefix}.button" => 'Copiar contenido',
    "{$prefix}.title" => 'Copiar contenido',
    "{$prefix}.description" => '<p>Selecciona el recurso de destino en el que se copiará el contenido del recurso actual. El contenido existente en el recurso de destino se sobrescribirá.</p>',
    "{$prefix}.unsaved_warning" =>'<p>Tus cambios no se han guardado. Guarda el recurso actual si deseas reflejar los cambios pendientes.</p>',
    "{$prefix}.target_label" => 'Recurso de destino',
    "{$prefix}.copy_tvs" => 'Copiar contenidos de Variables de Plantilla (TVs) también',
    "{$prefix}.copy_button" => 'Copiar',
    "{$prefix}.success_title" => 'Hecho',
    "{$prefix}.success_message" => 'El contenido se ha copiado correctamente al recurso de destino [[+target]]. <p> ¿Te gustaría ir a ese recurso ahora? </p>',

    "{$prefix}.err.missing_id" => 'Faltan los ID de los recursos de origen y/o destino.',
    "{$prefix}.err.target_is_source" => 'No copiaremos el contenido al mismo recurso, ¡tonto!',
    "{$prefix}.err.resource_not_found" => 'Al menos uno de los recursos no existe.',
    "{$prefix}.err.save_not_allowed" => 'No tienes permiso para guardar el recurso de destino.',
    "{$prefix}.err.copy_failure" => 'No pudimos copiar contenido al recurso objetivo. Inténtalo de nuevo.',
];
