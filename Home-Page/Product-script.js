const products = [
    {
        name: "Iphone-15 pro-max",
        image: "iphone-15.webp",
        price: "$1,299.99",
        rating: 4.5 
    },
    {
        name: "Ozeino ZW1 Gaming",
        image: "accessories_image.jpg",
        price: "$33.99",
        rating: 3.5 
    },
    {
        name: "Prism AMD Custom ",
        image: "Desktop-2.jpg",
        price: "$1,900.99",
        rating: 4.2 
    },
    {
        name: "VIDAA SLE 32S702TCS ",
        image: "Tv1.jpg",
        price: "$215.99",
        rating: 3.2 
    },
    {
        name: "MSI Raider GE68HX 16",
        image: "Laptop2.webp",
        price: "$1,900.99",
        rating: 4.2 
    },
    {
        name: "Gaming chair",
        image: "Gaming chair.jpg",
        price: "$59.99",
        rating: 4.2 
    },
    {
        name: "PlayStation 4 => 1TB ",
        image: "ps1.jpg",
        price: "$515",
        rating: 3.9 
    },
    {
        name: "Redragon gaming keyboard",
        image: "keyboard1.jpg",
        price: "$38.45",
        rating: 2.2 
    },  
    {
        name: "Meta Quest 2",
        image: "vr1.jpg",
        price: "$177.99",
        rating: 3.4 
    },
    {
        name: "Crash Bandicoot N. Sane",
        image: "game1.jpg",
        price: "$31.29",
        rating: 3.4 
    },
    {
        name: "UtechSmart Gaming Mouse",
        image: "mouse1.jpg",
        price: "$47.29",
        rating: 3.4 
        
    },
    {
        name: "Samsung S24",
        image: "samsungs24.jpg",
        price: "$1,299.45",
        rating: 4.2 
        
    },
    {
        name: "Dash Cam WiFi 2.5K 1440P ",
        image: "projector1.jpg",
        price: "$43.45",
        rating: 4.2 
        
    },
    {
        name: "Apple AirPods Pro 2nd Gen",
        image: "airpod1.jpg",
        price: "$177.45",
        rating: 4.2 
        
    },
    {
        name: "Wireless Charger for apple",
        image: "WirelessCharger.jpg",
        price: "$1,299.45",
        rating: 4.2 
        
    },

];


function createProductBox(product) {
    const box = document.createElement('div');
    box.classList.add('product-box');


    const img = document.createElement('img');
    img.src = product.image;
    box.appendChild(img);


    const name = document.createElement('h5');
    name.textContent = product.name;
    box.appendChild(name);


    const price = document.createElement('p');
    price.textContent = `Price: ${product.price}`;
    price.classList.add('price'); 
    box.appendChild(price);

    const rating = document.createElement('p');
    rating.classList.add('rating');
    rating.textContent = 'Rating: ';
    const stars = document.createElement('span');
    stars.innerHTML = '&#9733;'.repeat(product.rating) + '&#9734;'.repeat(5 - product.rating);
    rating.appendChild(stars);
    box.appendChild(rating);


    const addToCartBtn = document.createElement('button');
    addToCartBtn.textContent = "Add to Cart";
    box.appendChild(addToCartBtn);


    document.getElementById('product-container').appendChild(box);
}


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

function generateProductBoxes() {
    products.forEach(product => {
        createProductBox(product);
    });
}


window.onload = function() {
    generateProductBoxes();
    
    document.addEventListener('mousemove', handleMouseMove);
};
