import './bootstrap';


function showToast(type, message) {
    const toast = document.createElement('div');
    toast.classList.add('toast', type); // Assuming you have classes for toast types

    toast.innerHTML = message;

    // Append the toast to the body or a specific container
    document.body.appendChild(toast);

    // Optionally, add some styles for positioning
    toast.style.position = 'fixed';
    toast.style.top = '10px';
    toast.style.right = '10px';
    toast.style.padding = '10px';
    toast.style.backgroundColor = (type === 'success') ? 'green' : 'red';
    toast.style.color = 'white';
    toast.style.borderRadius = '5px';

    // Set a timeout to remove the toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
