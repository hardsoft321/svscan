<?php
namespace SVScan;

class MyInputs extends \progpilot\Inputs\MyInputs
{
    public function read_sanitizers($files = null)
    {
        if ($files === null) {
            parent::read_sanitizers();
            return;
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->read_sanitizers($file);
            }
            return;
        }
        $this->set_sanitizers($files);
        parent::read_sanitizers();
    }

    public function read_sinks($files = null)
    {
        if ($files === null) {
            parent::read_sinks();
            return;
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->read_sinks($file);
            }
            return;
        }
        $this->set_sinks($files);
        parent::read_sinks();
    }

    public function read_sources($files = null)
    {
        if ($files === null) {
            parent::read_sources();
            return;
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->read_sources($file);
            }
            return;
        }
        $this->set_sources($files);
        parent::read_sources();
    }

    public function read_validators($files = null)
    {
        if ($files === null) {
            parent::read_validators();
            return;
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->read_validators($file);
            }
            return;
        }
        $this->set_validators($files);
        parent::read_validators();
    }
}
