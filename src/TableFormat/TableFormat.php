<?php

namespace src;

class TableFormat
{
    protected $data;
    private $columnsWidth;

    public function __construct(array $data, array $moveNames)
    {
        $this->prepareData($data, $moveNames);
        $this->data = $data;
        $this->calculateColumnsWidth($data);
    }

    public function format()
    {
        $out = '';
        foreach ($this->data as $item) {
            $out .= $this->getRowSeparator();
            $out .= $this->getRow($item);
        }
        $out .= $this->getRowSeparator();
        return $out;
    }

    private function prepareData(array &$data, array $moveNames)
    {
        foreach ($data as $key => &$row){
            array_unshift($row, $moveNames[$key]);
        }
        unset($row);
        array_unshift($moveNames, ' ');
        array_unshift($data, $moveNames);
    }
    protected function getRow(array $row)
    {
        $out = '';
        foreach ($row as $columnNumber => $cell) {
            $out .= "| $cell " . str_repeat(' ', $this->columnsWidth[$columnNumber] - strlen($cell));
        }

        return $out . "|\n";
    }

    protected function getRowSeparator()
    {
        $out = '';
        foreach ($this->data[0] as $columnNumber => $cell) {
            $out .= '+' . str_repeat('-', $this->columnsWidth[$columnNumber] + 2);
        }
        $out .= "+\n";

        return $out;
    }

    protected function calculateColumnsWidth(array $data)
    {
        foreach ($data as $row) {
            foreach ($row as $columnNumber => $cell) {
                $this->columnsWidth[$columnNumber] = max(strlen($cell),
                    isset($this->columnsWidth[$columnNumber]) ? $this->columnsWidth[$columnNumber] : 0);
            }
        }
    }
}