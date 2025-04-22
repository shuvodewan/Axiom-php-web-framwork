<?php
namespace Axiom\Support;

use Axiom\Console\Preview;
use Axiom\Core\Application;

class DD
{
    public function run($vars){
        $isConsole = Application::getInstance()->isConsole();
        
        if ($isConsole) {
            foreach ($vars as $var) {
                Preview::info(print_r($var, true));
            }
        } else {
            echo <<<HTML
            <style>
                body {
                    font-family: "Arial", sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #333;
                    color: #fff;
                    font-size: 14px;
                    line-height: 1.5;
                }
                .dd-container {
                    padding: 20px;
                    max-width: 900px;
                    margin: 50px auto;
                    background-color: #222;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.5);
                }
                .dd-item {
                    margin-bottom: 20px;
                    border-bottom: 1px solid #444;
                    padding-bottom: 15px;
                }
                .dd-item:last-child {
                    border-bottom: none;
                }
                pre {
                    color: #fff;
                    background-color: #1a1a1a;
                    padding: 15px;
                    border-radius: 3px;
                    overflow-x: auto;
                    margin: 0;
                    tab-size: 4;
                }
                .dd-header {
                    font-size: 20px;
                    color: #ffcc00;
                    padding-bottom: 10px;
                    margin-bottom: 15px;
                    border-bottom: 1px solid #444;
                }
                .dd-type {
                    color: #88ccff;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                .dd-file {
                    color: #aaa;
                    font-size: 12px;
                    margin-top: 20px;
                    font-style: italic;
                }
            </style>
            <div class="dd-container">
                <div class="dd-header">Debug Dump</div>
            HTML;

            $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0] ?? null;
            
            foreach ($vars as $var) {
                echo '<div class="dd-item">';
                echo '<div class="dd-type">' . gettype($var) . '</div>';
                echo '<pre>';
                echo htmlspecialchars(print_r($var, true));
                echo '</pre>';
                echo '</div>';
            }

            if ($caller) {
                echo '<div class="dd-file">';
                echo 'Dumped from: ' . ($caller['file'] ?? 'unknown') . ' on line ' . ($caller['line'] ?? 'unknown');
                echo '</div>';
            }

            echo '</div>';
        }
       
        die(1);
    }
}