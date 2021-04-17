<?php

if (!function_exists('parseXmlFile')) {
    function parseXmlFile(string $filePath): SimpleXMLElement
    {
        try {
            $xmlObj = simplexml_load_file($filePath);
        } catch (\Exception $ex) {
            throw new \RuntimeException($ex);
        }

        return $xmlObj;
    }
}
