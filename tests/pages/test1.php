<?php

namespace Foo\Bar;

class Base
{
    public function get()
    {
        if (true) {
            return (true) ? 'ok' : 'fail';
        }
        return 'none';
    }
}
