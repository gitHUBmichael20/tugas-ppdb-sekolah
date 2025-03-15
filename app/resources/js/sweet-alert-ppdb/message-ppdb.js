function showAlert(message, type = "success") {
  Swal.fire({
    text: message,
    icon: type, // 'success' atau 'error'
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
  });
}

function showErrorAlert(message, type = "error") {
  Swal.fire({
    text: message,
    icon: type, // defaults to 'error'
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
  });
}
