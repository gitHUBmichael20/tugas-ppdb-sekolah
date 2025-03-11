function confirmAction(event, actionType, pendaftaranId) {
  event.preventDefault();
  let title;
  let text;
  let confirmButtonText;
  let confirmButtonColor;

  if (actionType === "accept") {
    title = "Terima Pendaftaran?";
    text =
      "Apakah Anda yakin ingin menerima pendaftaran dengan ID " +
      pendaftaranId +
      "?";
    confirmButtonText = "Ya, Terima";
    confirmButtonColor = "#3085d6";
  } else if (actionType === "verifikasi") {
    title = "Verifikasi Pendaftaran?";
    text =
      "Apakah Anda yakin ingin memverifikasi pendaftaran dengan ID " +
      pendaftaranId +
      "?";
    confirmButtonText = "Ya, Verifikasi";
    confirmButtonColor = "#f1c40f"; // Warna kuning untuk tombol verifikasi
  } else {
    title = "Tolak Pendaftaran?";
    text =
      "Apakah Anda yakin ingin menolak pendaftaran dengan ID " +
      pendaftaranId +
      "?";
    confirmButtonText = "Ya, Tolak";
    confirmButtonColor = "#d33";
  }

  Swal.fire({
    title: title,
    text: text,
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: confirmButtonColor,
    cancelButtonColor: "#6c757d",
    confirmButtonText: confirmButtonText,
    cancelButtonText: "Batal",
  }).then(function (result) {
    if (result.isConfirmed) {
      event.target.submit();
    }
  });

  return false;
}
