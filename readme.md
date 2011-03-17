
Simple Tree
===========

Provide easy, fast and efficient herachical tree rebuiding.

API Usage
---------

  $rows = DB::select('id', 'parent_id', 'name')
          ->from('menu')->orderby('order')->get();

  echo tree::factory($rows)->ul('menu', 'primary');

  // produce

  <ul id="menu" class="primary">
    <li>Abc</li>
    <li>Def
      <ul>
        <li>Ghi</li>
        <li>Jkl</li>
      </ul>
    </li>
  </ul>

  echo tree::factory($rows)->li(3, 'selected')->ul();

  // to give menu id=3 class=selected

  <ul>
    <li>Abc</li>
    <li>Def
      <ul>
        <li class="selected"> Ghi </li>
        <li>Jkl</li>
      </ul>
    </li>
  </ul>

  echo tree::factory($rows)->callback('item', array( =>)))->ul();

  // simple item reformatting

  <ul>
    <li><div id="3"><a href="/link/3">Ghi</a></div></li>
  </ul>

  $list = tree::factory($rows)->select('&raquo;');
  html::dropdown();


Technical Notes
---------------

1. No additional SQL query in tree processing.
2. Recursive only for tree walking, no excessive child stacks.
3. total loops=2n, 2 time of rows. 1st for family gathering, 2nd for tree building.
4. utilize PHP array hash lookups.