function handleMouseMove(event) {
    const productBoxes = document.querySelectorAll('.product-box');
    productBoxes.forEach(box => {
        const rect = box.getBoundingClientRect();
        const mouseX = event.clientX;
        const mouseY = event.clientY;
        const isClose = mouseX >= rect.left && mouseX <= rect.right && mouseY >= rect.top && mouseY <= rect.bottom;
        if (isClose) {
            box.classList.add('pop-up');
        } else {
            box.classList.remove('pop-up');
        }
    });
}

document.addEventListener('mousemove', handleMouseMove);