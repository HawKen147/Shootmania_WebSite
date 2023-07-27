function start(e) {
  e.dataTransfer.effectAllowed = "move";
  e.dataTransfer.setData("text", e.target.getAttribute("id"));
}

function over(e) {
  e.currentTarget.className = "droppable2";
  return false;
}

function leave(e) {
  e.currentTarget.className = "droppable";
}

function drop(e) {
  ob = e.dataTransfer.getData("text");
  e.currentTarget.appendChild(document.getElementById(ob));
  e.currentTarget.className = "droppable";
  e.stopPropagation();
  get_drag_drop_elements(e);
  return false;
}

function start_team(e) {
  e.dataTransfer.effectAllowed = "move";
  e.dataTransfer.setData("text", e.target.getAttribute("id"));
}

function over_team(e) {
  e.currentTarget.className = "class2";
  return false;
}

function leave_team(e) {
  e.currentTarget.className = "class1";
}

function drop_team(e) {
  ob = e.dataTransfer.getData("text");
  e.currentTarget.appendChild(document.getElementById(ob));
  e.currentTarget.className = "class1";
  e.stopPropagation();
  get_drag_drop_elements(e);
  return false;
}

function get_drag_drop_elements(e) {
  const droppableElements = document.querySelectorAll(".droppable");
  const numberOfDroppables = droppableElements.length;
  var filledDroppables = 0;
  droppableElements.forEach((droppable) => {
      const draggableElements = droppable.querySelectorAll(".draggable");
      if (draggableElements.length > 0) {
          filledDroppables++;
      }
  });
  if (filledDroppables === numberOfDroppables) {
      document.getElementById('btn_drag_drop').style.display = 'block';
  } else {
      document.getElementById('btn_drag_drop').style.display = 'none';
  }
}