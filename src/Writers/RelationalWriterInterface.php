<?php
namespace michaeljamesparsons\DataImporter\Writers;

interface RelationalWriterInterface
{
    public function write(array $item, $entity);
}