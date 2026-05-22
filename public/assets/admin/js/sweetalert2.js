// function deleteAccount(accountId) {
//     // Show the SweetAlert2 confirmation dialog
//     Swal.fire({
//         title: 'Are you sure?',
//         text: "This action can't be reversed.",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Delete',
//         cancelButtonText: 'ancel',
//         reverseButtons: true
//     }).then((result) => {
//         if (result.isConfirmed) {
//             // If the user confirms, submit the form
//             document.getElementById('deleteForm_' + accountId).submit();
//         }
//     });
// }

function deleteAccount(button, itemId) {
    const title = button.dataset.title || 'Delete Record';
    const description = button.dataset.description || 'This action cannot be undone.';

    Swal.fire({
        html: `
            <div class="delete-header">
                <p>${title}</p>
                <button type="button" aria-label="Close" onclick="Swal.close()" style="border: none; background: transparent; font-size: 20px; color: #fff;">&times;</button>
            </div>
            <div class="delete-body">
                <p>${description}</p>
            </div>
            <div class="delete-footer">
                <button class="swal2-cancel swal2-styled cancel-btn" onclick="Swal.close()">Cancel</button>
                <button class="swal2-confirm swal2-styled delete-btn" onclick="document.getElementById('deleteForm_${itemId}').submit()">Delete</button>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            popup: 'custom-swal-popup'
        }
    });
}


function confirmClearLogs(button, itemId) {
    const title2 = button.dataset.title || 'Delete Record';
    const description2 = button.dataset.description || 'This action cannot be undone.';

    Swal.fire({
        html: `
            <div style="display: flex; justify-content: space-between; align-items: center; background-color: #ff313a; padding: 10px 15px;">
                <p style="margin: 0; color: #fff; font-size: 14px;">${title2}</p>
                <button type="button" aria-label="Close" onclick="Swal.close()" style="border: none; background: transparent; font-size: 20px; color: #fff;">&times;</button>
            </div>
            <div style="margin-top: 20px; font-size: 15px;">
                <p>${description2}</p>
                <div style="display: flex; justify-content: space-between; padding: 8px 13px;">
                    <button class="swal2-cancel swal2-styled" onclick="Swal.close()">Cancel</button>
                    <button class="swal2-confirm swal2-styled" style="background-color: #d33;" onclick="document.getElementById('deleteLogForm').submit()">Delete</button>
                </div>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            popup: 'custom-swal-popup'
        }
    });
}