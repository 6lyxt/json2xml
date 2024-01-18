<?
/**
 * Class JsonToXmlParser
 * @author 6lyxt
 */
class JsonToXmlParser
{

    /**
     * @var string XML string
     */
    private string $xmlString = '';

    /**
     * @var SimpleXMLElement|null Parent XML element
     */
    private SimpleXMLElement $xml;

    /**
     * JsonToXmlParser constructor.
     */
    public function __construct()
    {
        $this->xml = new SimpleXMLElement('<root/>');
    }

    /**
     * Parse JSON and convert it to XML.
     *
     * @param string $json JSON string to be parsed
     * @return string XML representation of the JSON
     */
    public function parseJsonToXml(string $json): string
    {
        $data = json_decode($json, true);
        $this->arrayToXml($data);

        return $this->xmlString;
    }

    /**
     * Convert an array to XML.
     *
     * @param array $data Associative array to be converted to XML
     */
    private function arrayToXml(array $data): void
    {
        $this->arrayToXmlRecursive($data, $this->xml);
        $this->xmlString = $this->xml->asXML();
    }

    /**
     * Recursively convert an array to XML.
     *
     * @param array $data Associative array to be converted to XML
     * @param SimpleXMLElement $xml Parent XML element
     */
    private function arrayToXmlRecursive(array $data, SimpleXMLElement $xml): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $xml->addChild($key);
                $this->arrayToXmlRecursive($value, $child);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }

    /**
     * Parse XML and convert it to JSON.
     *
     * @param string $xml XML string to be parsed
     * @return string JSON representation of the XML
     */
    public function parseXmlToJson(string $xml): string
    {
        $xmlObject = simplexml_load_string($xml);
        $json = json_encode($xmlObject, JSON_PRETTY_PRINT);

        return $json;
    }
}
