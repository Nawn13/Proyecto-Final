document.addEventListener('DOMContentLoaded', function () {
    const createFolderBtn = document.getElementById('create-folder');
    const fileInput = document.getElementById('file-input');
    const foldersList = document.getElementById('folders');
    const filesList = document.getElementById('files');

    createFolderBtn.addEventListener('click', function () {
        const folderName = prompt('Ingrese el nombre de la carpeta:');
        if (folderName) {
            const newFolder = document.createElement('li');
            const folderLink = document.createElement('a');
            folderLink.href = '#';
            folderLink.textContent = folderName;
            newFolder.appendChild(folderLink);
            foldersList.appendChild(newFolder);
        }
    });

    fileInput.addEventListener('change', function (e) {
        const files = e.target.files;

        // Limpiar la lista de archivos antes de agregar nuevos archivos
        filesList.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const fileName = files[i].name;
            const newFile = document.createElement('li');
            const fileLink = document.createElement('a');
            fileLink.href = '#';
            fileLink.textContent = fileName;
            newFile.appendChild(fileLink);
            filesList.appendChild(newFile);
        }
    });

    filesList.addEventListener('mouseover', function (e) {
        if (e.target.tagName === 'A') {
            e.target.style.cursor = 'pointer';
        }
    });
});
