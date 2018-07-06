<?php
namespace SVScan;

class MyOutputs extends \progpilot\Outputs\MyOutputs
{
    public $onAddResult;

    public function add_result($result)
    {
        $results1 = $this->get_results();
        $count1 = count($results1);
        parent::add_result($result);
        $results2 = $this->get_results();
        $count2 = count($results2);
        if (!empty($this->onAddResult) && $count2 != $count1 ) {
            call_user_func($this->onAddResult, $result);
        }
    }
}
