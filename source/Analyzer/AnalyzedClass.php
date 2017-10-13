<?php
namespace Insphptor\Analyzer;

class AnalyzedClass
{
    /**
     * Informations this class
     * @var array
     */
    private $info = [];

    /**
     * Construtor for analyser, get and store trivial informations: filename,
     * tokenize and number lines
     * @param string $filename path to file class
     */
    public function __construct(string $filename)
    {
        $this->info['filename'] = $filename;
        $buffer = file_get_contents($filename);

        $this->info['token'] = token_get_all($buffer);
        $this->info['lines'] = substr_count($buffer, "\n");
        unset($buffer);
    }

    /**
     * Use function to get dynamic attributes from info array
     * @param  string $attribute attribute name
     * @return mixed            attribute value or null
     */
    public function __get(string $attribute)
    {
        if (key_exists($attribute, $this->info)) {
            return $this->info[$attribute];
        }

        return null;
    }

    /**
     * Get ao informations
     * @return array informations from class
     */
    public function getAttributes() : array
    {
        return $this->info;
    }

    /**
     * Add an attribute in class
     * @param  string $name  attribute name
     * @param  mixed $value attribute value
     */
    public function pushAttribute(string $name, $value)
    {
        $this->info[$name] = $value;
    }

    /**
     * Add an metric in class
     * @param  string $name  metric name
     * @param  float $value metric value
     */
    public function pushMetric(string $name, $value)
    {
        $this->info['metrics'][$name] = $value;
    }

    /**
     * Get filename this class, override any toString
     * @return string class filename
     */
    public function __toString() : string
    {
        return $this->info['filename'];
    }

    /**
     * Transform this class in array, ommit unreal attributes
     * @return array relevant informations
     */
    public function toArray() : array
    {
        $array = $this->info;
        unset($array['token']);

        foreach ($array['methods'] as $key => $value) {
            unset($array['methods'][$key]['content']);
        }

        return $array;
    }
}
