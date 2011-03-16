<?php

class Kohana_Tree {

	private $rows;
	private $family;
	private $parents;
	private $ancestors;
	
	private $output;

	const TAB = "\t";
	const NEW_LINE = "\n";
	
	const PARENT_ID = 'parent_id'; // or pid
	
	protected static $instances;
	
	/**
	echo tree::factory(DATA ROWS, 3 LEVEL)->ul();
	echo tree::instance(DEFAULT)->bread_crumb(3);
	*/
	public function factory($rows, $level, $reindex_all=false)
	{
		$tree = new Tree;
		if($reindex)
		{
			$tree->reindex($reindex_all);
		}
		
		
		return $tree;
	}
	
	protected function reindex($reindex_all=false)
	{
		if ($reindex_all)
		{
			// do appropriate process
		}
		foreach($this->rows as $row)
		{
			$this->parents[$row->id] = $row->{PARENT_ID};
			$this->family[$row->{PARENT_ID}] = $row->id;
			if ( ! $row->{PARENT_ID} )
			{
				$this->ancestors[] = $row->id;
			}
		}
		
		return $this;
	}
	
	public function ul()
	{
	
	}
	
	public function ol()
	{

	}
	
	private function _list($type='ul'){
	
		$this->output = '<'.$type.'>';
	
		foreach ($this->ancestors as $ancestor)
		{
			while($this->family[$ancestor])
			{
			 // recursify
			}
		}
		
		$this->output = '</'.$type.'>';
		
		return $this->output;
	}
	
	private function li()
	{
	
	}
	
	public function bread_crumb($id)
	{
	
	}
	
	public function __toString()
	{
		return $this->ul();
	}
}