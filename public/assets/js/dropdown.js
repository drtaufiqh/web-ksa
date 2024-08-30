document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdownMenuOutlineButton5');
    const dropdownItems = document.querySelectorAll('#tahun');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedText = this.textContent.trim();
            dropdownButton.textContent = selectedText;
        });
    });
})

document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdownMenuOutlineButton6');
    const dropdownItems = document.querySelectorAll('#bulan');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedText = this.textContent.trim();
            dropdownButton.textContent = selectedText;
        });
    });
})

document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdownMenuOutlineButton8');
    const dropdownItems = document.querySelectorAll('#tahun');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedText = this.textContent.trim();
            dropdownButton.textContent = selectedText;
        });
    });
})

document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdownMenuOutlineButton9');
    const dropdownItems = document.querySelectorAll('#bulan');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedText = this.textContent.trim();
            dropdownButton.textContent = selectedText;
        });
    });
})

document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdownMenuOutlineButton7');
    const dropdownItems = document.querySelectorAll('#segmen');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const selectedText = this.textContent.trim();
            dropdownButton.textContent = selectedText;
        });
    });
})