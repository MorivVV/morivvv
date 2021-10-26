<?php
class mTable {
	private $head;
	private $body;
	private $column;
	private $rows;
	private $td_style;
	public function setSize($column, $rows) {
		$this->column = $column;
		$this->rows = $rows;
	}
	public function setStyle($style) {
		$this->td_style = $style;
	}
	public function printTable() {
		$this->body = '<table border=1>';
		for ($i=1;$i<=$this->column;$i++) {
			$this->body .= "<tr>\n";
			for ($j=1;$j<=$this->rows;$j++){
				$this->body .= "<td id=$i-$j $this->td_style></td>\n";
			}
			$this->body .= "</tr>\n";
		}
		echo $this->body;
	}
}
?>