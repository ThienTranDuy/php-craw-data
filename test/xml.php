<?php
$test_array = array (
  'bla' => 'blub',
  'foo' => 'bar',
  'another_array' => array (
    'stack' => 'overflow',
  ),
);

function to_xml(SimpleXMLElement $object, array $data)
{   
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $new_object = $object->addChild($key);
            to_xml($new_object, $value);
        } else {
            // if the key is an integer, it needs text with it to actually work.
            if ($key == (int) $key) {
                $key = "key_$key";
            }

            $object->addChild($key, $value);
        }   
    }   
} 

$xml = new SimpleXMLElement('<rootTag/>');
to_xml($xml, $test_array);

print $xml->asXML();