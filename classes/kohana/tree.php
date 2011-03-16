<?php
/**
 * The recursive call has been used only as the "tree walker" and not stacking any output.
 */
class Kohana_Tree
{

    public $rows;
    public $family;

    public $selected_assigned = false;

    public $output = '';

    protected $TAB = "\t";
    protected $NEW_LINE = "\n";
    protected $LEVEL_PREFIX = 'level-';

    protected $ID = 'id';
    protected $PARENT_ID = 'parent_id'; // or pid
    protected $NAME = 'name';

    protected $callbacks = array();

    // protected static $instances;

    /**
     echo tree::factory(DATA ROWS, 3 LEVEL)->li(6, 'selected-item')->ul(#ID, 'class');
     *
     echo tree::factory(DATA ROWS, 3 LEVEL)->ul('tree')->li(3, 'sub')->render();
     echo tree::instance(DEFAULT)->bread_crumb(3);
     */
    public static function factory($rows, $level=null, $reindex_all=false)
    {
        $tree = new Tree;
        $tree->rows = $rows;

        $tree->reindex($reindex_all);

        return $tree;
    }

    /**
     * Produce tree meta data. Only one loop pass of the raw data.
     * @param bool $reindex_all
     * @return void
     */
    protected function reindex($reindex_all=false)
    {
        if ($reindex_all) $temp = array();

        foreach($this->rows as $id=>$row)
        {
            $this->family[$row->{$this->PARENT_ID}][] = $id;
            if ($reindex_all)
            {
                $temp[$row->id] = $row;
            }
        }

        if ($reindex_all) $this->rows = $temp; unset($temp);

        return $this;
    }
    /**
     * Scopes are: item, rel, class
     * @param <type> $scope
     * @param <type> $function
     * @return <type>
     */
    public function set_callback($scope, $function)
    {
        $this->callbacks[$scope] = $function;
        return $this;
    }

    public function ul($pid_start=0, $id='', $class='', $selected_id='null', $selected_class='')
    {
        $this->output = '';

        $this->_list($this->family[$pid_start], 'ul');
        return $this->output;
    }

    public function ol()
    {
        $this->output = '';
        return $this->_list('ol');
    }

    private function _list($members, $type='li', $lvl=0, $class='', $id='')
    {
        if( $id != '' )
        {
            $id = ' id="'.$id.'" ';
        }

        if( $class != '' )
        {
            $class = ' class="'.$class.'" ';
        }

        $this->output .= $this->NEW_LINE.$this->padd(1+$lvl, $this->TAB).'<'.$type.'>';

        foreach ($members as $member)
        {
            $this->output .= $this->NEW_LINE.$this->padd(2+$lvl, $this->TAB).
                    '<li'.$id.$class.'>';

            $this->output .= $this->rows[$member]->name;

            if ( isset ($this->family[$member]))
            {
                // recurse
                ++$lvl;
                $this->output .= $this->padd($lvl, $this->TAB);
                $this->output .= $this->_list($this->family[$member], $type, $lvl,'level-'.$lvl);
                $this->output .= $this->NEW_LINE.$this->padd($lvl, $this->TAB);
            }

            $this->output .= '</li>';
        }

        $this->output .= $this->NEW_LINE.$this->padd($lvl, $this->TAB)
                .'</'.$type.'>'
                .$this->NEW_LINE.$this->padd($lvl, $this->TAB);
    }

    public function li($selected_id='null', $selected_class='selected')
    {
        $this->selected_assigned = true;
        $this->selected_id = $selected_id;
        $this->selected_class = $selected_class;
        return $this;
    }

    public function bread_crumb($id, $saperator)
    {
        $this->path = '';
    }

    protected function trace_ancestor($a)
    {

    }

    private function padd($number, $symbol)
    {
        $padd = '';
        while($number > 0)
        {
            $padd .= $symbol;
            $number--;
        }
        return $padd;
    }

    public function select($pid_start=0)
    {
        $this->output = array();
        return $this->_list_array($this->family[$pid_start]);
    }

    protected function _list_array($members, $lvl=0)
    {
        foreach ($members as $member)
        {

            $this->output[] = $this->rows[$member];

            if ( isset ($this->family[$member]))
            {
                $lvl++;
                $this->_list_array($this->family[$member], $lvl);
            }
        }
    }

    public function __toString()
    {
        return $this->ul();
    }

    /**
     * Garbage <strike>collector</strike> incenerator.
     * @param string $instance
     */
    public function destroy($instance='all')
    {

    }
}