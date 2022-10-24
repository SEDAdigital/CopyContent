<?php

use MODX\Revolution\modResource;
use MODX\Revolution\modTemplateVar;
use MODX\Revolution\Processors\Processor;

/**
 * CopyContent Processor
 * @copyright 2019 SEDA.digital GmbH & Co. KG
 */

class CopyContent extends Processor
{
    public function process()
    {
        // validate required properties
        $sourceID = $this->getProperty('source_resource_id');
        $targetID = $this->getProperty('target_resource_id');
        $this->modx->log(modX::LOG_LEVEL_INFO, "Trying to clone content from {$sourceID} to {$targetID}");
        if (!$sourceID || !$targetID) {
            return $this->failure($this->modx->lexicon('copycontent.err.missing_id'));
        }
        if ($sourceID === $targetID) {
            return $this->failure($this->modx->lexicon('copycontent.err.target_is_source'));
        }

        // make sure resources are valid
        /** @var modResource|null $source */
        $source = $this->modx->getObject(modResource::class, [
            'id' => $sourceID,
        ]);
        /** @var modResource|null $target */
        $target = $this->modx->getObject(modResource::class, [
            'id' => $targetID,
        ]);
        if (!$target || !$source) {
            return $this->failure($this->modx->lexicon('copycontent.err.resource_not_found'));
        }

        if (!$target->checkPolicy('save')) {
            return $this->failure($this->modx->lexicon('copycontent.err.save_not_allowed'));
        }

        if (!$this->doMagic($source, $target, $this->getProperty('copy_tvs', false))) {
            return $this->failure($this->modx->lexicon('copycontent.err.copy_failure'));
        }


        return $this->success();
    }

    private function doMagic(modResource $source, modResource $target, $copyTvs = false) : bool
    {
        $this->modx->log(modX::LOG_LEVEL_INFO, 'Setting raw content');
        $target->setContent($source->getContent());

        // handle content block content
        $this->modx->log(modX::LOG_LEVEL_INFO, 'Checking for content blocks usage');
        $isCb = $source->getProperty('_isContentBlocks', 'contentblocks');
        if ($isCb) {
            $this->modx->log(modX::LOG_LEVEL_INFO, 'Source resource uses content blocks, so copying properties over');
            $target->setProperty('_isContentBlocks', true, 'contentblocks');
            $cbJson = $source->getProperty('content', 'contentblocks');
            $target->setProperty('content', $cbJson, 'contentblocks');
        }

        if ($copyTvs) {
            $collection = $source->getTemplateVars();
            /** @var modTemplateVar $templateVar */
            foreach ($collection as $templateVar) {
                $target->setTVValue(
                    $templateVar->get('id'),
                    $templateVar->getValue($source->get('id'))
                );
            }
        }

        $this->modx->log(modX::LOG_LEVEL_INFO, 'Before saving target resource');
        $saved = $target->save();
        if ($saved) {
            $this->modx->log(modX::LOG_LEVEL_INFO, 'Before clearing target resource cache');
            $target->clearCache($target->get('context_key'));
        }

        return $saved;
    }
}

return CopyContent::class;
