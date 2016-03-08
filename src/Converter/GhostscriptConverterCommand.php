<?php

/*
 * This file is part of the yii2 PDF Version Converter.
 *
 * (c) Thiago Rodrigues <xthiago@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace wimrademaker\PDFVersionConverter\Converter;

/**
 * Encapsulates the knowledge about gs command.
 *
 * @author Thiago Rodrigues <xthiago@gmail.com>
 */
class GhostscriptConverterCommand
{
	private $__err;
	private $__output;

	private $__gsbinary = "gs";
    protected $baseCommand = '-sDEVICE=pdfwrite -dCompatibilityLevel=%s -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=%s %s';

	public function setGSBinary($s) {
		$this->gsbinary = $s;
	} 

    public function run($originalFile, $newFile, $newVersion)
    {
        $command = $this->gsbinary.' '.sprintf($this->baseCommand, $newVersion, $newFile, $originalFile);
		$ps = $this->psexec($command);
        if ($ps === false) {
            throw new \RuntimeException("Execution of command failed: ".$command." with error: ".$this->err);
        }
    }


	private function psexec($cmd) {
	
		$descriptorspec = array(
		   0 => array("pipe", "r"),
		   1 => array("pipe", "w"),
		   2 => array("pipe", "w")
		);

		$process = proc_open(
			$cmd,
			$descriptorspec,
			$pipes, 
			sys_get_temp_dir(), 
			NULL, 
			array('bypass_shell' => TRUE)
		);
				
		if(!is_resource($process)) {
			$this->err = "Unable to open process.";
			return false;
		}

		if(!$pipes[1]) {
			$this->err = "Unable to execute the command, no output.";
			return false;
		}

		$this->output = stream_get_contents($pipes[1]);
		fclose($pipes[1]);
		$this->err = stream_get_contents($pipes[2]);
		fclose($pipes[2]);
	
		return proc_close($process) == 0 ? true : false;	
	}
		


}
