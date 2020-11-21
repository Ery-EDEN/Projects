var pupus = document.querySelector('.ballon');
pupus.addEventListener('webkitAnimationEnd',function( event ) { 
	pupus.style.display = 'none'; 
}, false);
var pupu = document.querySelector('#pouet');
pupu.addEventListener('webkitAnimationEnd',function( event ) { 
	pupu.style.display = 'none'; 
}, false);
