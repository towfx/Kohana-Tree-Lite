
Simple Tree
===========

Provide easy, fast and efficient tree rebuiding.

API Usage
---------

  $rows = DB::select('id', 'parent_id', 'name')->from('menu')->get();

  echo tree::factory($rows)->ul(); 

  // produce

  <ul>
    <li>Abc</li>
    <li>Def
      <ul>
        <li>Ghi</li>
        <li>Jkl</li>
      </ul>
    </li>
  </ul>

  echo tree::factory($rows)->li(3)->ul(); 

  // to give li id=3 class=selected

  <ul>
    <li>Abc</li>
    <li>Def
      <ul>
        <li class="selected">Ghi</li>
        <li>Jkl</li>
      </ul>
    </li>
  </ul>

Technical Notes
---------------

1. No additional SQL query in processing.
2. Recursive only for tree walking, no excessive child stacks.
3. total loops, 2 time of rows. 1st for family gathering, 2nd for tree buiding.