<?php
class testDispatcher {
    private $_testsPath = 'tests/';
    /**
     *
     * @param array $tests
     */
    function __construct(array $tests) {
        foreach ($tests as $test):
            include_once $this->_testsPath.$test.'.php';
            $this->{$test} = new $test();
        endforeach;
    }

    function run($test) {
        $test = (string) $test;
        $actions = [];
        $methods = get_class_methods($this->{$test});
        foreach ($methods as $method):
            preg_match('/[a-zA-Z0-9]+Test/', $method, $match);
            if (sizeof($match) === 1):
                $actions[] = $method;
            endif;
        endforeach;

        foreach ($actions as $action):
            $this->{$test}->{$action}();
        endforeach;

        fwrite(STDOUT, "\n");
    }
}