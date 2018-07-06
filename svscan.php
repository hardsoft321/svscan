#!/usr/bin/env php
<?php
/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author Evgeny Pervushin <pea@lab321.ru>
 */

use GetOpt\GetOpt;
use GetOpt\Option;
use GetOpt\Operand;
use GetOpt\ArgumentException;

require __DIR__ . '/vendor/autoload.php';

define('NAME', 'svscan');
define('VERSION', '1.0.0-alpha');

$getOpt = new GetOpt();

$getOpt->addOptions([
    Option::create(null, 'version', GetOpt::NO_ARGUMENT)
        ->setDescription('Show version information and quit'),
    Option::create('?', 'help', GetOpt::NO_ARGUMENT)
        ->setDescription('Show this help and quit'),
    Option::create('j', 'just-vulnerabilities', GetOpt::NO_ARGUMENT)
        ->setDescription('Print just vulnerabilities found'),
    Option::create('r', 'return', GetOpt::NO_ARGUMENT)
        ->setDescription('Return non-zero error code when vulnerabilities found'),
]);
$getOpt->addOperand(new Operand('file', Operand::MULTIPLE));

try {
    $getOpt->process();
} catch (ArgumentException $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    fwrite(STDERR, 'Use --help option' . PHP_EOL);
    exit(1);
}

if ($getOpt->getOption('version')) {
    echo sprintf('%s: %s' . PHP_EOL, NAME, VERSION);
    exit;
}

if ($getOpt->getOption('help')) {
    echo $getOpt->getHelpText();
    exit;
}

$cmd_files = $getOpt->getOperands();

if (empty($cmd_files)) {
    $cmd_files = ['.'];
}

$context = new \SVScan\Context;
$analyzer = new \SVScan\Analyzer;

$rules = require 'progpilot-rules/index.php';
$context->inputs->read_sinks($rules['sinks']);
$context->inputs->read_sources($rules['sources']);
$context->inputs->read_validators($rules['validators']);
$context->inputs->read_sanitizers($rules['sanitizers']);

$context->outputs->onAddResult = function($result) {
    $source_file = implode(' ', array_unique($result['source_file']));
    $source_name = implode(' ', array_unique($result['source_name']));
    echo "{$source_file} - {$result['vuln_name']} at line {$result['sink_line']}"
        , " ({$result['sink_name']} {$source_name})"
        , PHP_EOL;
};

$context->set_count_analyzed(0);
$analyzer->run($context, $cmd_files);
$results = $context->outputs->get_results();

if (!$getOpt->getOption('just-vulnerabilities')) {
    $count_analyzed = $context->get_count_analyzed();
    echo "# Files scanned: ", $count_analyzed, PHP_EOL;
    echo "# Errors: ", count($results), PHP_EOL;
}

if ($getOpt->getOption('return')) {
    if (!empty($results)) {
        exit(33);
    }
}
