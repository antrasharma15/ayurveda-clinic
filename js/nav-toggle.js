// Simple nav toggle for small screens
document.addEventListener('DOMContentLoaded', function(){
  var btn = document.getElementById('navToggle');
  var nav = document.getElementById('mainNav');
  if(!btn || !nav) return;
  btn.addEventListener('click', function(){
    if(nav.style.display === 'flex' || nav.style.display === 'block'){
      nav.style.display = 'none';
    } else {
      nav.style.display = 'flex';
    }
  });
});
