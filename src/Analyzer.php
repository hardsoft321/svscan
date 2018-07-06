<?php
namespace SVScan;

class Analyzer extends \progpilot\Analyzer
{
    public function run_internal($context, $defs_included = null)
    {
        parent::run_internal($context, $defs_included);
        //TODO: actually analysis can be skipped due to limits or unreadable/nonexisting files
        $count_analyzed = $context->get_count_analyzed();
        $context->set_count_analyzed($count_analyzed + 1);
    }

    /**
     * Just reading rules is removed in this override
     */
    public function run($context, $cmd_files = null)
    {
        if (empty($cmd_files)) {
            return;
        }

        $files = [];

        foreach ($cmd_files as $cmd_file) {
            if (is_dir($cmd_file)) {
                $this->get_files_ofdir($context, $cmd_file, $files);
            } else {
                $files[] = $cmd_file;
            }
        }

        foreach ($files as $file) {
            $context->set_current_nb_defs(0);
            $myfile = new \progpilot\Objects\MyFile($file, 0, 0);
            $context->inputs->set_file($file);
            $context->set_current_myfile($myfile);
            $context->reset_dataflow();
            $this->run_internal($context);
        }
    }
}
