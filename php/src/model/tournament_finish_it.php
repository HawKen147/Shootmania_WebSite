<div>
  <button class="button" id="myBtn">Click to finish the cup</button>
</div>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="center">
      <h3>Choose the winning teams</h3>
      <?php
        if (isset($_SESSION['err'])){
          echo $_SESSION['err'];
          unset($_SESSION['err']);
        }
      ?>
      <div class="container">
        <div onDragStart="start_team(event)" onDragLeave="leave_team(event)"; OnDragOver="return over_team(event)" onDrop="return drop_team(event)" class="class1">
          <?php
          $id_tournament = $_SESSION['id_tournament'];
          $teams = print_team_signed_up($id_tournament);
            foreach($teams as $team){
              echo '<div class="draggable" draggable="true" id="' . $team['name'] . '" data-team="' . $team['id'] . '">' . $team['name'] . '</div>';
            }
          ?>
        </div>
          <?php
            for ($i = 1; $i < count($teams) + 1; $i++){
              if($i == 1){
                echo '<span class="result">Winner</span>';
                echo '<div id ="' . $i . '"class="droppable" onDragStart="start(event)" onDragLeave="leave(event)"; OnDragOver="return over(event)" onDrop="return drop(event)">drop the winner team here</div>';
              }
              if($i == 2){
                echo '<span  class="result">Second</span>';
                echo '<div id ="' . $i . '" class="droppable" onDragStart="start(event)" onDragLeave="leave(event)"; OnDragOver="return over(event)" onDrop="return drop(event)">drop the second team here</div>';
              }
              if($i == 3){
                echo '<span  class="result">Third</span>';
                echo '<div id ="' . $i . '" class="droppable" onDragStart="start(event)" onDragLeave="leave(event)"; OnDragOver="return over(event)" onDrop="return drop(event)">drop the third team here</div>';
              }
              if($i > 3){
                echo '<span  class="result">' . $i . 'th</span>';
                echo '<div id ="' . $i . '" class="droppable" onDragStart="start(event)" onDragLeave="leave(event)"; OnDragOver="return over(event)" onDrop="return drop(event)">drop the ' . $i . 'th team here</div>';
              }
            }
          ?>
      </div>
      <input type="submit" value="Envoyer" class="button" id="btn_drag_drop" style="display: none;">
    </div>
  </div>
</div>

<script src="../JS/ajax_drag_drop.js"></script>
<script src="../JS/drag_drop.js"></script>