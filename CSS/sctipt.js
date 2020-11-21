const navSlider = () => {
	const burger = document.querySelector('.burger');
	const nav = document.querySelector('ul');
	const navLinks = document.querySelectorAll('ul li');
	let isPressed = false;

	burger.addEventListener('click', () => {
		if(isPressed === false)  {
			nav.style.display = 'block';
			nav.style.transition = '1s';
			nav.style.transform = 'translateX(0%)';
			isPressed = true;
		} else if (isPressed === true) {
			nav.style.transition = '1s';
			nav.style.transform = 'translateX(100%)';
			nav.style.display = 'none';
			isPressed = false;
		}
		navLinks.forEach((link, index) => {
			if(link.style.animation) {
				link.style.animation = "";
			} else {
				link.style.animation = `navLinkFade 0.5s ease forwards ${index / 5}s`;
			}
		});
		burger.classList.toggle('toggle');
	});
	
}
navSlider();
