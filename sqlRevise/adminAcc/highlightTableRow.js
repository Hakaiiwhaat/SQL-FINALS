document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById('studTable');
    var rows = table.getElementsByTagName('tr');
  
    for (var i = 0; i < rows.length; i++) {
      rows[i].addEventListener('click', function() {
        var current = table.getElementsByClassName('highlighted');
        if (current.length > 0) {
          current[0].classList.remove('highlighted');
        }
        this.classList.add('highlighted');
      });
    }
  });
  