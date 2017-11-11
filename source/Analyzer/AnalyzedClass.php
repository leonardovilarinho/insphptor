<?php
namespace Insphptor\Analyzer;

use Symfony\Component\Console\Output\OutputInterface;

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
        if (!file_exists($filename)) {
            throw new \Exception($filename . ' not found');
        }
        $buffer = file_get_contents($filename);

        $this->info['token'] = token_get_all($buffer);
        $this->info['lines'] = substr_count($buffer, "\n");
        $this->info['methods'] = [];
        unset($buffer);

        Analyzer::analyze($this);
        $this->generateWeight();
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

        if (isset($array['methods'])) {
            foreach ($array['methods'] as $key => $value) {
                if (isset($array['methods'][$key]['content'])) {
                    unset($array['methods'][$key]['content']);
                }
            }
        }

        return $array;
    }

    private function generateWeight()
    {
        $total = 0;
        foreach ($this->info['metrics'] as $value)
            $total += $value;
        $this->info['weight'] = number_format($total, 2);
    }
}
