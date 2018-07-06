<?php
namespace SVScan;

class Context extends \progpilot\Context
{
    private $count_analyzed;

    public function __construct()
    {
        parent::__construct();
        $this->inputs = new MyInputs;
        $this->outputs = new MyOutputs;
    }

    public function get_count_analyzed()
    {
        return $this->count_analyzed;
    }

    public function set_count_analyzed($count)
    {
        $this->count_analyzed = $count;
    }
}
