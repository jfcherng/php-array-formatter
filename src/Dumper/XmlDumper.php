<?php

namespace Jfcherng\ArrayDumper\Dumper;

use Jfcherng\ArrayDumper\Core\AbstractDumper;
use Spatie\ArrayToXml\ArrayToXml;

class XmlDumper extends AbstractDumper
{
    /**
     * {@inheritdoc}
     */
    const EXTENSION = 'xml';

    /**
     * {@inheritdoc}
     */
    protected static $optionsDef = [
        // the name of the root node
        'root' => 'root',
        // the attributes of the root node
        'rootAttr' => [],
        // the XML version
        'version' => '1.0',
        // encoding
        'encoding' => 'UTF-8',
        // prettify the output
        'prettify' => true,
        // convert spaces in key into underscores
        'keySpaceToUnderscore' => true,
    ];

    /**
     * {@inheritdoc}
     *
     * @see https://github.com/spatie/array-to-xml
     */
    public function pureDump(array $array): string
    {
        $xml = new ArrayToXml(
            $array,
            [
                '_attributes' => $this->options['rootAttr'],
                'rootElementName' => $this->options['root'],
            ],
            $this->options['keySpaceToUnderscore']
        );

        $dom = $xml->toDom();
        $dom->xmlVersion = $this->options['version'];
        $dom->encoding = $this->options['encoding'];
        $dom->formatOutput = $this->options['prettify'];

        return $dom->saveXML();
    }
}