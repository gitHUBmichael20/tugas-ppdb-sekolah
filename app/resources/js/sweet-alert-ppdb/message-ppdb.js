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