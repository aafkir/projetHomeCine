<?php
if (!isset($_GET['page']) && $_GET['page'] < 1) {
  $_GET['page'] = 1;
}

for ($i = 1;
$i < 6;
$i++) {
?>

<a
  <?php if ($_GET['page'] == 1 && $i == 1) {
    echo "classe='active'";
  } elseif ($_GET['page'] == 2 && $i == 2) {
    echo "classe='active'";
  } elseif ($i == 3 && $_GET['page'] >= 3) {
    echo "classe='active'";
  } ?>
  href="projet.php?<?php if ($_GET['page'] == 1) {
    echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] * $i . ">" . $_GET['page'] * $i . "</a>";
  } else {
    echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] + $i . ">" . $_GET['page'] + $i . "</a>";
  }
  }
  ?>



























  <?php
  if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
  }
  $page_total = $data['total_pages'];
  if (isset($page_total)){
  ?>
  <div class="pagination">
    <?php

    echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=1'>&laquo;</a>";
    if ($_GET['page'] > 1) {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] - 1) . "'>&laquo;</a>";
    } else {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] . "'>&laquo;</a>";
    }
    ?>


    <a <?php if ($_GET['page'] == $data['page']) {echo 'class = "active"';} ?>
      href='projet.php?<?php if ($data['page'] + 4 >= $data['total_pages']){echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page']-4;
      }else{echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'];} ?>'><?php if ($data['page'] + 4 >= $data['total_pages']) {
        echo($page_total - 4);
      } else {
        echo($_GET['page']);
      } ?></a>

    <a <?php if (($_GET['page'] + 1) == $data['page']) {
      echo 'class = "active"';
    } ?>
      href='projet.php?<?php if ($_GET['page'] + 4 >= $data['total_pages']) { echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page']+1);
      } else{ echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] + 1);} ?>'><?php if ($_GET['page'] + 4 >= $data['total_pages']) {
        echo($page_total - 3);
      } else {
        echo($_GET['page'] + 1);
      } ?></a>

    <a <?php if (($_GET['page'] + 2) == $data['page']) {
      echo 'class = "active"';
    } ?>
      href='projet.php?<?php echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] + 2) ?>'><?php if ($_GET['page'] + 4 >= $data['total_pages']) {
        echo $page_total - 2;
      } else {
        echo $_GET['page'] + 2;
      } ?></a>

    <a <?php if (($_GET['page'] + 3) == $data['page']) {
      echo 'class = "active"';
    } ?>
      href='projet.php?<?php echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] + 3) ?>'><?php if ($_GET['page'] + 4 >= $data['total_pages']) {
        echo($page_total - 1);
      } else {
        echo($_GET['page'] + 3);
      } ?></a>

    <a <?php if (($_GET['page'] + 4) == $data['page']) {
      echo 'class = "active"';
    } ?>
      href='projet.php?<?php if ($_GET['page'] + 4 >= $data['total_pages']) echo "type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] + 4) ?>'><?php if ($_GET['page'] + 4 >= $data['total_pages']) {
        echo($page_total);
      } else {
        echo($_GET['page'] + 4);
      } ?></a>
    <?php
    if ($_GET['page'] < $data['total_pages']) {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . ($_GET['page'] + 1) . "'>&raquo;</a>";
    } else {
      echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $_GET['page'] . "'>&raquo;</a>";
    }
    echo "<a href='projet.php?type=" . $_GET['type'] . "&amp;id=" . $_GET['id'] . "&amp;page=" . $data['total_pages'] . "'>&raquo;</a>";
    echo "</div>";
    }
    ?>









