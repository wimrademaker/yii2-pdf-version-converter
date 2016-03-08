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
use yii\base\UserException;

/**
 * Converter that uses ghostscript to change PDF version.
 *
 * @author Thiago Rodrigues <xthiago@gmail.com>
 */
class GhostscriptConverter implements ConverterInterface
{

    /**
     * @var GhostscriptConverterCommand
     */
    protected $command;

    /**
     * Directory where temporary files are stored.
     * @var string
     */
    protected $tmp = sys_get_temp_dir();

    /**
     * @param GhostscriptConverterCommand $command
     * @param null|string $tmp
     */
    public function __construct(GhostscriptConverterCommand $command, $tmp = null)
    {
        $this->command = $command;
  
        if ($tmp){
            $this->$tmp = $tmp;
		}
    }

    /**
     * Generates a unique absolute path for tmp file.
     * @return string absolute path
     */
    protected function generateAbsolutePathOfTmpFile()
    {
        return $this->tmp .'/'. uniqid('pdf_version_changer_') . '.pdf';
    }

    /**
     * {@inheritdoc }
     */
    public function convert($file, $newVersion)
    {
        $tmpFile = $this->generateAbsolutePathOfTmpFile();

        $this->command->run($file, $tmpFile, $newVersion);

        if (!file_exists($tmpFile)){
            throw new \RuntimeException("The generated file '{$tmpFile}' was not found.");
		}

        copy($tmpFile, $file);
    }
}
