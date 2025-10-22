// 1 Task
setTimeout(() => {
    let imagesUrl = [
        "https://t2.genius.com/unsafe/258x258/https%3A%2F%2Fimages.genius.com%2F3befd831f47fbd6b1a8e8773b9d701f1.1000x1000x1.png",
        "https://t2.genius.com/unsafe/258x258/https%3A%2F%2Fimages.genius.com%2F1c7b05c05a17035ec8c7c09cd034c087.1000x1000x1.png",
        "https://images.genius.com/c41a2c2daf4a3412ff1ebb5af8b8e589.1000x1000x1.png",
        "https://images.genius.com/0bc94e0dc49c7b8cb7257ce9fd7bdb1f.1000x1000x1.png",
        "https://upload.wikimedia.org/wikipedia/en/thumb/3/36/Remember_Monday_-_What_the_Hell_Just_Happened%3F_cover_art.jpg/250px-Remember_Monday_-_What_the_Hell_Just_Happened%3F_cover_art.jpg"
    ];
    
    imagesUrl.forEach((url, i) => {
        
        setTimeout(() => {
            
            let span = document.getElementById('gallery'+i);
            
            if (span) {
                let img = document.createElement("img");
                img.src = url;
                span.appendChild(img);
            }
            
        }, i * 1000); 
    });

}, 5000);


//Check email, password etc 
const loginRegex = /^[a-zA-Z0-9_\-]{3,20}$/;
    const password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;

    const form = document.querySelector('form');
    const loginInput = document.getElementById('login');
    const passwordInput = document.getElementById('password');

    form.addEventListener('submit', function(event) {
        
        const loginValue = loginInput.value.trim();
        const passwordValue = passwordInput.value;

        let validationFailed = false;

        if (!loginRegex.test(loginValue)) {
            validationFailed = true;
        }

        if (!passwordRegex.test(passwordValue)) {
            validationFailed = true;
        }

        if (validationFailed) {
            event.preventDefault();
        }
    });