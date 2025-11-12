function validateForm() {
    const seed=document.getElementById("seed_name").value.trim();
    const email=document.getElementById("email").value.trim();
    const password=document.getElementById("password").value.trim();
    const quantity=document.getElementById("quantity").value.trim();
    
    if(seed === "" || email === "" || password === "" || quantity === "") {
        alert("All fields are required.");
        return false;
    }
    if(!email.includes("@")) {
        alert("Please enter a valid email address.");
        return false;
    }
    if(isNaN(quantity) || quantity <= 0) {
        alert("Please enter a valid quantity.");
        return false;
    }
    return confirm("Add this seed to inventory?");
}
