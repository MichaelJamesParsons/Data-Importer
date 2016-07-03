<?php
namespace michaeljamesparsons\DataImporter\Writers;

interface SourceWriterInterface
{
    public function write(array $item, $entity);
}