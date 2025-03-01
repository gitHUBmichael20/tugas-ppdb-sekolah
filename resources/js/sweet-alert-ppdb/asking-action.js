function confirmAction(event, actionType, pendaftaranId) {
  event.preventDefault(); // Prevent form submission immediately

  const title =
    actionType === "accept" ? "Terima Pendaftaran?" : "Tolak Pendaftaran?";
  const text =
    actionType === "accept"
      ? `Apakah Anda yakin ingin menerima pendaftaran dengan ID ${pendaftaranId}?`
      : `Apakah Anda yakin ingin menolak pendaftaran dengan ID ${pendaftaranId}?`;
  const confirmButtonText =
    actionType === "accept" ? "Ya, Terima" : "Ya, Tolak";
  const confirmButtonColor = actionType === "accept" ? "#3085d6" : "#d33";

  Swal.fire({
    title: title,
    text: text,
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: confirmButtonColor,
    cancelButtonColor: "#6c757d",
    confirmButtonText: confirmButtonText,
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      // If confirmed, submit the form
      event.target.submit();
    }
  });

  return false; // Prevent default submission until confirmed
}
