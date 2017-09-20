<?php
namespace Insphptor\Analyzer;

use Insphptor\Helpers\SyntaxCheckerHelper;

class AnalyzedClass
{
    private $info = [];

    public function __construct(string $filename)
    {
        $this->info['filename'] = $filename;
        $buffer = file_get_contents($filename);

        if (!SyntaxCheckerHelper::run([$filename])) {
            throw new \Exception($filename . ' have invalid syntax!');
        }

        $this->info['token'] = token_get_all($buffer);
        $this->info['lines'] = substr_count($buffer, "\n");
        unset($buffer);
    }

    public function __get(string $attribute)
    {
        if (key_exists($attribute, $this->info)) {
            return $this->info[$attribute];
        }

        return null;
    }

    public function getAttributes() : array
    {
        return $this->info;
    }

    public function print(string $prefix = null, array $array = null)
    {
        $array = $array ?? $this->info;
        foreach ($array as $key => $value) {
            if (!in_array($key, ['token', 'filename'])) {
                if (is_array($value)) {
                    if (!in_array($key, ['content'])) {
                        echo color($key)->magenta . EOL;
                        $this->print(TAB, $value);
                    }
                } else {
                    echo $prefix . color($key)->bold . ' = ' . $value . EOL;
                }
            }
        }
        if ($array == $this->info) {
            echo '-----------------------' . EOL;
        }
    }

    public function pushAttribute(string $name, $value)
    {
        $this->info[$name] = $value;
    }

    public function pushMetric(string $name, $value)
    {
        $this->info['metrics'][$name] = $value;
    }

    public function __toString() : string
    {
        return $this->info['filename'];
    }

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
